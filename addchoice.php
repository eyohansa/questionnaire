<?php

function add_choice($field_id, $text) {
    $mysqli = new mysqli("localhost", "root", "", "poll");
    if ($stmt = $mysqli->prepare("SELECT id, text, type FROM fields WHERE fieldId=?")) {
        $stmt->bind_param("s", $field_id);
        $stmt->execute();
        $stmt->bind_result($id, $text, $type);
        $stmt->fetch();
        if($stmt->error) {
            printf("Error: %s.\n", $stmt->error);
        }
        $stmt->
    }
}