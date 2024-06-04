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
    <title>Admin Panel | Home Gallery</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    include 'nav.php';
    ?>

</head>

<body>

<!--#####-->
<section id="topBtns" style="padding-top: 30px;">
    <div class="container" style=" overflow: hidden;">
        <button onclick="epicOpenModal()" style="float: right;" class="epic-btn">Upload &nbsp; Image &nbsp; +</button>
    </div>
</section>

<section id="gallery" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Tummy &nbsp; Gallery</h2>
            <hr class="heading_space">
        </div>
        <div>
            <div class="grid_layout">
                <div class="zerogrid">
                    <div class="wrap-container">
                        <?php
                        $result = $mysqli->query("SELECT * FROM gallery ORDER BY `date` DESC");
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-1-3 mix work-item" style="margin-bottom: 40px; text-align: center;">
                            <div class="wrap-col first" style="overflow: hidden; padding: 0; margin: 0 10px 10px 10px; box-shadow: 2px 2px 10px;">
                                <div class="item-container">
                                    <img src="../img-uploads/<?= $row['filename'] ?>" style="width: center; height: 255px; object-fit: cover;" alt="<?= $row['filename']; ?>"/>
                                    <div class="overlay food-item" style="cursor: pointer;">
                                        <a class="fancybox overlay-inner" href="../img-uploads/<?= $row['filename'] ?>" data-fancybox-group="gallery"><i class=" icon-eye6"></i></a>
                                    </div>
                                </div>
                            </div>
                            <form enctype="multipart/form-data" action="processes/gallery-process.php" method="post">
                                <input class="epic-btnrred" type="submit" name="delete" value="Delete">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <input type="hidden" name="table" value="gallery">
                            </form>
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

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content" style="width: 50%;">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2>Upload &nbsp; Image &nbsp; to &nbsp; Gallery</h2>
        </div>
        <div class="epic-modal-body" style="overflow: hidden;">
            <p class="epic-sanssb epic-txt16"><em>Select a file to upload...</em></p>
            <form enctype="multipart/form-data" action="processes/gallery-process.php" method="post">
                <input type="file" class="epic-txtbox" name="image" required>
                <input name="upload" class="epic-btn" style="float: right; margin-top: 20px;" type="submit">
                <input type="hidden" name="table" value="gallery">
            </form>
        </div>
        <div class="epic-modal-footer"><i>tummy-avenue.com</i></div>
    </div>
</div>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

</body>
</html>
