<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tummy Avenue | Food</title>

<!--CSS-->
<?php 
include 'global/customercss.html';
?>


<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

<?php 
include 'global/loader.html';
?>

<?php 
include 'global/customerheader.html';
?>

<!--Page header & Title-->
<section id="page_header">
<div class="page_title">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
         <h2 class="title">Register</h2>
         <p>Check out our menu and some of our special, featured best sellers!</p>
      </div>
    </div>
  </div>
</div>  
</section>

<!--#####-->
<form action="test.php" method="post">

        <label for="name">Name</label>
        <input type="text" id="name" name="name">

        <label for="email">Name</label>
        <input type="text" id="email" name="email">

        <label for="username">Name</label>
        <input type="text" id="username" name="username">
        
        <label for="password">Name</label>
        <input type="text" id="password" name="password">

        <br>

        <button>Send</button>

    </form>
<!--#####-->
<?php 
include 'global/customerfooter.html';
?>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include 'global/customerjs.html';
?>

</body>
</html>
