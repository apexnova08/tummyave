<?php
include 'processes/process-redirect.php';

require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

if (isset($_POST["gcashtrans"]))
{
    $image = uploadImage(generateID(getCurrentDateTime()));
    $id = $_POST["id"];
    
    $sql = "UPDATE orders SET gcash_receipt = ?, status = 'Waiting for cashier confirmation' WHERE id = '$id'";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "s", $image);
    if ($stmt->execute())
    {
        header("location: ../orders.php");
    }
    else die ("error");
}

?>