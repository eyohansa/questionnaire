<?php

require_once("header.php");

$form_id = $_POST["formId"];

$fields = get_fields($form_id);
$answers = [];
foreach($fields as $field) {
    array_push($answers, array(
        "fieldId" => $field["id"],
        "answer" => $_POST[$field["id"]]
    ));
}
$respondent_id = submit_form($form_id, $answers);

?>

<div class="container">
    <div class="row">
        <div class="col">
            <p>Success</p>
            <a href="/response?id=<?= $respondent_id ?>">Back</a>
        </div>
    </div>
</div>

