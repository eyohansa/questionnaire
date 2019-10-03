<?php

require("header.php");

if (isset($_POST["formId"])) {
    $_GET["id"] = $_POST["formId"];
    $form_id = $_POST["formId"];
} else if (isset($_GET["id"])) {
    $form_id = $_GET["id"];
} else {
    $form_id = 1;
}
$fields = [];

if (isset($_POST["text"])) {
    $new_field = new Field;
    $new_field->set_text($_POST["text"]);
    $new_field->set_type($_POST["type"]);
    if (isset($_POST["required"]) && $_POST["required"] === "on") {
        $new_field->set_required(1);
    } else {
        $new_field->set_required(0);
    }
    $new_field->form_id = $_POST["formId"];
    $new_field->save($form_id);
}

if (isset($_POST["command"]) && $_POST["command"] == "duplicate") {
    $duplicating_field_id = $_POST["fieldId"];
    duplicate_field($duplicating_field_id);
}

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($stmt = $mysqli->prepare("SELECT id, type, text, required FROM fields WHERE formId=?")) {
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
    }
    if ($stmt->error) {
        printf("Error: %s.\n", $stmt->error);
    }
    $stmt->close();
}

$form_title = "";
if ($stmt = $mysqli->prepare("SELECT title FROM forms WHERE id=?")) {
    $stmt->bind_param("s", $form_id);
    $stmt->execute();
    $stmt->bind_result($form_title);
    $stmt->fetch();
    $stmt->close();
}

?>
<div class="container">
    <h2><?php echo $form_title ?></h2>
    <div class="row">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/forms.php">Daftar</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/addfield.php?formId=<?php echo $form_id ?>">Field Baru</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-12">
            <?php if (count($fields) > 0) { ?>
                <table class="table">
                    <?php foreach ($fields as $field) { ?>
                        <tr>
                            <td><?php echo $field["text"] ?></td>
                            <td>
                                <form action="editform.php" method="post">
                                    <input type="hidden" name="formId" value="<?php echo $form_id ?>">
                                    <input type="hidden" name="fieldId" value="<?php echo $field["id"]?>">
                                    <input type="hidden" name="command" value="duplicate">
                                    <button class="btn btn-link">Duplicate</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                Form ini belum memilik komponen
            <?php } ?>
        </div>
    </div>
</div>

<?php include("footer.php") ?>