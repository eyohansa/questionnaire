<?php

require_once("field.php");
require_once("config.php");

session_start();

$_SESSION["forms"] = [];

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySql: (" . $mysqli->connect_errno . ")" . $mysqli->error;
}

$query = "CREATE DATABASE IF NOT EXISTS `poll` CHARACTER SET utf8 COLLATE utf8_general_ci";
if ($mysqli->query($query) == TRUE) {
    $query = "USE `poll`";
    $mysqli->query($query);
}
$query = "CREATE TABLE IF NOT EXISTS `forms` (`id` INT AUTO_INCREMENT, `title` VARCHAR(300) NOT NULL, `date` DATE, PRIMARY KEY(`id`))";
if (!$mysqli->query($query) == TRUE) {
    echo $mysqli->error;
}
$query = "CREATE TABLE IF NOT EXISTS `fields` (`id` INT AUTO_INCREMENT, `text` VARCHAR(300) NOT NULL, `type` VARCHAR(8) NOT NULL, `required` BOOLEAN, `formId` INT NOT NULL, PRIMARY KEY(`id`), FOREIGN KEY(`formId`) REFERENCES `forms`(`id`))";
if (!$mysqli->query($query) == TRUE) {
    echo $mysqli->error;
}
$query = "CREATE TABLE IF NOT EXISTS `choices` (`id` INT AUTO_INCREMENT, `text` VARCHAR(300) NOT NULL, PRIMARY KEY(`id`), `fieldId` INT NOT NULL, FOREIGN KEY(`fieldId`) REFERENCES `fields`(`id`))";
if (!$mysqli->query($query) == TRUE) {
    echo $mysqli->error;
}
$query = "CREATE TABLE IF NOT EXISTS `respondents` (`id` INT AUTO_INCREMENT, `filledDate` DATETIME NOT NULL, `formId` INT NOT NULL, PRIMARY KEY(`id`), FOREIGN KEY(`formId`) REFERENCES `forms`(`id`))";
if (!$mysqli->query($query) == true) {
    echo $mysqli->error;
}
$query = "CREATE TABLE IF NOT EXISTS `respondent_forms`(`id` INT AUTO_INCREMENT, `fieldId` INT NOT NULL, `answer` VARCHAR(300), `respondentId` INT NOT NULL, PRIMARY KEY(`id`), FOREIGN KEY(`fieldId`) REFERENCES `fields`(`id`), FOREIGN KEY(`respondentId`) REFERENCES `respondents`(`id`), UNIQUE KEY(`respondentId`, `fieldId`))";
if (!$mysqli->query($query) == true) {
    echo $mysqli->error;
}
$mysqli->close();

include("header.php");

$forms = get_forms();

?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Poll</h2>
        </div>
    </div>

    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="forms.php">Daftar Form</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="addform.php">New Form</a>
        </li>
    </ul>

    <div class="row">
        <div class="col">
            <?php include("partials/forms.php") ?>
        </div>
    </div>
</div>
<?php include("footer.php") ?>