<?php
    define("field_types", [
        "text",
        "textarea",
        "multi",
        "checkbox",
        "dropdown",
        "file",
        "date",
        "time"
    ]);
    include("header.php");
?>

<form action="form.php" method="post">
    <input type="hidden" name="formId" value="<?php echo $_REQUEST["form_id"] ?>">
    <div><input type="text" name="text"></div>
    <?php
        foreach(field_types as $type) {
    ?>
        <input type="radio" name="type" value="<?php echo $type ?>"> <?php echo $type ?> <br>
    <?php } ?>
    <button>Submit</button>
</form>
<?php include("footer.php") ?>