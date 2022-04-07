<?

class Application
{

  private $dbParams = array(
    "servername" => 'localhost',
    'username' => 'root',
    'password' => 'valami',
    'dbname' => 'library'
  );

  private $connection;
  private $connectionLive = false;

  protected $table = '';
  protected $fields = array();


  protected $id = null;


  public function __construct()
  {
    $this->connectDb();
    include_once("Utils/Messages.php");
    $this->msg = new Messages();
  }


  private function connectDb()
  {
    $this->connection = new mysqli($this->dbParams['servername'], $this->dbParams['username'], $this->dbParams['password'], $this->dbParams['dbname']);

    if ($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
    $this->connectionLive = true;
  }

  protected function isDbConnectionLive()
  {
    return $this->connectionLive;
  }

  protected function getResultList($sql)
  {
    $resultList = array();
    $result = $this->connection->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $resultList[] = $row;
      }
    } else {
      $this->writeLog("Nem talált értéket a lekérdezés", $sql);
    }

    return $resultList;
  }

  protected function getSingleResult($sql)
  {
    $resultList = $this->getResultList($sql);

    if (!$resultList) {
      $this->writeLog("nem talált értéket a lekérdezés", $sql);
      return array();
    } else {
      return $resultList[0];
    }
  }

  public function writeLog($string, $sql = null)
  {
    $logStr = $string;

    if ($sql !== null) {
      $logStr .= " -- SQL QUERRY: " . $sql;
    }

    $log = fopen("log/log.txt", "a");
    fwrite($log, $logStr);
    fclose($log,);
  }


  protected function isValidId($id)
  {
    if (is_int($id) && $id > 0) {
      return true;
    } else {
      return false;
    }
  }

  protected function deleteRecordById($table, $id)
  {
    //$result = $this->connection->query("delete from $table where id = $id");
    $result = $this->connection->query("UPDATE $table SET active = (0) WHERE id = '$id'");
    return $result;
  }

  public function getContent()
  {
    include_once("Utils/Messages.php");
    $msg = new Messages();

    if (empty($this->template) || !$this->template) {
      $this->template = 'error';
    }

    include_once($this->template);
  }

  protected function validation($data)
  {
    return true;
  }


  protected function create($data)
  {
    $sql = 'INSERT INTO ' . $this->table . ' ( ';

    $insert = array();
    $insertData = array();
    foreach ($this->fields as $field) {
      if ($field != 'id') {
        $insert[] = $field;
        $insertData[] = "'" . $data[$field] . "'";
      }
    }

    $sql .= implode(', ', $insert) . ' ) VALUES (' . implode(', ', $insertData) . ')';

    return $this->execute($sql);
  }

  protected function getLastInsertedId()
  {
    $sql = "select id from {$this->table} order by id desc limit 1";
    $res = $this->getSingleResult($sql);
    return intval($res['id']);
  }

  protected function execute($sql)
  {
    $res = $this->connection->query($sql);
    return $res;
  }

  protected function modify($data)
  {
    $sql = 'UPDATE ' . $this->table . ' SET ';

    $update = array();
    foreach ($this->fields as $field) {
      if ($field != 'id') {
        $update[] = $field . " = '" . $data[$field] . "'";
      }
    }
    $sql .= implode(', ', $update);
    $sql .= 'WHERE id = ' . $data['id'];

    return $this->execute($sql);
  }
}
