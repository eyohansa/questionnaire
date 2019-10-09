<?php

include("header.php");

$form_id = $_REQUEST["id"];
$form = get_form($form_id);
$responses = get_responses($form_id)
?>

<div class="container">
    <h2>Jawaban</h2>
    <div class="row">
        <div class="col">
            <table class="table">
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
            </table>
        </div>
    </div>
</div>