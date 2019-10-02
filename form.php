<?php
require_once("field.php");

class Form
{
    public $id = 1;
    public $fields = [];
    public $title = "";
    public $date;

    function create($id, $title, $date)  {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
    }

    function set_id($id) {
        $this->id = $id;
    }

    function set_title($title) {
        $this->title = $title;
    }

    function add_field($new_field)
    {
        $mysqli = new mysqli("localhost", "root", "", "poll");
        $prepared = "INSERT INTO fields (type, text) VALUES (?, ?)";
        if ($stmt = $mysqli->prepare($prepared)) {
            $stmt->bind_param("ss", $new_field->field_type, $new_field->field_text);
            $stmt->execute();
        }
    }

    function save() {
        $mysqli = new mysqli("localhost", "root", "", "poll");
        $prepared = "INSERT INTO forms (title, date) VALUES (?, ?)";
        if ($stmt = $mysqli->prepare($prepared)) {
            $stmt->bind_param("ss", $this->title, date("m-d-Y"));
            $stmt->execute();
        }
    }
}
