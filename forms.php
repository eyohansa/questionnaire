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
        $new_form->id = $id;
        $new_form->title = $title;
        $new_form->date = $date;
        $forms[$i] = $new_form;
        $i++;
    }
}

?>

<div class="container">
    <h2>Daftar Form</h2>
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
<?php include("footer.php") ?>