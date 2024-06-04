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
    <title>Admin Panel | About Section</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    ?>

</head>

<body>

<!--#####-->
<section id="section_name" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="about.php" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Add &nbsp; About &nbsp; Us &nbsp; Section</h2>
            <hr class="heading_space">
        </div>
        <div>
            <form class="col-md-6" enctype="multipart/form-data" method="post" action="processes/createabout-process.php">
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Title</label></br>
                    <input placeholder="Section Title" class="epic-txtbox" type="text" name="title" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Content</label></br>
                    <textarea placeholder="Type here..." class="epic-txtbox" name="content" style="resize: none; height: 150px;" required></textarea>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Image</label></br>
                    <input class="epic-txtbox" type="file" name="image" required>
                </div>
                
                <br/>
                <button class="epic-btn" style="float: right;">Add</button>
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