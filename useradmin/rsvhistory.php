<?php

include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Menu</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    
    <!--NAV-->
    <?php 
    include 'nav.php';
    ?>

</head>

<body>


<!--#####-->
<div>
    <div style="position: relative; display: inline-block; width: 100%">
        <h1 style="float: left; margin: 0;">History</h1>
        <a href="reservations.php" style="float: right;"><button>Back</button></a>
    </div>
    <table>
        <tr style="background-color: darkorange; color: black;">
            <td>Date Requested</td>
            <td>Reservation Date</td>
            <td>Name</td>
            <td>Contact</td>
            <td>Status</td>
            <td>Date Processed</td>
        </tr>

        <?php
        $result = $mysqli->query("SELECT * FROM reservations");
        while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $row["req_date"] ?></td>
            <td><?= $row["rsv_date"] ?></td>
            <td><?= $row["user_id"] ?></td>
            <td><?= $row["user_id"] ?></td>
            <td><?= $row["status"] ?></td>
            <td><?= $row["process_date"] ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>

</body>
</html>
