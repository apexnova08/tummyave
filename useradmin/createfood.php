<?php 
include 'processes/redirect.php';
?>

<?php
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tummy Avenue | Login</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

</head>

<body>


<!--#####-->
<h1>Login</h1>

<form enctype="multipart/form-data" action="processes/createfood-process.php" method="post">
  <div>
    <label for="name">Name</label>
    <input type="text" id="name" name="name">
  </div>
  <div>
    <label for="image">Image</label>
    <input type="file" id="image" name="image">
  </div>
  <div>
    <label for="cost">Cost</label>
    <input type="number" id="cost" name="cost">
  </div>
  <div>
    <label for="desc">Description</label>
    <textarea id="desc" name="desc"></textarea>
  </div>
  <br/>

  <button>Add</button>
</form>

</body>
</html>
