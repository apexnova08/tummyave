<?php 
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];
$result = $mysqli->query("SELECT * FROM news WHERE id = '$id'");
$news = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | News</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    ?>

</head>

<body>

<!--#####-->
<section id="topBtns" style="padding-top: 30px;">
    <div class="container">
        <form style="overflow: hidden;" enctype="multipart/form-data" action="processes/updatenews-process.php" method="post">
            <?php
            if (!$news["hidden"])
                echo '<button style="float: right;" name="disable" class="epic-btnred">Make &nbsp; News &nbsp; Private</button>';
            else
                echo '<button style="float: right;" name="enable" class="epic-btn">Make &nbsp; News &nbsp; Public</button>';
            ?>
            <input type="hidden" name="id" value="<?= $id ?>"/>
        </form>
    </div>
</section>

<section class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="news.php" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Update &nbsp; News</h2>
            <hr class="heading_space">
        </div>
        <div class="col-md-6">
            <form style="overflow: hidden;" enctype="multipart/form-data" method="post" action="processes/updatenews-process.php">
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Title</label></br>
                    <input placeholder="News Title" class="epic-txtbox" type="text" name="title" value="<?= $news["title"] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">News Content</label></br>
                    <textarea placeholder="Type here..." class="epic-txtbox" name="content" style="resize: none; height: 150px;"><?= $news["content"] ?></textarea>
                </div><br/>

                <button name="info" class="epic-btn" style="float: right;">Update &nbsp; Info</button>
                <input type="hidden" name="id" value="<?= $id ?>"/>
            </form></br></br></br></br>

            <form style="overflow: hidden;" enctype="multipart/form-data" action="processes/updatenews-process.php" method="post" >
                <h3 class="epic-sanssb epic-txt25 epic-upper">News Image</h3></br>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Image</label>
                    <input class="epic-txtbox" type="file" name="image" required>
                </div>
                <input style="float: right;" class="epic-btn" type="submit" name="img" value="Update &nbsp; Food &nbsp; Image">
                <input type="hidden" name="id" value="<?= $id ?>"/>
            </form>
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