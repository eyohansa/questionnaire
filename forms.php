<?php
include("header.php");
$mysqli = new mysqli("localhost", "root", "", "poll");

if (isset($_POST["formTitle"])) {
    $form_title = $_POST["formTitle"];
    $form_date = date("Y-m-d");
    if ($stmt = $mysqli->prepare("INSERT INTO forms (`title`, `date`) VALUES (?, ?)")) {
        $stmt->bind_param("ss", $form_title, $form_date);
        $stmt->execute();
    }

    unset($_POST["formTitle"]);
}

$forms = [];

if ($stmt = $mysqli->prepare("SELECT * FROM forms")) {
    $stmt->execute();
    $stmt->bind_result($id, $title, $date);
    $i = 0;
    while ($stmt->fetch()) {
        $new_form = new Form();
        $new_form->create($id, $title, $date);
        $forms[$i] = $new_form;
        $i++;
    }
}

?>

<div class="container">
    <h2>Daftar Form</h2>
    <div class="row">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="/forms.php">Daftar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/addform.php">Baru</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col">
            <?php include("partials/forms.php") ?>
        </div>
    </div>
</div>
<?php include("footer.php") ?>