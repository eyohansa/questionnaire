<?php

include("header.php");

$form_id = $_GET["id"];
$form = get_form($form_id);

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$prepared =  "SELECT id, type, text, required FROM fields WHERE formId=?";
if ($stmt = $mysqli->prepare($prepared)) {
    $stmt->bind_param("s", $form_id);
    $stmt->execute();
    $stmt->bind_result($id, $type, $text, $required);
    $i = 0;
    while ($stmt->fetch()) {
        $fields[$i] = array(
            "id" => $id,
            "type" => $type,
            "text" => $text,
            "required" => $required
        );
        $i++;
    }
}

?>

<div class="container">
    <h2><?= $form["title"] ?></h2>
    <form method="post" action="formresult.php">
        <input type="hidden" value="<?= $form_id ?>" name="formId">
        <?php foreach ($fields as $field) : ?>
            <div class="form-group">
                <label class="form-label"><?= $field["text"] ?></label>
                <?php if ($field["type"] == "radio") : 
                    $choices = get_choices($field["id"]);
                    foreach($choices as $choice): ?>
                        <input type="radio" name="<?= $field["id"] ?>" value="<?= $choice["id"] ?>"> 
                    <?php endforeach ?>
                <?php else : ?>
                    <input class="form-control" type="<?= $field["type"] ?>" name="<?= $field["id"] ?>" <?= $field["required"] ?>>
                <?php endif ?>

            </div>
        <?php endforeach ?>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>


<?php include("footer.php") ?>