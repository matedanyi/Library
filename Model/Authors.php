<?
include_once('Application.php');

class Authors extends Application
{

  private $sql = array(
    'allAuthors' => "SELECT NAME, id FROM authors WHERE active = 1",
    'authorById' => "SELECT a.name FROM authors a 
    WHERE a.id = {id}",
  );

  private $messages = array();

  protected $table = 'authors';
  protected $fields = array('id', 'name');


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

    if ($author->num_rows > 0) {
      return true;
    }

    return true;
  }

  public function save($author)
  {
    $author = $_POST['author'];

    if (!isset($author) || empty($author) || $author == null) {
      $this->messages[] = 'A szerző mező kitöltése kötelező!!!';
      $this->msg->setSessionMessage('A szerző mező kitöltése kötelező!!!');
      return false;
    }

    if (strlen($author) > 255) {
      $this->messages[] = 'A szerző hossza nem haladhatja meg a 255 karaktert';
      return false;
    }

    $sql = 'INSERT INTO `authors` (`name`) VALUES (' .  "'$author'" .  ')';
    return $this->execute($sql);
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
