<?php
  session_start();
  $servername = "localhost:3306";
  $username = "root";
  $password = "";

  $nickname = $_POST["nickname"];
  $pass = md5($_POST["password"]);

  try {
    $conn = new PDO("mysql:host=$servername;dbname=warehouse", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT nickname, password FROM Users WHERE nickname = :nickname AND password = :password");
    $stmt->bindParam(':nickname', $nickname);
    $stmt->bindParam(':password', $pass);
    $stmt->execute();
    $count = $stmt->rowCount();

    if($count > 0){
      $_SESSION["nickname"] = $nickname;
      header("Location: warehouse.php");
    }else{
      header("Location: index.php");
    }

    }
  catch(PDOException $e)
    {
      $message = "Date: " . date("H:i:s d.m.Y г.");
      $message .= "\r\nFile: " . $e->getFile();
      $message .= "\r\nLine: " . $e->getLine();
      $message .= "\r\nError message: " . $e->getMessage();
      $message .= "\r\nStack trace: " . $e->getTraceAsString();
      $message .= "\r\n\r\n";
      error_log($message, 3, "errorLogs.txt");
      echo "<p>Oops, Something went wrong...</p>";
  }
  $conn = null;
?>
