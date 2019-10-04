<?php

require_once("form.php");

if (!isset($_SESSION["forms"])) {
    $_SESSION["forms"] = [];
}

include("header.php");
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Form Baru</h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-item" href="/">Daftar</a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <form action="forms.php" method="post">
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" class="form-control" name="formTitle">
                </div>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include("footer.php") ?>