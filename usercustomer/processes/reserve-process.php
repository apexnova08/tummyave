<?php
include 'process-redirect.php';

require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

if (isset($_POST["request"]))
{
    $rsv_date = $_POST["year"] . "/" . $_POST["month"] . "/" . $_POST["day"];
    $remarks = $_POST["remarks"];
    $timestart = $_POST["timeS"];
    $timeend = $_POST["timeE"];
    $event = $_POST["event"];
    $pax = $_POST["pax"];
    $cdate = getCurrentDateTime();

    $sql = "INSERT INTO reservations (user_id, req_date, rsv_date, status, time_start, time_end, event, pax, remarks) VALUES (?, ?, ?, 'Requested', ?, ?, ?, ?, ?)";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "ssssssss", $userid, $cdate, $rsv_date, $timestart, $timeend, $event, $pax, $remarks);
    if ($stmt->execute()) header("location: ../../reservation.php"); 
    else die ("Error.");
}
elseif (isset($_POST["cancel"]))
{
    $id = $_POST["id"];
    $sql = "DELETE FROM reservations WHERE id = '$id'";

    if ($mysqli->query($sql)) header("location: ../../reservation.php");
    else die ("Error.");
}
?>