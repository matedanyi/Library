<?
include_once('Application.php');

class Categories extends Application {

  private $sql = array(
    'allCategories' => "SELECT NAME, id FROM categories c WHERE c.active = 1",

    'CategoryById' => "SELECT name FROM categories c
                      WHERE id = {id} AND c.active = 1"
  );


  public function __construct() {
    parent::__construct();

  }

  public function getCategories() {
    $categories = $this->getResultList($this->sql['allCategories']);
    return $categories;
  }



  public function delete($id) {
    if(!$this->isValidId($id)) {
      return false;
    }
    $res = $this->deleteRecordById('categories', $id);
    return $res;
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

?>
