<?php

require_once("form.php");

if (!isset($_SESSION["forms"])) {
    $_SESSION["forms"] = [];
}

include("header.php");
?>
<div class="container">
    <h2>Form Baru</h2>
    <form action="forms.php" method="post">
        <div class="form-group">
            <label>Judul</label>
            <input type="text" class="form-control" name="formTitle">
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
<?php include("footer.php") ?>