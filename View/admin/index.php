<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Könyvtár Program</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="icon" href="Sources/img/favicon.png">
  <link rel="stylesheet" href="Sources/css/responsive.css" />
  <link rel="stylesheet" href="Sources/css/admin.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="Sources/js/admin_script.js"></script>

</head>

<body>
  <header>
    <h1>Könyvtár Program</h1>
    <span class="f-right"><a href="?userhandler/logout"><img src="Sources/img/logout.png" alt="kilépés" title="kilépés" /></a></span>
  </header>

  <div class="col-12">
    <div class="col-6">
      <h2>Szerzők listája</h2>
      <button type="button" onclick="location.href='?library/author';">Új szerző</button>

      <table cellspacing="0">
        <tr>
          <th>Név</th>
          <th>Funkciók</th>
        </tr>

        <? foreach ($authors as $key => $author) { ?>
          <tr>
            <td><?= $author['NAME'] ?></td>
            <td class="functions">
              <a href="?library/author/<?= $author['id'] ?>">
                <img src="Sources/img/edit.png" alt="módosítás" title="módosítás"></a>
              <a href="#" class="delete_rec" table="Authors" rec_id="<?= $author['id'] ?>">
                <img src="Sources/img/delete.png" alt="törlés" title="törlés"></a>
            </td>
          </tr>
        <?  }  ?>
      </table>

    </div>

    <div class="col-6" id="bcgkat">
      <h2>Kategóriák listája</h2>
      <button type="button" onclick="location.href='?library/category';">Új kategória</button>
      <table cellspacing="0">
        <tr>
          <th>Név</th>
          <th>Funkciók</th>
        </tr>


        <? foreach ($categories as $key => $category) { ?>
          <tr>
            <td><?= $category['NAME'] ?></td>
            <td class="functions">
              <a href="?library/category/<?= $category['id'] ?>">
                <img src="Sources/img/edit.png" alt="módosítás" title="módosítás"></a>
              <a href="#" class="delete_rec" table="Categories" rec_id="<?= $category['id'] ?>">
                <img src="Sources/img/delete.png" alt="törlés" title="törlés"></a>
            </td>
          </tr>
        <?  }  ?>


      </table>
    </div>
  </div>

  <div class="col-12">
    <h2>Könyvek listája</h2>
    <button type="button" onclick="location.href='?library/book';">Új könyv</button>

    <table cellspacing="0">
      <tr>
        <th>Cím</th>
        <th>Oldalszám</th>
        <th>Nyelv</th>
        <th>Szerző</th>
        <th>Kategóriák</th>
        <th>Funkciók</th>
      </tr>
      <? foreach ($books as $key => $book) { ?>
        <tr>
          <td><?= $book['title'] ?></td>
          <td><?= $book['page_size'] ?></td>
          <td><?= $book['lang'] ?></td>
          <td><?= $book['author'] ?></td>
          <td><?= $book['category'] ?></td>
          <td class="functions">
            <a href="?library/book/<?= $book['id'] ?>">
              <img src="Sources/img/edit.png" alt="módosítás" title="módosítás"></a>
            <a href="#" class="delete_rec" table="Books" rec_id="<?= $book['id'] ?>">
              <img src="Sources/img/delete.png" alt="törlés" title="törlés"></a>
          </td>
        </tr>
      <?  }  ?>


    </table>



  </div>
</body>

</html>