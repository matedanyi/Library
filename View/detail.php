<header>
  <h2>Részletes nézet</h2>
</header>


<div>
  <h3 class="col-12"><?= $book['title'] ?></h3>
  <div class="col-3">
    <img class="book-img" src="Sources/uploads/<?= $book['picture'] ?>" alt="<? $book['title'] ?>" title="<? $book['title'] ?>" class="book_img">
  </div>

  <div class="col-6">
    <table class="detail_table" cellspacing=0>
      <tr>
        <td>Szerző:</td>
        <td><?= $book['author'] ?></td>
      </tr>

      <tr>
        <td>Oldalszám:</td>
        <td><?= $book['page_size'] ?></td>
      </tr>

      <tr>
        <td>Nyelv:</td>
        <td><?= $book['lang'] ?></td>
      </tr>

      <tr>
        <td>Kategóriák:</td>
        <td><?= $book['category'] ?></td>
      </tr>
    </table>
  </div>

  <div class="col-12">
    <h4 class="col-12">Leírás</h4>
    <p class="col-12">
      <?= $book['description'] ?>
    </p>
  </div>

</div>