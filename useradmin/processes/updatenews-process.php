<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];

if (isset($_POST["info"]))
{
    $title = $_POST["title"];
    $content = $_POST["content"];
    
    $sql = "UPDATE news SET title = ?, content = ? WHERE id = '$id'";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "ss", $title, $content);
    if ($stmt->execute())
    {
        header("location: ../news.php");
    }
    else die ("error");
}
elseif (isset($_POST["img"]))
{
    $image = uploadImage(generateID(getCurrentDateTime()));
    
    $sql = "UPDATE news SET image = ? WHERE id = '$id'";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "s", $image);
    if ($stmt->execute())
    {
        header("location: ../news.php");
    }
    else die ("error");
}
elseif (isset($_POST["disable"]))
{
    $sql = "UPDATE news SET hidden = true WHERE id = '$id'";
    if ($mysqli->query($sql)) header("location: ../news.php");
    else die ("error");
}
elseif (isset($_POST["enable"]))
{
    $sql = "UPDATE news SET hidden = false WHERE id = '$id'";
    if ($mysqli->query($sql)) header("location: ../news.php");
    else die ("error");
}
?>