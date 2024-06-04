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
    <title>Owner Panel | Disabled Accounts</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    include 'nav.php';
    ?>

</head>

<body>

<!--#####-->
<section id="accountsAdmin" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="accounts.php" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Admin &nbsp; Accounts</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result_admin = $mysqli->query("SELECT * FROM users WHERE type = 2 AND disabled");
            while ($row = $result_admin->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8">
                    <div style="float: left; margin: 10px;">
                        <h3 class="epic-sanssb"><?= $row["name"] ?></h3>
                        <label class="epic-sanssb">Account ID: <?= $row["id"] ?></label>
                    </div>
                </div>
                <div class="col-md-4 right">
                    <form style="margin: 10px;" enctype="multipart/form-data" method="post" action="processes/account-process.php">
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <input type="submit" class="epic-btnr" name="enable" value="Enable">
                    </form>
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result_admin) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            ?>
        </div>
    </div>
</section>

<section id="accountsCashier" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Cashier &nbsp; Accounts</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result_cashier = $mysqli->query("SELECT * FROM users WHERE type = 3 AND disabled");
            while ($row = $result_cashier->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8">
                    <div style="float: left; margin: 10px;">
                        <h3 class="epic-sanssb"><?= $row["name"] ?></h3>
                        <label class="epic-sanssb">Account ID: <?= $row["id"] ?></label>
                    </div>
                </div>
                <div class="col-md-4 right">
                    <form style="margin: 10px;" enctype="multipart/form-data" method="post" action="processes/account-process.php">
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <input type="submit" class="epic-btnr" name="enable" value="Enable">
                    </form>
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result_cashier) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            ?>
        </div>
    </div>
</section>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

</body>
</html>
