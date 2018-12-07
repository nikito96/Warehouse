<?php
  session_start();
  if(!isset($_SESSION["nickname"])){
    session_destroy();
    header("Location: index.php");
  }
  if(isset($_POST["submit"])){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "warehouse";

    $name = $_POST["name"];
    $description = $_POST["description"];
    $purchase_price = $_POST["purchase_price"];
    $sell_price = $_POST["sell_price"];
    $quantity = $_POST["quantity"];
    $category = $_POST["category"];
    $code = $_POST["code"];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $errors = array();

    if(isset($_POST["submit"])) {

      if($name == ''){
        $errors[] = "Name shouldn't be empty!";
      }

      if($purchase_price == ''){
        $errors[] = "Purchase price shouldn't be empty!";
      }

      if($sell_price == ''){
        $errors[] = "Sell price shouldn't be empty!";
      }

      if($quantity == ''){
        $errors[] = "Quantity shouldn't be empty!";
      }

      if($code == ''){
        $errors[] = "Code price shouldn't be empty!";
      }

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT code FROM products WHERE code = '$code'");
        $stmt->execute();
        $count = $stmt->rowCount();

        if($count > 0){
          $errors[] = "Code already exists!";
        }
      } catch (Exception $e) {
        $message = "Date: " . date("H:i:s d.m.Y г.");
        $message .= "\r\nFile: " . $e->getFile();
        $message .= "\r\nLine: " . $e->getLine();
        $message .= "\r\nError message: " . $e->getMessage();
        $message .= "\r\nStack trace: " . $e->getTraceAsString();
        $message .= "\r\n\r\n";
        error_log($message, 3, "errorLogs.txt");
        echo "<p>Oops, Something went wrong...</p>";
      }

        if($_FILES["img"]["tmp_name"] > 0){
          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
          $uploadOk = 0;
          $errors[] = "Invalid file format!";
          }
        }
      }

      if ($uploadOk == 1 && empty($errors)) {
        move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);

      if($_FILES["img"]["name"] == ""){
        $target_file = "empty.png";
      }

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO products (name, description, image, purchase_price, sell_price, quantity, category, code)
        VALUES ('$name', '$description', '$target_file', '$purchase_price', '$sell_price', '$quantity', '$category', '$code')";
        $conn->exec($sql);
        $target_file = "";
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
    }else{
      echo "<ul>";
      foreach ($errors as $error) {
        echo "<li>$error</li>";
      }
      echo "</ul>";
    }
  }
?>
<html>
<head>
  <title>New product</title>
  <link rel="stylesheet" type="text/css" href="css/newProduct.css">
</head>
<body>
  <center>
    <form method="post" enctype="multipart/form-data">
      <label for="name">Name:</label>
      <input type="text" name="name" id="name"/>
      <label for="description">Description:</label>
      <textarea rows="5" cols="35" id="description" name="description"></textarea>
      <label for="img">Image:</label>
      <input type="file" name="img" id="img"/>
      <label for="purchase_price">Purchase price:</label>
      <input type="text" name="purchase_price" id="purchase_price"/>
      <label for="sell_price">Sell price:</label>
      <input type="text" name="sell_price" id="sell_price"/>
      <label for="quantity">Quantity:</label>
      <input type="text" name="quantity" id="quantity"/>
      <label for="category">Category:</label>
      <select name="category" id="category">
        <option value="food">Food supplies</option>
        <option value="stationery">Stationery</option>
        <option value="materials">Building materials</option>
      </select>
      <label for="code">Product code:</label>
      <input type="text" name="code" id="code"/>
      <input type="submit" name="submit" value="Add"/>
    </form>
    <a href="warehouse.php">Return to warehouse</a>
  </center>
</body>
</html>
