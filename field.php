<?php

require_once("config.php");

class Field
{
    public $id;
    public $field_text = "A form field";
    public $field_type = "text";
    public $required = false;
    public $form_id;

    function create($id, $text, $type, $required)
    {
        $this->id = $id;
        $this->field_text = $text;
        $this->field_type = $type;
        $this->required = $required;
    }

    function set_type($new_type) {
        $this->field_type = $new_type;
    }

    function set_text($new_text) {
        $this->field_text = $new_text;
    }

    function set_required($required) {
        $this->required = $required;
    }

    function delete() {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($stmt = $mysqli->prepare("DELETE FROM poll WHERE id=?")) {
            $stmt->bind_param("s", $this->id);
            $stmt->execute();
        }
    }

    function save($form_id) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $prepared = "INSERT INTO fields(type, text, required, formId) VALUES (?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($prepared)) {
            $stmt->bind_param("ssss", $this->field_type, $this->field_text, $this->required, $form_id);
            $stmt->execute();
            if ($stmt->error) {
                printf("Error: %s.\n", $stmt->error);
            }
            $stmt->close();
        }
    }

    function duplicate($form_id) {
        var_dump($this);
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $prepared = "INSERT INTO fields (text, type, required, formId) VALUES(?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($prepared)) {
            $stmt->bind_param("ssss", $this->field_text, $this->field_type, $this->required, $form_id);
            $stmt->execute();
            if ($stmt->error) {
                printf("Error: %s.\n", $stmt->error);
            }
            $stmt->close();
        }
    }
}
