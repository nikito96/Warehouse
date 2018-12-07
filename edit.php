<?php
  session_start();
  if(!isset($_SESSION["nickname"])){
    session_destroy();
    header("Location: index.php");
  }

  $id = $_SESSION['editId'];
  $name = $_POST["name"];
  $description = $_POST["description"];
  $purchase_price = $_POST["purchase_price"];
  $sell_price = $_POST["sell_price"];
  $quantity = $_POST["quantity"];
  $category = $_POST["category"];
  $code = $_POST["code"];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "warehouse";

  try {
     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $sql = "UPDATE products SET name='$name', description='$description', purchase_price=$purchase_price,
    sell_price=$sell_price, quantity=$quantity, category='$category', code=$code WHERE id=$id";

     $stmt = $conn->prepare($sql);

     $stmt->execute();
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
