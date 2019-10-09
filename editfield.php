<?php

require_once("header.php");

$field_id = $_REQUEST["fieldId"];
$field = get_field($field_id);
$field_type = $field["type"];
$support_choices = $field_type === "radio" || $field_type === "select";

?>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Edit Field</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="editfield.php" method="post">
                <div class="form-group">
                    <label class="form-label">Text</label>
                    <input type="text" name="text" class="form-control" value="<?= $field["text"] ?>">
                </div>
                <button class="btn btn-primary">Submit</button>
                <a href="/editform?id=<?= $field["formId"] ?>" class="btn btn-secondary">Balik</a>
            </form>
        </div>
    </div>
    <?php if ($support_choices): ?>
    <div class="row">
        <div class="col">
            <a href="/addchoice.php?fieldId=<?= $field_id ?>">Tambahkan pilihan</a>
        </div>
    </div>
    <?php endif ?>
</div>