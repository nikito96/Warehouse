<?php
  session_start();
  if(!isset($_SESSION["nickname"])){
    session_destroy();
    header("Location: index.php");
  }

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "warehouse";

  $id = $_GET['id'];

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT image FROM products WHERE id=$id");

    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $img = $stmt->fetchAll();
    var_dump($img);
    if($img[0]["image"] != 'empty.png')
      unlink($img[0]["image"]);

      $sql = "DELETE FROM products WHERE id=$id";

      $conn->exec($sql);
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
  header("Location: warehouse.php");
?>
