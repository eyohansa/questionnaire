<?php

include("header.php");

$response_id = $_REQUEST["id"];
$response = get_response($response_id);
$form_id = get_response_form_id($response_id);
$form = get_form($form_id);
$fields = get_fields($form_id);

?>

<div class="container">
    <h2><?= $form["title"] ?></h2>
    <div class="row">
        <div class="col">
            <form>
                <?php foreach ($fields as $field) : ?>
                    <div class="form-group">
                        <label class="form-label"><?= $field["text"] ?></label>
                        <?php if ($field["type"] == "radio") :
                                $choices = get_choices($field["id"]);
                                foreach ($choices as $choice) : ?>
                                <input type="radio" name="<?= $field["id"] ?>" value="<?= $choice["id"] ?>">
                                <label><?= $choice["text"] ?></label>
                            <?php endforeach ?>
                        <?php else : ?>
                            <input class="form-control" type="<?= $field["type"] ?>" name="<?= $field["id"] ?>" <?= $field["required"] ?> value="<?= get_answer($response_id, $field["id"]) ?>">
                        <?php endif ?>

                    </div>
                <?php endforeach ?>
            </form>
        </div>
    </div>
</div>