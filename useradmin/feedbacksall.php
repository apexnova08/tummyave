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
    <title>Admin Panel | Feedbacks</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    include 'nav.php';
    ?>

</head>

<body>

<!--#####-->
<section id="feedbacks" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="feedbacks.php" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Customer &nbsp; Feedbacks</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM feedbacks ORDER BY date DESC");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8" style="overflow: hidden; margin-bottom: 10px;">
                    <h3><?= $users[$row["user_id"]]["name"] ?></h3>
                    <label class="epic-sanssb"><?= getLongDateFormat($row["date"]) ?></label>
                    <p class="epic-sanssb"><em>"<?= $row["feedback"] ?>"</em></p>
                </div>
                <div class="col-md-4 right">
                    <form enctype="multipart/form-data" action="processes/feedback-process.php" method="post">
                        <?php
                        if ($row["hidden"]) echo '<button class="epic-btn">Feature</button>';
                        else echo '<button class="epic-btnred">Hide</button>';
                        ?>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>"/>
                    </form>
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
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
