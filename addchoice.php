<?php

require_once("header.php");

function add_choice($field_id, $text) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT id, text, type FROM fields WHERE fieldId=?")) {
        $stmt->bind_param("s", $field_id);
        $stmt->execute();
        $stmt->bind_result($id, $text, $type);
        $stmt->fetch();
        if($stmt->error) {
            printf("Error: %s.\n", $stmt->error);
        }
        $stmt->close();
    }
}