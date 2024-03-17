<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tummy Avenue | Register</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

</head>

<body>


<!--#####-->
<h1>Register Account</h1>
<form action="processes/register-process.php" method="post">
  <div>
    <label for="name">Name</label>
    <input type="text" id="name" name="name">
  </div>
  <div>
    <label for="email">Email</label>
    <input type="email" id="email" name="email">
  </div>
  <div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username">
  </div>
  <div>
    <label for="password">Passsword</label>
    <input type="password" id="password" name="password">
  </div>

  <button>Register</button>

</form>

</body>
</html>
