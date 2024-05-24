<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];

if (isset($_POST["up"]))
{
    $record = $mysqli->query("SELECT * FROM about WHERE id = '$id'")->fetch_assoc();
    $num = (int)$record["order_num"];
    $nnum  = (int)$record["order_num"] + 1;
    $orecordid = $mysqli->query("SELECT * FROM about WHERE order_num = '$nnum'")->fetch_assoc()["id"];

    $sql = "UPDATE about SET order_num = '$nnum' WHERE id = '$id'";
    if (!$mysqli->query($sql)) die ("error");

    $sql = "UPDATE about SET order_num = '$num' WHERE id = '$orecordid'";
    if ($mysqli->query($sql)) header("location: ../about.php");
    else die ("error");
}
elseif (isset($_POST["down"]))
{
    $record = $mysqli->query("SELECT * FROM about WHERE id = '$id'")->fetch_assoc();
    $num = (int)$record["order_num"];
    $nnum  = (int)$record["order_num"] - 1;
    $orecordid = $mysqli->query("SELECT * FROM about WHERE order_num = '$nnum'")->fetch_assoc()["id"];

    $sql = "UPDATE about SET order_num = '$nnum' WHERE id = '$id'";
    if (!$mysqli->query($sql)) die ("error");

    $sql = "UPDATE about SET order_num = '$num' WHERE id = '$orecordid'";
    if ($mysqli->query($sql)) header("location: ../about.php");
    else die ("error");
}
elseif (isset($_POST["delete"]))
{
    $sql = "DELETE FROM about WHERE id = '$id'";
    if ($mysqli->query($sql)) header("location: ../about.php");
    else die ("error");
}
?>