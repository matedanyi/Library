<?
include_once('Application.php');

class Categories extends Application
{

  private $sql = array(
    'allCategories' => "SELECT category, id FROM categories c WHERE c.active = 1",

    'categoryById' => "SELECT c.id, c.category FROM categories c
                      WHERE id = {id} AND c.active = 1"
  );

  // private $messages = array();

  protected $table = 'categories';
  protected $fields = array('id', 'category');


  public function __construct()
  {
    parent::__construct();
  }

  public function getCategories()
  {
    $categories = $this->getResultList($this->sql['allCategories']);
    return $categories;
  }

  public function getCategoryById($id)
  {
    if (!$this->isValidId($id)) {
      return array();
    }
    $params = array(
      '{id}' => $id
    );
    $category = $this->getSingleResult(strtr($this->sql['categoryById'], $params));

    return $category;
  }

  public function delete($id)
  {
    if (!$this->isValidId($id)) {
      return false;
    }
    $res = $this->deleteRecordById('categories', $id);
    return $res;
  }

  public function save($category)

  {
    // var_dump($category);
    if (isset($category['id']) && !empty($category['id'])) {
      if ($this->isValidId(intval($category['id']))) {
        $this->id = intval($category['id']);
        $res = $this->modify($category);
      } else {
        $this->writeLog('Invalid id: ' . $category['id']);
        $this->msg->setSessionMessage('Invalid id: ' . $category['id']);
      }
    } else {
      // echo 'sziasztok';
      // $sql = 'INSERT INTO `categories` (`category`) VALUES (' . '"' . "$category[category]" . '"' .  ')';
      // echo $sql;
      // return $this->execute($sql);
      $res = $this->create($category);
      $this->msg->setSessionMessage('Save successful ' . '<bnsp></bnsp> ' . $category['category']);
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
  Kiírja, hogy kapcsolódik-e, az adatbázishoz, avagys sem.

  if($this->isDbConnectionLive()) {
      echo "db kapcsolat él";
    } else {
      echo "db kapcsolat nincs meg";
    }
  */

  /* Kilistázza az összes könyvet az oldal elejére.
  debug( $this->getResultList("select * from books"));
  */
}
