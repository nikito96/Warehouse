<?php
  session_start();
  if(!isset($_SESSION["nickname"])){
    session_destroy();
    header("Location: index.php");
  }
?>
<head>
  <title>Warehouse</title>
  <link rel="stylesheet" type="text/css" href="css/warehouse.css">
  <script src="scripts/script.js"></script>
</head>
<body>
  <div><a href="newProduct.php" id="newProduct">New product</a></div>
  <div><a href="logout.php" id="logout">Log out</a></div>
  <center>
    <form action="search.php" method="post">
      <label for="search">Product:</label>
      <input type="text" name="search" id="search">
      <label for="category">Category:</label>
      <select name="category" id="category">
        <option value="all">All</option>
        <option value="food">Food supplies</option>
        <option value="stationery">Stationery</option>
        <option value="materials">Building materials</option>
      </select>
      <label for="code">Code:</label>
      <input type="text" name="code" id="code">
      <input type="submit" value="Search">
    </form>
  </center>
  <?php
    if(isset($_SESSION["result"])){
      $result = $_SESSION["result"];
      if(empty($result) || $result == "empty"){
        echo "<h1>No results found!</h1>";
      }else{
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Name</th>";
        echo "<th>Description</th>";
        echo "<th>Image</th>";
        echo "<th>Purchase price</th>";
        echo "<th>Sell price</th>";
        echo "<th>Quantity</th>";
        echo "<th>Category</th>";
        echo "<th>Code</th>";
        echo "<th>actions</th>";
        echo "</tr>";
        foreach ($result as $value) {
          echo "<tr>";
          echo "<td>".$value['ID']."</td>";
          echo "<td>".$value['name']."</td>";
          echo "<td>".$value['description']."</td>";
          echo "<td><img src='".$value['image']."'/></td>";
          echo "<td>".$value['purchase_price']."</td>";
          echo "<td>".$value['sell_price']."</td>";
          echo "<td>".$value['quantity']."</td>";
          echo "<td>".$value['category']."</td>";
          echo "<td>".$value['code']."</td>";
          echo "<td><a href='editPage.php?id=".$value['ID']."'/>Edit</a><button onClick='deleteFunc(".$value['ID'].")'>Delete</button></td>";
          echo "<tr>";
        }
        echo "<table>";
      }
    }
  ?>
</body>
</html>
