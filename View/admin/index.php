<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library</title>
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
    <a href="?library/index">
      <h1><span>Library</span></h1>
    </a>
    <span class="f-right"><a href="?userhandler/logout"><img src="Sources/img/logout.png" alt="kilépés" title="kilépés" /></a></span>
  </header>

  <div class="col-12">
    <div class="col-6">
      <h2><span>Authors</span></h2>
      <button type="button" onclick="location.href='?library/author';">New author</button>

      <table cellspacing="0">
        <tr>
          <th>Author</th>
          <th>Functions</th>
        </tr>

        <? foreach ($authors as $key => $author) { ?>
          <tr>
            <td><?= $author['author'] ?></td>
            <td class="functions">
              <a href="?library/author/<?= $author['id'] ?>">
                <img src="Sources/img/edit.png" alt="modify" title="modify"></a>
              <a href="#" class="delete_rec" table="Authors" rec_id="<?= $author['id'] ?>">
                <img src="Sources/img/delete.png" alt="delete" title="delete"></a>
            </td>
          </tr>
        <?  }  ?>
      </table>
    </div>

    <div class="col-6" id="bcgkat">
      <h2><span>Categories</span></h2>
      <button type="button" onclick="location.href='?library/category';">New category</button>
      <table cellspacing="0">
        <tr>
          <th>Category</th>
          <th>Functions</th>
        </tr>


        <? foreach ($categories as $key => $category) { ?>
          <tr>
            <td><?= $category['category'] ?></td>
            <td class="functions">
              <a href="?library/category/<?= $category['id'] ?>">
                <img src="Sources/img/edit.png" alt="modify" title="modify"></a>
              <a href="#" class="delete_rec" table="Categories" rec_id="<?= $category['id'] ?>">
                <img src="Sources/img/delete.png" alt="delete" title="delete"></a>
            </td>
          </tr>
        <?  }  ?>


      </table>
    </div>
  </div>

  <div class="col-12">
    <h2><span>Books</span></h2>
    <button type="button" onclick="location.href='?library/book';">New books</button>

    <table cellspacing="0">
      <tr>
        <th>Title</th>
        <th>Pages</th>
        <th>Language</th>
        <th>Author</th>
        <th>Categories</th>
        <th>Functions</th>
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
              <img src="Sources/img/edit.png" alt="modify" title="modify"></a>
            <a href="#" class="delete_rec" table="Books" rec_id="<?= $book['id'] ?>">
              <img src="Sources/img/delete.png" alt="delete" title="delete"></a>
          </td>
        </tr>
      <?  }  ?>


    </table>
  </div>
</body>

</html>