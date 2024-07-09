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
        <div style="text-align: right;"><a href="../useradmin/" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Add &nbsp; Food &nbsp; to &nbsp; Menu</h2>
            <hr class="heading_space">
        </div>
        <div>
            <form class="col-md-6" enctype="multipart/form-data" method="post" action="processes/createfood-process.php">
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Name</label></br>
                    <input placeholder="Food Name" class="epic-txtbox" type="text" name="name" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Category</label></br>
                    <select class="epic-txtbox" style="text-align: center;" name="ctg" required>
                        <option value="0">Uncategorized</option>
                        <?php
                        $result = $mysqli->query("SELECT * FROM categories WHERE NOT hidden");
                        while ($row = $result->fetch_assoc()) { ?> <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option> <?php }
                        ?>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Image</label></br>
                    <input class="epic-txtbox" type="file" name="image" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Cost</label></br>
                    <input placeholder="0" class="epic-txtbox" type="number" name="cost" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Description</label></br>
                    <textarea placeholder="Type here..." class="epic-txtbox" name="desc" style="resize: none; height: 150px;"></textarea>
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
include '../global/uf/adminfooter.php';
?>

</body>
</html>