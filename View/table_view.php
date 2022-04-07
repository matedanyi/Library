<table class="frontend-table" cellspacing="0">
    <tr>
        <th>Cím</th>
        <th>Szerző</th>
        <th>Kategóriák</th>
    </tr>

    <? foreach ($books as $key => $book) { ?>
        <tr>
            <td class="book-row" book="<?= $book['id'] ?>"><?= $book['title'] ?>
            </td>
            <td><?= $book['author'] ?></td>
            <td><?= $book['category'] ?></td>
        </tr>
    <?  }  ?>

</table>