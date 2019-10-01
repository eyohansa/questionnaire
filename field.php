<?php

class Field
{
    public $id;
    public $field_text = "A form field";
    public $field_type = "text";

    function set_type($new_type) {
        $this->field_type = $new_type;
    }

    function set_text($new_text) {
        $this->field_text = $new_text;
    }
}

?>