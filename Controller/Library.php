<?
include_once('AppController.php');

class Library extends AppController
{

  public function __construct()
  {
    parent::__construct();

    $this->allowedMethods(array('index', 'detail', 'searchBooks', 'allBooks'));
  }

  public function index()
  {
    $this->useModels(array('Categories', 'Books'));
    $this->template = 'frontend';

    $books = $this->Books->getBooks();

    $categories = $this->Categories->getCategories();

    $this->set('books', $books);
    $this->set('categories', $categories);
  }

  public function detail()
  {
    if (isset($_POST['book'])) {
      $this->useModels(array('Books'));
      $this->template = 'detail';

      $book = $this->Books->getBookById(intval($_POST['book']));
      $this->set('book', $book);
    }
  }

  public function searchBooks()
  {
    if (isset($_POST['title'])) {
      $this->useModels(array('Books'));
      $this->template = 'table_view';

      $books = $this->Books->getBooksFilter($_POST['title']);
      $this->set('books', $books);
    }
  }

  public function allBooks()
  {
    $this->useModels(array('Books'));
    $this->template = 'table_view';

    $books = $this->Books->getBooks();
    $this->set('books', $books);
  }

  public function backend()
  {
    $this->useModels(array('Categories', 'Books', 'Authors'));
    $this->template = 'admin/index';

    $books = $this->Books->getBooks();
    $authors = $this->Authors->getAuthors();
    $categories = $this->Categories->getCategories();

    $this->set('books', $books);
    $this->set('authors', $authors);
    $this->set('categories', $categories);
  }


  public function book()
  {
    $this->useModels(array('Authors', 'Categories', 'Books'));
    $this->template = 'admin/konyvek_form';

    $getKey = array_keys($_GET);
    $urlSegments = explode("/", $getKey[0]);
    $id = intval(isset($urlSegments[2]) ? $urlSegments[2] : null);

    if (isset($_POST['title'])) {
      $id = $this->Books->save($_POST);

      if (!empty($id)) {
        $this->msg->setSessionMessage('A mentés sikeres!');
        $url = '?library/book/' . $id;
        header('Location: ' . $url);
        exit;
      } else {
        $this->msg->setSessionMessage('A mentés sikertelen!');
      }
    }

    $authors = $this->Authors->getAuthors();
    $this->set('authors', $authors);

    $categories = $this->Categories->getCategories();
    $this->set('categories', $categories);

    $book = array();
    if (!empty($id)) {
      $book = $this->Books->getBookById($id);
    }

    $this->set('book', $book);
  }

  public function category()
  {
    $this->template = 'admin/kategoria_form';
  }

  public function author()
  {
    $this->useModels(array('Authors'));
    $this->template = 'admin/szerzo_form';

    $author = $_POST;
    $getKey = array_keys($_GET);


    if (isset($_POST['author'])) {
      $author = $this->Authors->save($_POST);
    }

    $this->set('author', $author);
  }




  public function deleteBooks()
  {
    $this->useModels(array('Books'));

    $getKey = array_keys($_GET);
    $urlSegments = explode('/', $getKey[0]);

    $table = isset($urlSegments[2]) ? $urlSegments[2] : null;
    $id = isset($urlSegments[3]) ? intval($urlSegments[3]) : null;

    /*debug($table);
    debug($id);*/
    $res = $this->{$table}->delete($id);

    if ($res) {
      header("Location: ?library/backend");
    } else {
      echo "Hiba a rekord törlésekor!";
    }
  }


  public function deleteCategories()
  {
    $this->useModels(array('Categories'));

    $getKey = array_keys($_GET);
    $urlSegments = explode('/', $getKey[0]);

    $table = isset($urlSegments[2]) ? $urlSegments[2] : null;
    $id = isset($urlSegments[3]) ? intval($urlSegments[3]) : null;



    $res = $this->{$table}->delete($id);

    if ($res) {
      header("Location: ?library/backend");
    } else {
      echo "Hiba a rekord törlésekor!";
    }
  }

  public function deleteAuthors()
  {
    $this->useModels(array('Authors'));

    $getKey = array_keys($_GET);
    $urlSegments = explode('/', $getKey[0]);

    $table = isset($urlSegments[2]) ? $urlSegments[2] : null;
    $id = isset($urlSegments[3]) ? intval($urlSegments[3]) : null;


    $res = $this->{$table}->delete($id);
    if ($res) {
      header("Location: ?library/backend");
    } else {
      echo "Hiba a rekord törlésekor!";
    }
  }
}
