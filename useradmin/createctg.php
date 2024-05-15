<?php 
include 'processes/redirect.php';
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
<h1>Login</h1>

<form enctype="multipart/form-data" action="processes/createctg-process.php" method="post">
    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name">
    </div>

    <button>Add</button>
</form>

</body>
</html>