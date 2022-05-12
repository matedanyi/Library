<?
include_once('php/Books.php');
$books = new Books();
echo $_GET['cat'];
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Könyvtár program</title>
  <link rel="icon" href="img/favicon.png">
  <link rel="stylesheet" href="css/responsive.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>

<body>
  <main>
    <div class="col-9" id="tartalom">
      <header class="m-b-20">
        <h2>Könyvek kategorizált listája</h2>
      </header>
      <div>

        <table cellspacing="0">
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
          </tr>

          <? foreach ($books->getBooksByCategory(intval($_GET['cat'])) as $key => $book) { ?>
            <tr>
              <td><?= $book['title'] ?></td>
              <td><?= $book['author'] ?></td>
              <td><?= $book['category'] ?></td>
            </tr>
          <?  }  ?>

        </table>
      </div>
      <br>
      <button type="button" onclick="location.href='index.php'">Back</button>
    </div>
  </main>
</body>

</html>