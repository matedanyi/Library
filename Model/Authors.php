<?
include_once('Application.php');

class Authors extends Application
{

  private $sql = array(
    'allAuthors' => "SELECT author, id FROM authors WHERE active = 1 ORDER BY id desc ",
    'authorById' => "SELECT a.id, a.author FROM authors a WHERE a.id = {id}",
  );

  private $messages = array();

  protected $table = 'authors';
  protected $fields = array('id', 'author');


  public function __construct()
  {
    parent::__construct();
  }

  public function getAuthors()
  {
    $authors = $this->getResultList($this->sql['allAuthors']);
    return $authors;
  }


  public function delete($id)
  {
    if (!$this->isValidId($id)) {
      return false;
    }
    $res = $this->deleteRecordById('authors', $id);
    return $res;
  }

  public function getAuthorById($id)
  {
    if (!$this->isValidId($id)) {
      return array();
    }
    $params = array(
      '{id}' => $id
    );
    $author = $this->getSingleResult(strtr($this->sql['authorById'], $params));

    return $author;
  }

  public function save($author)
  {
    // var_dump($author);
    if (isset($author['id']) && !empty($author['id'])) {
      if ($this->isValidId(intval($author['id']))) {
        $this->id = intval($author['id']);
        $res = $this->modify($author);
      } else {
        $this->writeLog('Invalid id: ' . $author['id']);
        $this->msg->setSessionMessage('Invalid id: ' . $author['id']);
      }
    } else {

      // $sql = 'INSERT INTO `authors` (`author`) VALUES (' . '"' . "$author[author]" . '"' .  ')';
      // echo $sql;
      // return $this->execute($sql);
      $res = $this->create($author);
      $this->msg->setSessionMessage('Save successfully' . '<bnsp></bnsp> ' . $author['author']);
      // var_dump($res);
      // $this->id = $this->getLastInsertedId();


      return $this->id;
    }
  }



  /*
  public function getBooksByCategory($categoryId){
    if(!$this->isValidId($categoryId)) {
      return array();
    }

    $params = array(
      '{id}' => $categoryId
    );

    $books = $this->getResultList( strtr($this->sql['booksByCategory'], $params)  );

    return $books;

  }


  public function getBookById($id) {
    if(!$this->isValidId($id)) {
      return array();
    }
    $params = array(
      '{id}' => $id
    );

    $book = $this->getSingleResult( strtr($this->sql['BookById'], $params) );
    return $book;
  }


  public function delete($id) {
    if(!$this->isValidId($id)) {
      return false;
    }
    $res = $this->deleteRecordById('books', $id);
    return $res;
  }












  /*
  Ki??rja, hogy kapcsol??dik-e, az adatb??zishoz, avagys sem.

  if($this->isDbConnectionLive()) {
      echo "db kapcsolat ??l";
    } else {
      echo "db kapcsolat nincs meg";
    }
  */

  /* Kilist??zza az ??sszes k??nyvet az oldal elej??re.
  debug( $this->getResultList("select * from books"));
  */
}
