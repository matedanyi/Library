<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="icon" href="Sources/img/favicon.png">
  <link rel="stylesheet" href="Sources/css/responsive.css" />
  <link rel="stylesheet" href="Sources/css/admin.css" />
</head>

<body>
  <main class="col-6 form_panel">
    <header>
      <h1>Library</h1>
      <span class="f-right"><a href="?userhandler/logout"><img src="Sources/img/logout.png" alt="kilépés" title="kilépés" /></a></span>
    </header>
    <?= $object->msg->messages() ?>
    <?= $object->msg->getSessionMessage() ?>
    <form id="form-inside" method="post" enctype="multipart/form-data">

      <input type="hidden" name="id" value='<?= empty($book['id']) ? null : $book['id'] ?>' />

      <label class="col-3" for="title">Title:</label>
      <input class="col-6" type="text" name="title" value='<?= empty($book['title']) ? '' : $book['title'] ?>' />

      <label class="col-3" for="page_size">Pages:</label>
      <input class="col-6" type="number" name="page_size" value='<?= empty($book['page_size']) ? '' : $book['page_size'] ?>' />

      <label class="col-3" for="lang">Language:</label>
      <input class="col-6" type="text" name="lang" value='<?= empty($book['lang']) ? '' : $book['lang'] ?>' />

      <label class="col-3" for="author_id">Author:</label>
      <select class="col-8" name="author_id">
        <? foreach ($authors as $author) { ?>
          <option value="<?= $author['id'] ?>" <?= !empty($book['author_id']) && $book['author_id'] == $author['id'] ? 'selected' : '' ?>><?= $author['NAME'] ?> </option>
        <? } ?>
      </select>

      <span class="col-3 p-t-s-10">Categories:</span>
      <div class="checkbox-group col-8">
        <?
        $catArray = !empty($book['category_ids']) ? explode(',', $book['category_ids']) : array();
        foreach ($categories as $category) { ?>
          <input type="checkbox" name="kategoria[<?= $category['id'] ?>]" <?= in_array($category['id'], $catArray) ? 'checked' : '' ?> />
          <label for="kategoria[<?= $category['id'] ?>]"><?= $category['NAME'] ?></label>
        <?  }
        ?>

      </div>

      <span class="col-3 p-t-s-10">Picture:</span>
      <?
      $col = 'col-8';
      if (!empty($book['picture'])) {
        $col = 'col-9';
      ?>
        <img src='Sources/uploads/<?= $book['picture'] ?>' alt='<?= !empty($book['title']) ? $book['title'] : '' ?>' title='<?= !empty($book['title']) ? $book['title'] : '' ?>' />

      <? } ?>
      <input class="<?= $col ?>" type="file" name="kep" />

      <span class="col-3 p-t-s-10">Descreption:</span>
      <textarea class="col-8" name="description"><?= empty($book['description']) ? 'Book description' : $book['description'] ?></textarea>

      <div class="col-12">
        <input type="submit" value="Save">
        <button type="button" onclick="location.href='?library/backend'">Back</button>
      </div>

    </form>
  </main>
</body>

</html>