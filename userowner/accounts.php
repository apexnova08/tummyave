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
        <h1 style="float: left; margin: 0;">Active Accounts</h1>
        <a href="../account/createaccount.php" style="float: right;"><button>Create Account</button></a>
    </div>
    <table>
        <tr style="background-color: darkorange; color: black;">
            <td>ID</td>
            <td>Name</td>
            <td>Type</td>
            <td></td>
        </tr>

        <?php
        $result_active = $mysqli->query("SELECT * FROM users WHERE (type = 2 OR type = 3) AND disabled = false");
        while ($row = $result_active->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["username"] ?></td>
            <td><?= $usertypes[$row["type"]] ?></td>
            <td><form method="post" action="processes/account-process.php">
                <input style="background-color: red;" type="submit" name="disable" value="Disable"/>
                <input type="hidden" name="id" value="<?= $row['id'] ?>"/>
            </form></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    if (mysqli_num_rows($result_active) === 0)
    {
        echo "<h2 style='width: 100%; text-align: center;'>(Empty)</h2>";
    }
    ?>
</div></br></br>

<div>
    <h1>Disabled Accounts</h1>
    <table>
        <tr style="background-color: darkorange; color: black;">
            <td>ID</td>
            <td>Name</td>
            <td>Type</td>
            <td></td>
        </tr>

        <?php
        $result_disabled = $mysqli->query("SELECT * FROM users WHERE (type = 2 OR type = 3) AND disabled = true");
        while ($row = $result_disabled->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["username"] ?></td>
            <td><?= $usertypes[$row["type"]] ?></td>
            <td><form method="post" action="processes/account-process.php">
                <input type="submit" name="enable" value="enable"/>
                <input type="hidden" name="id" value="<?= $row['id'] ?>"/>
            </form></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    if (mysqli_num_rows($result_disabled) === 0)
    {
        echo "<h2 style='width: 100%; text-align: center;'>(Empty)</h2>";
    }
    ?>
</div>

</body>
</html>
