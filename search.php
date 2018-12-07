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

  $search = $_POST["search"];
  $category = $_POST["category"];
  $code = $_POST["code"];

  try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if($search == "" && $code == ""){
        $resultArray = "empty";
      }else{
        if(strcmp("", $code) == 0){
          if(strcmp("all", $category) == 0){
            $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE '%$search%'");
          }else{
            $stmt = $conn->prepare("SELECT * FROM products WHERE category='$category' AND name LIKE '%$search%'");
          }
        }else {
          $stmt = $conn->prepare("SELECT * FROM products WHERE code='$code'");
        }
        $stmt->execute();

        $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

      $_SESSION["result"] = $resultArray;
      header("Location: warehouse.php");
  }
  catch(PDOException $e) {
    $message = "Date: " . date("H:i:s d.m.Y г.");
    $message .= "\r\nFile: " . $e->getFile();
    $message .= "\r\nLine: " . $e->getLine();
    $message .= "\r\nError message: " . $e->getMessage();
    $message .= "\r\n\r\n";
    error_log($message, 3, "errorLogs.txt");
    echo "<p>Oops, Something went wrong...</p>";
  }
  $conn = null;
?>
