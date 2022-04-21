<table class="frontend-table" cellspacing="0">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
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