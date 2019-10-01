<?php
require_once("field.php");

class Form
{
    public $id = 1;
    public $fields = [];
    public $required = false;

    function set_id($id) {
        $this->id = $id;
    }

    function set_required($required)
    {
        $this->required = $required;
    }

    function add_field($new_field)
    {
        array_push($this->fields, $new_field);

        $mysqli = new mysqli("localhost", "root", "", "poll");
        $prepared = "INSERT INTO fields (type, text) VALUES (?, ?)";
        if ($stmt = $mysqli->prepare($prepared)) {
            $stmt->bind_param("ss", $new_field->field_type, $new_field->field_text);
            $stmt->execute();
        }
    }
}
