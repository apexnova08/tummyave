<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];
$feedback = $mysqli->query("SELECT * FROM feedbacks WHERE id = '$id'")->fetch_assoc();

$hidden = "0";
if ($feedback["hidden"] === "0") $hidden = "1";

if ($mysqli->query("UPDATE feedbacks SET hidden = '$hidden' WHERE id = '$id'"))
{
    header("location: ../feedbacks.php");
}
else die ("error");

?>