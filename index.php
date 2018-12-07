<?php
  session_start();
  if(isset($_SESSION["nickname"])){
    header("Location: warehouse.php");
  }else{
    session_destroy();
  }
?>
<html>
<head>
  <title>Warehouse</title>
  <link rel="stylesheet" type="text/css" href="css/indexStyle.css">
</head>
<body>
  <h1>Warehouse</h1>
  <form action="login.php" method="post">
    <div class="login"><label for="nickname">Nickname:</label>
    <input type="text" name="nickname" id="nickname">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
    <center><input type="submit" value="Login"></div></center>
  </form>
  <center><a href="register.php"><p>Register</p></a></center>
</body>
</html>
