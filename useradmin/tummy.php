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
    <title>Admin Panel | Tummy Avenue</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    include 'nav.php';
    ?>

</head>

<body>

<!--#####-->
<!-- ## NEWS ## -->
<section id="section_name" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="news.php" class="epic-a">View all published news ></a></div>
        <div>
            <h2 class="heading">Featured &nbsp; Tummy &nbsp; News</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM news WHERE NOT `hidden` ORDER BY `date` DESC");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8" style="overflow: hidden; margin-bottom: 10px;">
                    <img src="<?= '../img-uploads/' . $row["image"] ?>" style="width: 150px; height: 80px; object-fit: cover; float: left" alt="image"/>
                    <div style="margin: 10px 0 0 20px; float: left;">
                        <h3><?= $row["title"] ?></h3>
                        <label class="epic-sanssb"><?= getLongDateFormat($row["date"]) ?></label>
                    </div>
                </div>
                <div class="col-md-4 right">
                    <label class="epic-sanssb" style="color: <?= $boolColor[$row["hidden"]] ?>;"><em><?= $publicString[$row["hidden"]] ?></em></label>
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            ?>
        </div>
    </div>
</section>


<!-- ## FEEDBACKS ## -->
<section id="feedbacks" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="feedbacks.php" class="epic-a">See more feedbacks ></a></div>
        <div>
            <h2 class="heading">Recent &nbsp; Customer &nbsp; Feedbacks</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM feedbacks ORDER BY `date` DESC LIMIT 3");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8" style="overflow: hidden; margin-bottom: 10px;">
                    <h3><?= $users[$row["user_id"]]["name"] ?></h3>
                    <label class="epic-sanssb"><?= getLongDateFormat($row["date"]) ?></label>
                    <p class="epic-sanssb"><em>"<?= $row["feedback"] ?>"</em></p>
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            ?>
        </div>
    </div>
</section>


<!-- ## HOME GALLERY ##-->
<section id="gallery" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="gallery.php" class="epic-a">All images ></a></div>
        <div>
            <h2 class="heading">Tummy &nbsp; Gallery &nbsp; (Homepage)</h2>
            <hr class="heading_space">
        </div>
        <div>
            <div class="grid_layout">
                <div class="zerogrid">
                    <div class="wrap-container">
                        <?php
                        $result = $mysqli->query("SELECT * FROM gallery ORDER BY `date` DESC LIMIT 3");
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-1-3 mix work-item">
                            <div class="wrap-col first" style="overflow: hidden; padding: 0; margin: 0 10px 30px 10px; box-shadow: 2px 2px 10px;">
                                <div class="item-container">
                                    <img src="../img-uploads/<?= $row['filename'] ?>" style="width: center; height: 255px; object-fit: cover;" alt="<?= $row['filename']; ?>"/>
                                    <div class="overlay food-item" style="cursor: pointer;">
                                        <a class="fancybox overlay-inner" href="../img-uploads/<?= $row['filename'] ?>" data-fancybox-group="gallery"><i class=" icon-eye6"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ## EVENT GALLERY ##-->
<section id="gallery" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="event_gallery.php" class="epic-a">All images ></a></div>
        <div>
            <h2 class="heading">Event &nbsp; Gallery &nbsp; (Venue)</h2>
            <hr class="heading_space">
        </div>
        <div>
            <div class="grid_layout">
                <div class="zerogrid">
                    <div class="wrap-container">
                        <?php
                        $result = $mysqli->query("SELECT * FROM event_gallery ORDER BY `date` DESC LIMIT 3");
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-1-3 mix work-item">
                            <div class="wrap-col first" style="overflow: hidden; padding: 0; margin: 0 10px 30px 10px; box-shadow: 2px 2px 10px;">
                                <div class="item-container">
                                    <img src="../img-uploads/<?= $row['filename'] ?>" style="width: center; height: 255px; object-fit: cover;" alt="<?= $row['filename']; ?>"/>
                                    <div class="overlay food-item" style="cursor: pointer;">
                                        <a class="fancybox overlay-inner" href="../img-uploads/<?= $row['filename'] ?>" data-fancybox-group="gallery"><i class=" icon-eye6"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ## OTHERS ##-->
<section id="gallery" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Others</h2>
            <hr class="heading_space">
        </div>
        <div>
            <h3 class="epic-sanssb epic-txt25 epic-upper">System Variables</h3></br>
            <a href="vars.php"><button class="epic-btnr">Update system variables</button></a>
            <h3 class="epic-sanssb epic-txt25 epic-upper" style="margin-top: 50px;">About Us</h3></br>
            <a href="about.php"><button class="epic-btnr">Configure about us page</button></a>
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
