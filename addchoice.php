<?php

require_once("header.php");

$field_id = $_REQUEST["fieldId"];
$field = get_field($field_id);

if (isset($_POST["text"])) {
    add_choice($field_id, $_POST["text"]);
}

$choices = get_choices($field_id);

?>

<div class="container">
    <div class="row">
        <div class="col">
            <p><?= $field["text"] ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form method="post" action="/addchoice.php">
                <input type="hidden" name="fieldId" value="<?= $field_id ?>">
                <div class="form-group">
                    <label class="form-label">Text</label>
                    <input class="form-control" type="text" name="text">
                </div>
                <button class="btn btn-primary">Submit</button>
                <a href="/editfield?fieldId=<?= $field_id ?>" class="btn btn-secondary">Balik</a>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <ul class="list-group">
                <?php foreach($choices as $choice): ?>
                    <li class="list-group-item"><?= $choice["text"] ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>