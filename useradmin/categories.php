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
        <h1 style="float: left; margin: 0;">Food Categories</h1>
        <a href="createctg.php" style="float: right;"><button>Create</button></a>
    </div>
    <table>
        <tr style="background-color: darkorange; color: black;">
            <td>ID</td>
            <td>Name</td>
            <td>Hidden</td>
            <td></td>
        </tr>

        <?php
        $result = $mysqli->query("SELECT * FROM categories");
        while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["name"] ?></td>
            <td><?= $row["hidden"] ?></td>
            <td><form method="post" action="updatectg.php">
                <input type="submit" name="action" value="edit"/>
                <input type="hidden" name="id" value="<?= $row['id']; ?>"/>
            </form></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    if (mysqli_num_rows($result) === 0) echo "<h2 style='width: 100%; text-align: center;'>(Empty)</h2>";
    ?>
</div>

</body>
</html>
