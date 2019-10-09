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

if (isset($_POST["command"])) {
    if ($_POST["command"] == "duplicate") {
        $duplicating_field_id = $_POST["fieldId"];
        duplicate_field($duplicating_field_id);
    } else if ($_POST["comamnd"] = "delete") {
        delete_field($_POST["fieldId"]);
    }
}

$fields = get_fields($form_id);
$form_title = get_form($form_id)["title"];

?>
<div class="container">
    <h2><?= $form_title ?></h2>
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
                <a class="nav-link" href="/addfield.php?formId=<?= $form_id ?>">Field Baru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/responses.php?id=<?= $form_id ?>">Jawaban</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-12">
            <?php if (count($fields) > 0) { ?>
                <table class="table">
                    <?php foreach ($fields as $field) { ?>
                        <tr>
                            <td>
                                <a href="/editfield.php?fieldId=<?= $field["id"] ?>">
                                    <?= $field["text"] ?>
                                </a>
                            </td>

                            <td>
                                <form action="editform.php" method="post">
                                    <input type="hidden" name="formId" value="<?= $form_id ?>">
                                    <input type="hidden" name="fieldId" value="<?= $field["id"] ?>">
                                    <input type="hidden" name="command" value="duplicate">
                                    <button class="btn btn-sm btn-link">Duplicate</button>
                                </form>
                            </td>
                            <td>
                                <form action="editform.php" method="post">
                                    <input type="hidden" name="formId" value="<?= $form_id ?>">
                                    <input type="hidden" name="fieldId" value="<?= $field["id"] ?>">
                                    <input type="hidden" name="command" value="delete">
                                    <button class=" btn btn-sm btn-link">Hapus</button>
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