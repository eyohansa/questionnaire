<?php

require_once("functions.php");
$forms = get_forms();

?>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($forms as $form) : ?>
            <tr>
                <td>
                    <a href="/editform.php?formId=<?= $form["id"] ?>">
                        <?= $form["id"] ?>
                    </a>
                </td>
                <td><?= $form["title"] ?></td>
                <td><?= $form["date"] ?></td>
                <td><a class="btn btn-link btn-sm" href="/fillform.php?id=<?= $form["id"] ?>">Isi</a></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>