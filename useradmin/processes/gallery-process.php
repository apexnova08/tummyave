<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$tablename = $_POST["table"];
if (isset($_POST["upload"]))
{
    $image = uploadImage(generateID(getCurrentDateTime()));
    $date = getCurrentDateTime();

    $sql = "INSERT INTO $tablename (filename, date) VALUES (?, ?)";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "ss", $image, $date);
    if ($stmt->execute())
    {
        header("location: ../$tablename.php");
    }
    else die("error");
}
elseif (isset($_POST["delete"]))
{
    $id = $_POST["id"];

    $sql = "DELETE FROM $tablename WHERE id = '$id'";
    if ($mysqli->query($sql))
    {
        header("location: ../$tablename.php");
    }
    else die("error");
}
?>