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

function get_choices($field_id) {
    $choices = [];
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT id, text FROM choices WHERE fieldId=?")) {
        $stmt->bind_param("s", $field_id);
        $stmt->execute();
        $stmt->bind_result($id, $text);
        $i = 0;
        while($stmt->fetch()) {
            $choices[$i] = array(
                "id" => $id,
                "text" => $text
            );
            $i++;
        }
        $stmt->close();
    }
    return $choices;
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
    $datetime = date("Y-m-d H:i:s");
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("INSERT INTO respondents (filledDate, formId) VALUES (?, ?)")) {
        $stmt->bind_param("ss", $datetime, $form_id);
        $stmt->execute();
        $stmt->close();
    }
    $respondent_id = $mysqli->insert_id;
    foreach($answers as $answer) {
        submit_answer($respondent_id, $answer["fieldId"], $answer["answer"]);
    }
    return $respondent_id;
}

function submit_answer($respondent_id, $field_id, $answer) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("INSERT INTO respondent_forms (fieldId, answer, respondentId) VALUES (?, ?, ?)")) {
        $stmt->bind_param("sss", $field_id, $answer, $respondent_id);
        $stmt->execute();
        $stmt->close();
    }
}

function get_response_form_id($respondent_id)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT formId FROM respondents WHERE id=?")) {
        $stmt->bind_param("s", $respondent_id);
        $stmt->execute();
        $stmt->bind_result($form_id);
        $stmt->fetch();
        $stmt->close();
        return $form_id;
    }
}

function get_response($respondent_id) {
    $response = [];
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT id, fieldId, answer FROM respondent_forms WHERE respondentId=?")) {
        $stmt->bind_param("s", $respondent_id);
        $stmt->execute();
        $stmt->bind_result($id, $fieldId, $answer);
        while($stmt->fetch()) {
            array_push($response, array(
                "id" => $id,
                "fieldId" => $fieldId,
                "answer" => $answer
            ));
        }
        $stmt->close();
    }
    return $response;
}

function get_answer($respondent_id, $field_id) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT answer FROM respondent_forms WHERE respondentId=? AND fieldId=?")) {
        $stmt->bind_param("ss", $respondent_id, $field_id);
        $stmt->execute();
        $stmt->bind_result($answer);
        $stmt->fetch();
        $stmt->close();
        return $answer;
    }
}

function get_responses($form_id)
{
    $responses = [];
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($stmt = $mysqli->prepare("SELECT id, filledDate FROM respondents WHERE formId=?")) {
        $stmt->bind_param("s", $form_id);
        $stmt->execute();
        $stmt->bind_result($id, $filled_date);
        while($stmt->fetch()) {
            array_push($responses, array(
                "id" => $id,
                "filledDate" => $filled_date
            ));
        }

        $stmt->close();
    }
    return $responses;
}