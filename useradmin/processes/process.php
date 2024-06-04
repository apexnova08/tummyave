<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

if (isset($_POST["qr"]))
{
    $val = uploadImage(generateID(getCurrentDateTime()));
    $sql = "UPDATE vars SET `value` = '$val' WHERE `name` = 'qrcode'";
}
if (isset($_POST["gcashnum"]))
{
    $val = $_POST["gcashnum"];
    $sql = "UPDATE vars SET `value` = '$val' WHERE `name` = 'gcashnum'";
}
if (isset($_POST["pax"]))
{
    $val = $_POST["pax"];
    $sql = "UPDATE vars SET `value` = '$val' WHERE `name` = 'max_pax'";
}
if (isset($_POST["map"]))
{
    $val = explode('"', $_POST["map"])[1];
    $sql = "UPDATE vars SET `value` = '$val' WHERE `name` = 'map_link'";
}

if ($mysqli->query($sql))
{
    header("location: ../vars.php");
}
else die("error");
?>