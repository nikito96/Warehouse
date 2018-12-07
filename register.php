<?php
  session_start();

  if(isset($_SESSION["errors"])){
    echo "<ul>";
    foreach ($_SESSION["errors"] as $error) {
      echo "<li>$error</li>";
    }
    echo "</ul>";
  }
  session_destroy();
?>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="css/register.css">
</head>
<body>
  <center>
    <form action="reg.php" method="post">
      <label for="nickname">Nickname:</label>
      <input type="text" id="nickname" name="nickname">
      <label for="password">Password</label>
      <input type="password" id="password" name="password">
      <label for="email">E-mail:</label>
      <input type="text" id="email" name="email">
      <label for="phone">Phone number:</label>
      <input type="text" id="phone" name="phone">
    <input type="submit" value="Register">
    </form>
    <a href="index.php">Back to index</a>
  </center>
</body>
</html>
