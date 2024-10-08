<?php
session_start();
if (isset($_SESSION["user_id"]))
{
  $mysqli = require __DIR__ . "/../database.php";
  $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";
  $result = $mysqli->query($sql);
  $user = $result->fetch_assoc();
}
session_abort();

$config = parse_ini_file(__DIR__ . "/../config.ini", true);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="<?= $config["fajs"]["link"] ?>" crossorigin="anonymous"></script>
    </head>
    <body>
      <!--Topbar-->
      <div class="topbar">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <p class="pull-left hidden-xs">Welcome to Tummy Avenue!!</p>
              <p class="pull-right"><i class="fa fa-phone"></i>Order Online +63 915 355 3703</p>
            </div>
          </div>
        </div>
      </div>

      <!--Header-->
      <header id="main-navigation">
        <div id="navigation" data-spy="affix" data-offset-top="20">
          <div class="container">
            <div class="row">
            <div class="col-md-12">
              <nav class="navbar navbar-default">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#fixed-collapse-navbar" aria-expanded="false"> 
                  <span class="icon-bar top-bar"></span> <span class="icon-bar middle-bar"></span> <span class="icon-bar bottom-bar"></span> 
                  </button>
                <a class="navbar-brand" href="index.php"><img src="images/HomeLogo.jpg" style="height:70px;width:200px;" alt="logo" class="img-responsive"></a> 
              </div>
              
                  <div id="fixed-collapse-navbar" class="navbar-collapse collapse navbar-right">
                    <ul class="nav navbar-nav">
                      <li>
                        <a href="index.php">Home</a>
                        
                      </li>
                      <li><a href="food.php">Our &nbsp; Food</a></li>
                      
                      <li><a href="reservation.php">Venue &nbsp; Reservation</a></li>
                      
                      <li><a href="about.php">About &nbsp; Us</a></li>
                      
                      <li class="dropdown">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">Account</a>
                        <ul class="dropdown-menu">
                          <?php if (isset($user)): ?>
                            <li><a href="account/account.php"><?= htmlspecialchars($user["name"]) ?></a></li>
                            <?php if ($user["type"] == 0): ?>
                              <li><a href="user0/">Super Admin</a></li>
                            <?php elseif ($user["type"] == 1): ?>
                              <li><a href="userowner/">Owner Panel</a></li>
                            <?php elseif ($user["type"] == 2): ?>
                              <li><a href="useradmin/">Admin Panel</a></li>
                            <?php elseif ($user["type"] == 3): ?>
                              <li><a href="usercashier/">Cashier Panel</a></li>
                            <?php elseif ($user["type"] == 4): ?>
                              <li><a href="usercustomer/reservations.php">Venue Reservations</a></li>
                              <li><a href="usercustomer/orders.php">Orders</a></li>
                            <?php endif ?>
                            <li><a href="account/logout.php">Logout</a></li>
                          <?php else: ?>
                            <li><a href="account/register.php">Register</a></li>
                            <li><a href="account/login.php">Login</a></li>
                          <?php endif; ?>
                        </ul>
                      </li>

                      <li><a href="food.php#cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
                    </ul>
                  </div>
              </nav>
              </div>
            </div>
          </div>
        </div>
      </header>
    </body>
</html>