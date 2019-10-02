<?php

require_once("config.php");

function get_form($id, $form) {
    $mysqli = new mysqli($host, $username, $password, $db_name);
    if ($stmt = $mysqli->prepare("SELECT id, title, date FROM forms WHERE formId=?")) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($id, $title, $date);
        $stmt->fetch();
        if ($stmt->error) {
            printf("Error: %s.\n", $stmt->error);
        }
        $form = new Form;
        $form->create($id, $title, $date);
        $stmt->close();
    }
}

function add_choice($field_id, $text) {
    $mysqli = new mysqli($host, $username, $password, $db_name);
    if ($stmt = $mysqli->prepare("INSERT INTO choices(text, fieldId) VALUES (?, ?)")) {
        $stmt->bind_param("ss", $text, $field_id);
        $stmt->execute();
        if ($stmt->error) {
            printf("Error: %s.\n", $stmt->error);
        }
        $stmt->close();
    }
}

function submit_form($form_id, $answers) {
    foreach($answers as $answer) {
        $answer["fieldId"] =
    }
}