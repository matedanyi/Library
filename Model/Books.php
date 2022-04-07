<?
include_once('Application.php');

class Books extends Application
{

  private $sql = array(
    'allBooks' => "SELECT b.id, b.title, b.page_size, b.lang, a.name AS author, GROUP_CONCAT( c.NAME SEPARATOR ', ') AS category, description, picture FROM books b
                   LEFT JOIN authors a ON a.id = b.author_id
                   LEFT JOIN books_categories bc ON bc.book_id = b.id
                   LEFT JOIN categories c ON c.id = bc.category_id
                   where b.active = 1
                   GROUP BY b.title",
    'booksByCategory' => "SELECT b.title, a.name AS author, GROUP_CONCAT( c.NAME SEPARATOR ', ') AS category FROM books b
                   LEFT JOIN authors a ON a.id = b.author_id
                   LEFT JOIN books_categories bc ON bc.book_id = b.id
                   LEFT JOIN categories c ON c.id = bc.category_id
                   WHERE c.id = {id} AND b.active = 1
                   GROUP BY b.title",
    'bookById' => "SELECT b.id, b.title, b.page_size, b.lang, a.name AS author, author_id, GROUP_CONCAT( c.NAME SEPARATOR ', ') AS category,
                    GROUP_CONCAT(c.id SEPARATOR ', ') AS category_ids,  description, picture
                    FROM books b
                    LEFT JOIN authors a ON a.id = b.author_id
                    LEFT JOIN books_categories bc ON bc.book_id = b.id
                    LEFT JOIN categories c ON c.id = bc.category_id
                    WHERE b.id = {id} AND b.active = 1
                    GROUP BY b.title
                    LIMIT 1",
    'booksByFilter' => "SELECT b.id, b.title, b.page_size, b.lang, a.name AS author, GROUP_CONCAT( c.NAME SEPARATOR ', ') AS category, description, picture FROM books b
                    LEFT JOIN authors a ON a.id = b.author_id
                    LEFT JOIN books_categories bc ON bc.book_id = b.id
                    LEFT JOIN categories c ON c.id = bc.category_id
                    where b.active = 1 AND lower(b.title) like '%{title}%'
                    GROUP BY b.title "
  );

  private $messages = array();

  protected $table = 'books';
  protected $fields = array('id', 'title', 'page_size', 'lang', 'author_id', 'description', 'picture');

  public function __construct()
  {
    parent::__construct();
  }



  public function getBooks()
  {
    $books = $this->getResultList($this->sql['allBooks']);
    return $books;
  }

  public function getBooksFilter($title)
  {
    if (strlen($title) > 255) {
      return false;
    }

    $params = array('{title}' => strtolower($title));
    $books = $this->getResultList(strtr($this->sql['booksByFilter'], $params));
    return $books;
  }


  public function getBooksByCategory($categoryId)
  {
    if (!$this->isValidId($categoryId)) {
      return array();
    }

    $params = array(
      '{id}' => $categoryId
    );

    $books = $this->getResultList(strtr($this->sql['booksByCategory'], $params));

    return $books;
  }

  public function getBookById($id)
  {
    if (!$this->isValidId($id)) {
      return array();
    }
    $params = array(
      '{id}' => $id
    );

    $book = $this->getSingleResult(strtr($this->sql['bookById'], $params));
    return $book;
  }


  public function delete($id)
  {
    if (!$this->isValidId($id)) {
      return false;
    }
    $res = $this->deleteRecordById('books', $id);
    return $res;
  }



  public function save($book)
  {
    if (!$this->validation($book)) {
      $this->writeLog('A kapott adatsor invalid! <br>' . implode('<br>', $this->messages));
      $this->msg->setSessionMessage('Az űrlap kitöltése nem megfelelő! <br>' . implode('<br>', $this->messages));
      return null;
    }

    if (isset($book['id']) && !empty($book['id'])) {
      if ($this->isValidId(intval($book['id']))) {
        $this->id = intval($book['id']);
        $filename = $this->fileUpload();

        if ($filename) {
          $book['picture'] = $filename;
        }
        $res = $this->modify($book);
        $this->saveCategory($book);
      } else {
        $this->writeLog('A kapott id invalid: ' . $book['id']);
        $this->msg->setSessionMessage('A kapott id invalid: ' . $book['id']);
      }
    } else {
      $filename = $this->fileUpload();
      $book['picture'] = $filename ? $filename : '';
      $res = $this->create($book);
      $this->id = $this->getLastInsertedId();
      $this->saveCategory($book);
    }



    return $this->id;
  }


  private function fileUpload()
  {
    if (isset($_FILES) && !empty($_FILES['kep']['tmp_name'])) {
      $targetDir = "Sources/uploads/";
      $targetFile = $targetDir . basename($_FILES['kep']['name']);

      $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

      $check = getimagesize($_FILES['kep']['tmp_name']);
      if ($check !== false) {

        if (file_exists($targetFile)) {
          $this->msg->setSessionMessage("A fájl már létezik");
          return false;
        }

        if ($_FILES['kep']['size'] > 500000) {
          $this->msg->setSessionMessage("A fájl mérete túl nagy");
          return false;
        }

        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
          $this->msg->setErrorMsg("A megengedett képformátumok: JPG, JPEG, PNG vagy GIF");
          return false;
        }

        if (move_uploaded_file($_FILES['kep']['tmp_name'], $targetFile)) {
          $filename = basename($_FILES['kep']['name']);
          return $filename;
        } else {
          $this->msg->setSessionMessage("A fájl áthelyezése sikertelen");
          return false;
        }
      } else {
        $this->msg->setSessionMessage('A feltöltött fájl nem kép');
        return false;
      }
    }
    return false;
  }

  private function saveCategory($book)
  {
    $sql = "delete from books_categories where book_id = {$this->id}";
    $this->execute($sql);

    $categories = array();
    foreach ($book as $key => $value) {
      if ($key == 'kategoria') {
        $keys = array_keys($value);

        foreach ($keys as $catId) {
          $categories[] = "($catId, {$this->id})";
        }
      }
    }
    $sql = "INSERT INTO books_categories(category_id, book_id) VALUES " . implode(', ', $categories);
    $this->execute($sql);
  }




  /** override */
  protected function validation($data)
  {

    if (!isset($data['title']) || empty($data['title']) || $data['title'] == null) {
      $this->messages[] = 'A cím mező kitöltése kötelező!!!';
      return false;
    }

    if (!is_string($data['title'])) {
      $this->messages[] = 'A cím csak szöveg lehet';
      return false;
    }

    if (strlen($data['title']) > 255) {
      $this->messages[] = 'A cím hossza nem haladhatja meg a 255 karaktert';
      return false;
    }

    $pageSize = intval($data['page_size']);

    if ($pageSize < 0 || $pageSize > 10000) {
      $this->messages[] = 'Az oldal értéke 0 és 10000 közé kell, hogy essen.';
      return false;
    }

    if (!is_string($data['lang'])) {
      $this->messages[] = 'A nyelv értéke csak szöveg lehet';
      return false;
    }

    if (strlen($data['lang']) > 255) {
      $this->messages[] = 'A nyelv értéke nem lehet hosszabb 255 karakternél';
      return false;
    }

    //TODO: author_id és a category_id validálása az adatbázis alapján

    return true;
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