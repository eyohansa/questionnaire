<?php

require_once("header.php");

$form_id = $_POST["id"];

$fields = get_fields($form_id);
var_dump($fields);