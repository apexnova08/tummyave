<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];
$sql = "";
if (isset($_POST["disable"])) $sql = "UPDATE users SET disabled = true WHERE id = '$id'";
elseif (isset($_POST["enable"])) $sql = "UPDATE users SET disabled = false WHERE id = '$id'";

// UPDATE
if ($mysqli->query($sql))
{
    echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
}
else
{
    echo "sex";
    die ("sex");
}
?>