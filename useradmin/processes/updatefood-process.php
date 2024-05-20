<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];

if (isset($_POST["info"]))
{
    $name = $_POST["name"];
    $ctg = $_POST["ctg"];
    $cost = $_POST["cost"];
    $desc = $_POST["desc"];
    
    $sql = "UPDATE foods SET name = ?, cost = ?, description = ?, category = ? WHERE id = '$id'";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "ssss", $name, $cost, $desc, $ctg);
    if ($stmt->execute())
    {
        header("location: ../../useradmin/");
    }
    else die ("error");
}
elseif (isset($_POST["img"]))
{
    $image = uploadImage(generateID(getCurrentDateTime()));
    
    $sql = "UPDATE foods SET image = ? WHERE id = '$id'";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "s", $image);
    if ($stmt->execute())
    {
        header("location: ../../useradmin/");
    }
    else die ("error");
}
elseif (isset($_POST["disable"]))
{
    $sql = "UPDATE foods SET archived = true WHERE id = '$id'";
    if ($mysqli->query($sql)) header("location: ../../useradmin/");
    else die ("error");
}
elseif (isset($_POST["enable"]))
{
    $sql = "UPDATE foods SET archived = false WHERE id = '$id'";
    if ($mysqli->query($sql)) header("location: ../../useradmin/");
    else die ("error");
}
?>