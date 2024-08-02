<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tummy Avenue</title>

<!--CSS-->
<?php 
include 'global/customercss.html';
?>
</head>

<body>
<?php 
include 'global/loader.html';
include 'global/customerheader.php';
?>
<!--Page header & Title-->
<section id="page_header">
    <div class="page_title">
        <div class="container">
            <div class="col-md-12">
                <h2 class="title">Page Title</h2>
                <p>Page description</p>
            </div>
        </div>
    </div>  
</section>

<!-- ## CONTENT HERE ## -->
<section id="section_name" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Title &nbsp; White &nbsp; Section</h2>
            <hr class="heading_space">
        </div>
    </div>
</section>


<section id="section_name" class="padding bg_grey">
    <div class="container">
        <div>
            <h2 class="heading">Title &nbsp; Grey &nbsp; Section</h2>
            <hr class="heading_space">
        </div>
    </div>
</section>

<section id="section_name" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Fonts</h2>
            <hr class="heading_space">
        </div>
        <div>
            <p style="font-size: 20px;" class="epic-bebas">Bebas Regular</p>
            <p style="font-size: 20px;" class="epic-sansr">Open Sans</p>
            <p style="font-size: 20px;" class="epic-sansb">Open Sans Bold</p>
            <p style="font-size: 20px;" class="epic-sanssb">Open Sans Semi Bold</p>
        </div>
    </div>
</section>

<!--Page Footer-->
<?php 
include 'global/customerfooter.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--Notifications-->
<section id="notifContainer" class="epic-notifcontainer">
</section>

<!--JS-->
<?php 
include 'global/customerjs.html';
?>
<script type="text/javascript">
    loadDoc();
</script>
 
</body>
</html>