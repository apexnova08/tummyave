<?php
include 'processes/process-redirect.php';

$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

session_start();
$userid = $_SESSION["user_id"];
session_abort();

$sql = "INSERT INTO carts (user_id, food_id, amount) VALUES (?, ?, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "sss", $userid, $_POST["foodId"], $_POST["amount"]);
if ($stmt->execute())
{
    echo '<script type="text/javascript">', 'history.go(-2);', '</script>';
}
else
{
    echo "sex";
    die ("sex");
}

?>