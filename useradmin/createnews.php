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
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    ?>

</head>

<body>

<!--#####-->
<section id="section_name" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="news.php" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Publish &nbsp; Tummy &nbsp; News</h2>
            <hr class="heading_space">
        </div>
        <div>
            <form class="col-md-6" enctype="multipart/form-data" method="post" action="processes/createnews-process.php">
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Title</label></br>
                    <input placeholder="News Title" class="epic-txtbox" type="text" name="title" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">News Content</label></br>
                    <textarea placeholder="Type here..." class="epic-txtbox" name="content" style="resize: none; height: 150px;"></textarea>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Image</label></br>
                    <input class="epic-txtbox" type="file" name="image" required>
                </div>
                
                <br/>
                <button class="epic-btn" style="float: right;">Publish</button>
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