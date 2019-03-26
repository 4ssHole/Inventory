<?php
  include("Connection.php");
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Registration</title>
  <script src="jQuery331.js"></script>
  <style type="text/css">
    @import url("LoginStyles.css");

  </style>
</head>

<?php

if(isset($_POST["RegisterButton"]))
{

  $email = $_POST['userName'];
  $stmt = $pdo->prepare("SELECT * FROM users WHERE UserName=?");
  $stmt->execute([$email]); 
  $user = $stmt->fetch();
  if ($user) {
    echo "User already exists<br/>";
  } else {
    $insert="INSERT INTO users(UserName,Password,FirstName,LastName)
    values('".$_POST['userName']."','".$_POST['password']."','".$_POST[firstName]."','".$_POST[lastName]."')";

    $STH = $pdo->prepare($insert);
    $STH->execute();
    //header("location:index.php");
  } 

  $stmt = $pdo->prepare('SELECT * FROM users WHERE UserName="'.$_POST['userName'].'"');

}
?>
<body>
  <a href="index.php" class="NewButton">Return</a>
  <section class="section"><div class="logo"align="center">SCIENCE LABORATORY
</div>
 <form action="#" method="post" style="margin:0 auto; display: inline;">
<div align="center" style="margin-top: 1.5em;margin-bottom: .3em;">
<input class="inputbox" name="userName" style="display: inline;width: 15em;margin:0 auto;" type="text" placeholder="User Name">
<input class="inputbox" name="password" style="display: inline;width: 9.125em;margin:0 auto;" type="password" placeholder="Password">
</div>

<div align="center" style="margin-top: .3em;margin-bottom: .3em;">
  <input class="inputbox" name="firstName" style="display: inline;width: 10em;margin:0 auto;" type="text" placeholder="First Name">
  <input class="inputbox" name="lastName" style="display: inline;width: 12em;margin:0 auto;" type="text" placeholder="Last Name">
  <button class="button" name="RegisterButton" type="submit" style="margin:0 auto; display: inline;height:1.9em;"><img src="img\enter-button.png" style="width:1em;"></button>
 </form>   
</div>
</section>
</body>
</html>