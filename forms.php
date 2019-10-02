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
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($forms as $form) {
                    ?>
                    <tr>
                        <td><?php echo $form->id ?></td>
                        <td><?php echo $form->title ?></td>
                        <td><?php echo $form->date ?></td>
                        <td><a class="btn btn-link" href="editform.php?id=<?php echo $form->id ?>">Edit</a>
                            <a class="btn btn-link" href="fillform.php?id=<?php echo $form->id ?>">Isi</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include("footer.php") ?>