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
  echo "SELECT * FROM users WHERE UserName = '$_POST[userName]';";

  $check="SELECT * FROM users WHERE UserName = '$_POST[userName]';";
  $rs = mysqli_query($Users,$check);
  $data = mysqli_fetch_array($rs, MYSQLI_NUM);
    
  if($data[0] > 1) {
      echo "User already exists<br/>";
  }
  else
  {
    $insert="INSERT INTO users(UserName,Password,Privilege,FirstName,LastName)
    values('".$_POST[userName]."','".$_POST['password']."','user','".$_POST[firstName]."','".$_POST[lastName]."')";
    mysqli_query($Users,$insert);
    header("location:index.php");
  }
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