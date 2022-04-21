<!DOCTYPE html>

<head>
  <meta content="text/html" charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library</title>
  <link rel="icon" href="Sources/img/favicon.png">
  <link rel="stylesheet" href="Sources/css/responsive.css" />
  <link rel="stylesheet" href="Sources/css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="Sources/js/script.js"></script>
</head>

<body>
  <header>
    <span><img id="panel-nyito" src="Sources/img/menu.png" alt="menü" title="menü"></span>
    <h1>Library</h1>
  </header>

  <main>
    <div class="col-3" id="kategoria">
      <header class="m-b-10">
        <h2>Categories</h2>
        <span class="f-right"><img id="panel-zaro" src="Sources/img/arrow_left.png" alt="összecsuk" title="összecsuk"></span>
      </header>
      <div>

        <? foreach ($categories as $key => $category) { ?>
          <input class="input_kategoria" type="checkbox" name="kategoria_<?= $category['id'] ?>" kat_id="<?= $category['id'] ?>" />
          <label onclick="location.href='kategoria.php?cat<?= $category['id'] ?>'" for="kategoria_<?= $category['id'] ?>"> <?= $category['NAME'] ?>
          </label>
          <br />
        <?  }  ?>

        <hr />

        <br>
        <!-- <a href="admin/kolcsonzes.html"><span><img src="Sources/img/clipboard.png" alt="kolcsonzes" title="kolcsonzes"></span>Kölcsönzés</a>
        <br> -->
        <a href="?userhandler/login"><span><img src="Sources/img/login.png" alt="login" title="login"></span>Login</a>
      </div>

    </div>

    <div class="col-9" id="tartalom">
      <header class="m-b-20">
        <h2>List of books</h2>
      </header>
      <div>
        <? $msg->messages(); ?>
        <input type="search" name="search" class="m-b-20" id="searchBar" />
        <button id="search">Search</button>
        <button class="megse" id="cancel">Cancel</button>

        <div id="table-content">
          <?= include_once('table_view.php') ?></div>

        <div id="detail-view">
          <?
          $book = $books[0];
          include_once('detail.php') ?>
        </div>

      </div>
    </div>
  </main>
</body>

</html>