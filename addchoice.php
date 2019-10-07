<?php

require_once("header.php");

$field_id = $_REQUEST["fieldId"];

if (isset($_POST["text"])) {
    add_choice($field_id, $_POST["text"]);
}

function add_choice($field_id, $text)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT id, text, type FROM fields WHERE fieldId=?")) {
        $stmt->bind_param("s", $field_id);
        $stmt->execute();
        $stmt->bind_result($id, $text, $type);
        $stmt->fetch();
        if ($stmt->error) {
            printf("Error: %s.\n", $stmt->error);
        }
        $stmt->close();
    }
}

?>

<div class="container">
    <div class="row">
        <div class="col">
            <form method="post" action="/addchoice.php">
                <input type="hidden" name="fieldId" value="<?= $field_id ?>">
                <div class="form-group">
                    <label class="form-label">Text</label>
                    <input class="form-control" type="text" name="text">
                </div>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>