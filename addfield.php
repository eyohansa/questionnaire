<?php
define("field_types", [
    "text",
    "textarea",
    "radio",
    "checkbox",
    "dropdown",
    "file",
    "date",
    "time"
]);

$form_id = $_GET["formId"];

include("header.php");
?>

<div class="container">
    <h2>Field Baru</h2>
    <form action="editform.php" method="post">
        <input type="hidden" name="formId" value="<?php echo $_REQUEST["formId"] ?>">
        <div class="form-group">
            <label class="form-label">Text</label>
            <input type="text" name="text" class="form-control">
        </div>
        <fieldset class="form-group">
            <legend>Jenis</legend>
            <?php
            foreach (field_types as $type) {
                ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" value="<?php echo $type ?>">
                    <label class="form-check-label"><?php echo $type ?></label>
                </div>
            <?php } ?>
        </fieldset>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="required">
                <label class="form-check-label">Required</label>
            </div>
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
<?php include("footer.php") ?>