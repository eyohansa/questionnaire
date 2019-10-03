<?php

require_once("header.php");

$field_id = isset($_POST["fieldId"])? $_POST["fieldId"] : $_GET["fieldId"];
$field = get_field($field_id);

?>

<div class="container">
    <div class="row">
        <form action="editfield.php" method="post">
            <div class="form-group">
                <label class="form-label">
            </div>
        </form>

