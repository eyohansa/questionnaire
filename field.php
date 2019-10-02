<?php

require_once("config.php");

class Field
{
    public $id;
    public $field_text = "A form field";
    public $field_type = "text";
    public $required = false;

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
        $mysqli = new mysqli("localhost", "root", "", "poll");
        if ($stmt = $mysqli->prepare("DELETE FROM poll WHERE id=?")) {
            $stmt->bind_param("s", $this->id);
            $stmt->execute();
        }
    }

    function save($form_id) {
        $mysqli = new mysqli("localhost", "root", "", "poll");
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

    function duplicate() {
        $mysqli = new mysqli("localhost", "root", "", "poll");
        $prepared = "INSERT INTO fields (text, type, required) VALUES(?, ?, ?)";
        if ($stmt = $mysqli->prepare($prepared)) {
            $stmt->bind_param("sss", $this->field_text, $this->field_type, $this->required);
            $stmt->execute();
            if ($stmt->error) {
                printf("Error: %s.\n", $stmt->error);
            }
            $stmt->close();
        }
    }
}
