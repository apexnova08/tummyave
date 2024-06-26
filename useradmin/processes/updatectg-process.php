<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];

$val = "empty string";
$sql = "";
$ctg = "categories";
if ($_POST["ctgupdate"] === "rsv") $ctg = "rsv_categories";
if (isset($_POST["name"]))
{
    $val = $_POST["name"];
    $sql = "UPDATE $ctg SET name = ? WHERE id = '$id'";
}
elseif (isset($_POST["enable"]))
{
    $val = "0";
    $sql = "UPDATE $ctg SET hidden = ? WHERE id = '$id'";
}
elseif (isset($_POST["disable"]))
{
    $val = "1";
    $sql = "UPDATE $ctg SET hidden = ? WHERE id = '$id'";
}
if ($sql != "")
{
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "s", $val);
    if ($stmt->execute())
    {
        header("location: ../categories.php");
    }
    else die("error");
}
?>