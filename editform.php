<?php

$form_id = $_GET["id"];
$fields = [];

$mysqli = new mysqli("localhost", "root", "", "poll");
if ($stmt = $mysqli->prepare("SELECT type, text from fields WHERE formId=?")) {
    $stmt->bind_param("s", $form_id);
    $stmt->execute();
    $stmt->bind_result($type, $text);
    $i = 0;
    while ($stmt->fetch()) {
        $fields[$i] = [$type, $text];
        $i++;
    }    
}

$form_title = "";
if ($stmt = $mysqli->prepare("SELECT title FROM forms WHERE id=?")) {
    $stmt->bind_param("s", $form_id);
    $stmt->execute();
    $stmt->bind_result($form_title);
    $stmt->fetch();
}

include("header.php");
?>
<div class="container">
    <h2><?php echo $form_title ?></h2>
    <div class="row">
        <div class="col-12">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php if (count($fields) > 0) { ?>
                <ul>
                    <?php foreach ($fields as $field) { ?>
                        <li><?php echo $field[1] ?></li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                Form ini belum memilik komponen
            <?php } ?>
        </div>
    </div>
</div>

<?php include("footer.php") ?>