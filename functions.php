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
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT id, title, date FROM forms WHERE id=?")) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($id, $title, $date);
        $stmt->fetch();
        if ($stmt->error) {
            printf("Error: %s.\n", $stmt->error);
        }
        $stmt->close();
        return array(
            "id" => $id,
            "title" => $title,
            "date" => $date
        );
    }
    return array();
}

function get_fields($form_id) {
    $data = array();
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT id, type, text, required FROM fields WHERE formId=?")) {
        $stmt->bind_param("s", $form_id);
        $stmt->execute();
        $stmt->bind_result($id, $type, $text, $required);
        $i = 0;
        while($stmt->fetch()) {
            $data[$i] = array(
                "id" => $id,
                "type" => $type,
                "text" => $text,
                "required" => $required
            );
            $i++;
        }

        if ($stmt->error) {
            printf("Error: %s.\n", $stmt->error);
        }
        $stmt->close();
        return $data;
    }
    return $data;
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

function get_field_count($form_id) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $prepared = "SELECT COUNT(id) AS  NumOfFields FROM fields WHERE formId=?";
    if ($stmt = $mysqli->prepare($prepared))
    {
        $stmt->bind_param("s", $form_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        if ($stmt->error) {
            printf("Error: &s.\n", $stmt->error);
        }
        return isset($count)? $count : 0;
    }
    return 0;
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
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $prepared = "INSERT INTO fields (type, text, required, formId) VALUES (?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($prepared)) {
        $stmt->bind_param("ssss", $data["type"], $data["text"], $data["required"], $data["formId"]);
        $stmt->execute();
        if ($stmt->error) {
            printf("Error: %s\n", $stmt->error());
        }
        $stmt->close();
    }
}

function submit_form($form_id, $answers)
{
    $form = get_form($form_id);
    var_dump($form);
}
