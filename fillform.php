<?php

include("header.php");

$form_id = $_GET["id"];

$mysqli = new mysqli("localhost", "root", "", "poll");
$prepared =  "SELECT type, text, required FROM fields WHERE formId=?";
if ($stmt = $mysqli->prepare($prepared)) {
    $stmt->bind_param("s",$form_id);
    $stmt->execute();
    $stmt->bind_result($type, $text);
    $i = 0;
    while($stmt->fetch())
    {
        $new_field = new Field;
        $new_field->set_text($text);
        $new_field->set_type($type);
        $new_field->set_required($required);
        $fields[$i] = $new_field;
        $i++;
    }
}

?>

<div class="container">
    <ul>
    <?php
    foreach($fields as $field) {
        printf("<li>%s</li>", $field->field_text);
    } ?>
    </ul>
</div>


<?php include("footer.php") ?>