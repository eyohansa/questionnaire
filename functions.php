<?php

require_once("config.php");

function get_forms() 
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT id, title, date FROM forms")) {
        $stmt->execute();
        $stmt->bind_result($id, $title, $date);
        $i = 0;
        while($stmt->fetch()) {
            $forms[$i] = array(
                "id" => $id,
                "title" => $title,
                "date" => $date
            );
            $i++;
        }
        return $forms;
    }
    return array();
}

function get_form($id)
{
    $form;
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT id, title, date FROM forms WHERE id=?")) {
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
    return $form;
}

function get_field($field_id)
{
    $data = array();
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT id, type, text, required, formId FROM fields WHERE id=?")) {
        $stmt->bind_param("s", $field_id);
        $stmt->execute();
        $stmt->bind_result($id, $type, $text, $required, $form_id);
        $stmt->fetch();
        if ($stmt->error) {
            printf("Error: %s.\n", $stmt->error);
        }

        $data = array(
            "id" => $id,
            "type" => $type,
            "text" => $text,
            "required" => $required,
            "formId" => $form_id
        );

        $stmt->close();
        
    }
    return $data;
}

function delete_field($field_id) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("DELETE FROM fields WHERE id=?")) {
        $stmt->bind_param("s", $field_id);
        $stmt->execute();
        if ($stmt->error) {
            printf("Error: %s.\n", $stmt->error);
        }
        $stmt->close();
    }
}

function add_choice($field_id, $text)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("INSERT INTO choices(text, fieldId) VALUES (?, ?)")) {
        $stmt->bind_param("ss", $text, $field_id);
        $stmt->execute();
        if ($stmt->error) {
            printf("Error: %s.\n", $stmt->error);
        }
        $stmt->close();
    }
}

function duplicate_field($field_id)
{ 
    $data = get_field($field_id);
    $field = new Field;
    $field->create($field_id, $data["text"], $data["type"], $data["required"]);
    $field->duplicate($data["formId"]);
}

function submit_form($form_id, $answers)
{
    $form = get_form($form_id);
    var_dump($form);
}
