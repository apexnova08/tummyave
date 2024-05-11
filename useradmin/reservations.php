<?php

include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

// GET USERS
$users = array();
$result_users = $mysqli->query("SELECT * FROM users");
while ($rowuser = $result_users->fetch_assoc())
{
    $users[$rowuser["id"]] = $rowuser;
}

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
<a href="rsvhistory.php"><button>History</button></a>

<div>
    <h1>Reservations</h1>
    <table>
        <tr style="background-color: darkorange; color: black;">
            <td>Reservation Date</td>
            <td>Name</td>
            <td>Contact</td>
        </tr>

        <?php
        $result_rsv = $mysqli->query("SELECT * FROM reservations WHERE status = 'Reserved'");
        while ($rowrsv = $result_rsv->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $rowrsv["rsv_date"] ?></td>
            <td><?= $users[$rowrsv["user_id"]]["name"] ?></td>
            <td><?= $users[$rowrsv["user_id"]]["email"] ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    if (mysqli_num_rows($result_reserved) === 0)
    {
        echo "<h2 style='width: 100%; text-align: center;'>(Empty)</h2>";
    }
    ?>
</div>

<div>
    <h1>Requests</h1>
    <table>
        <tr style="background-color: darkorange; color: black;">
            <td>Reservation Date</td>
            <td>Name</td>
            <td>Contact</td>
            <td>Date Requested</td>
            <td></td>
        </tr>

        <?php
        $result_req = $mysqli->query("SELECT * FROM reservations WHERE status = 'Requested'");
        while ($rowreq = $result_req->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $rowreq["rsv_date"] ?></td>
            <td><?= $users[$rowreq["user_id"]]["name"] ?></td>
            <td><?= $users[$rowreq["user_id"]]["email"] ?></td>
            <td><?= $rowreq["req_date"] ?></td>
            <td><form method="post" action="processes/reserve-process.php">
                <input type="submit" name="reserve" value="accept"/>
                <input type="hidden" name="id" value="<?= $rowreq['id']; ?>"/>
            </form></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    if (mysqli_num_rows($result_requested) === 0)
    {
        echo "<h2 style='width: 100%; text-align: center;'>(Empty)</h2>";
    }
    ?>
</div>

</body>
</html>
