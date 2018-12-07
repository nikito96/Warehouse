<?php
  session_start();
  if(!isset($_SESSION["nickname"])){
    session_destroy();
    header("Location: index.php");
  }
?>
<html>
<head>
  <title>Edit product</title>
  <link rel="stylesheet" type="text/css" href="css/edit.css">
</head>
<body>
  <form method="post" action="edit.php">
    <?php
      $_SESSION["editId"] = $id = $_GET['id'];
      try {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "warehouse";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM products WHERE ID=".$id);
        $stmt->execute();
        $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      catch(PDOException $e) {
        $message = "Date: " . date("H:i:s d.m.Y г.");
        $message .= "\r\nFile: " . $e->getFile();
        $message .= "\r\nLine: " . $e->getLine();
        $message .= "\r\nError message: " . $e->getMessage();
        $message .= "\r\nStack trace: " . $e->getTraceAsString();
        $message .= "\r\n\r\n";
        error_log($message, 3, "errorLogs.txt");
        echo "<p>Oops, Something went wrong...</p>";
      }
      echo "<center>";
      echo "<label for='name'>Name:</label>";
      echo "<input type='text' id='name' name='name' value='".$resultArray[0]['name']."'>";
      echo "<label for='description'>Description:</label>";
      echo "<input type='text' id='description' name='description' value='".$resultArray[0]['description']."'>";
      echo "<label for='img'>Image:</label>";
      echo"<input type='file' name='img' id='img'/>";
      echo "<label for='purchase_price'>Purchase price:</label>";
      echo "<input type='text' id='purchase_price' name='purchase_price' value='".$resultArray[0]['purchase_price']."'>";
      echo "<label for='sell_price'>Sell price:</label>";
      echo "<input type='text' id='sell_price' name='sell_price' value='".$resultArray[0]['sell_price']."'>";
      echo "<label for='quantity'>Quantity:</label>";
      echo "<input type='text' id='quantity' name='quantity' value='".$resultArray[0]['quantity']."'>";
      echo "<label for='category'>Category:</label>";
      echo "<select name='category' id='category'>";
      switch ($resultArray[0]['category']) {
        case 'food':
          echo "<option value='food' selected>Food supplies</option>
            <option value='stationery'>Stationery</option>
            <option value='materials'>Building materials</option>";
          break;
        case 'stationery':
          echo "<option value='food' selected>Food supplies</option>
            <option value='stationery' selected>Stationery</option>
            <option value='materials'>Building materials</option>";
          break;
        case 'materials':
          echo "<option value='food' selected>Food supplies</option>
            <option value='stationery' selected>Stationery</option>
            <option value='materials' selected>Building materials</option>";
          break;
      }
      echo "</select>";
      echo "<label for='code'>Code:</label>";
      echo "<input type='text' id='code' name='code' value='".$resultArray[0]['code']."'>";
      echo "<input type='submit' name='submit' value='Edit'>";
      echo "<a href='warehouse.php'>Return to warehouse</a>";
      echo "</center>";
      $conn = null;
    ?>
  </from>
</body>
</html>
