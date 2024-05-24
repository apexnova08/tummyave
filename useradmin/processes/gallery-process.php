<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

if (isset($_POST["upload"]))
{
    $image = uploadImage(generateID(getCurrentDateTime()));
    $date = getCurrentDateTime();

    $sql = "INSERT INTO gallery (filename, date) VALUES (?, ?)";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "ss", $image, $date);
    if ($stmt->execute())
    {
        header("location: ../gallery.php");
    }
    else die("error");
}
elseif (isset($_POST["delete"]))
{
    $id = $_POST["id"];

    $sql = "DELETE FROM gallery WHERE id = '$id'";
    if ($mysqli->query($sql))
    {
        header("location: ../gallery.php");
    }
    else die("error");
}
?>