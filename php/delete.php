<?

include_once('../php/Books.php');


switch ($_GET['t']) {
  case 'books':
    $books = new Books();
    $res = $books->delete(intval($_GET['id']));

    if(!$res) {
      echo "hiba a könyv törlése során, id: ".$_GET['id'];
    }

    break;

  default:
    // code...
    break;
}

if($res) {
  header("Location: ../admin/index.php");
}











?>
