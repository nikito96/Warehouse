<?php
  session_start();
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "warehouse";

  $errors = array();

  $nickname = $_POST["nickname"];
  $pass = hash("md5", $_POST["password"]);
  $email = $_POST["email"];
  $phone = $_POST["phone"];

  if($nickname == ''){
    $errors[] = "Nickname should not be empty!";
  }

  if(strlen($nickname) < 5 || strlen($nickname) > 15){
    $errors[] = "Nickname should be between 5 and 15 characters!";
  }

  $nick = str_split($nickname);

  foreach ($nick as $value) {
    if (!(($value >= 'a' && $value <= 'z') || ($value >= 'A' && $value <= 'Z') || $value == '_')) {
      $errors[] = "Nickname should contain capital letter, small letter or underscore!";
    }
  }

  if($pass == ''){
    $errors[] = "Password should not be empty!";
  }

  if(strlen($_POST["password"]) < 6 || strlen($_POST["password"]) > 20){
    $errors[] = "Password should be between 6 and 20 characters!";
  }

  $pwrd = str_split($_POST["password"]);
  $sl = 0;
  $cl = 0;
  $ss = 0;
  $a=0;

  foreach ($pwrd as $value) {
    $a++;
    if($value >= 'a' && $value <= 'z'){
      $sl++;
    }elseif ($value >= 'A' && $value <= 'Z') {
      $cl++;
    }elseif ($value == '@' || $value == '-' || $value == '_' || $value == '~' || $value == '|') {
      $ss++;
    }
  }

  if($sl <= 0 || $cl <= 0 || $ss <= 0){
    $errors[] = "Password should have at least one small letter, one capital letter and a special symbol(@,-,_,~,|)";
  }

  if($email == ''){
    $errors[] = "Email should not be empty!";
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Invalid email format";
    }
  if(preg_match("/^[0-9\s-]*$/", $phone) == 0){
      $errors[] = "Phone should have numbers 0-9 or dash";
  }
  echo count($errors);
  if(count($errors) <= 0){
    try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $sql = "INSERT INTO users (nickname, password, email, phone)
      VALUES ('$nickname', '$pass', '$email', '$phone')";
       $conn->exec($sql);
       header("Location: index.php");
       session_destroy();
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
   }else{
     $_SESSION["errors"] = $errors;
     header("Location: register.php");
   }

  $conn = null;
?>
