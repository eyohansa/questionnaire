<?php

include("header.php");

$form_id = $_REQUEST["id"];
$form = get_form($form_id);
$responses = get_responses($form_id)
?>

<div class="container">
    <h2>
        <a href="/editform.php?id=<?= $form_id ?>">
            <?= $form["title"] ?>
        </a>
    </h2>
    <h3>Daftar Jawaban</h3>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($responses as $response) : ?>
                        <tr>
                            <td>
                                <a href="/response.php?id=<?= $response["id"] ?>">
                                    <?= $response["id"] ?>
                                </a>
                            </td>
                            <td><?= $response["filledDate"] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>