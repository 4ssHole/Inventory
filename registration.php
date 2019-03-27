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
    @import url("../styles.css");
  </style>
</head>

<?php

if(isset($_POST["button-index"]))
{

  $email = $_POST['userName'];
  $stmt = $pdo->prepare("SELECT * FROM users WHERE UserName=?");
  $stmt->execute([$email]);

  $user = $stmt->fetch();
  if ($user) {
    echo "User already exists<br/>";
  } else {
    $insert="INSERT INTO users(UserName,Password,FirstName,LastName) values('".$_POST['userName']."','".$_POST['password']."','".$_POST['firstName']."','".$_POST['lastName']."')";

    $STH = $pdo->prepare($insert);
    $STH->execute();
    header("location:index.php");
  } 

  $stmt = $pdo->prepare('SELECT * FROM users WHERE UserName="'.$_POST['userName'].'"');

}
?>
<body>


  

  <section class="section">
    
    <div class="logoLogin">
      SCIENCE LABORATORY
    </div>
    
    <form action="#" method="post">
      <div class="grid-container-register">
        <div class="grid-item-register"><input class="input-register" style="float: right;" name="userName" type="text" placeholder="User Name"></div>
        <div class="grid-item-register"><input class="input-register" name="password" type="password" placeholder="Password"></div>

        <div class="grid-item-register"><input class="input-register" style="float: right;" name="firstName" type="text" placeholder="First Name"></div>
        <div class="grid-item-register">
          <input class="input-register" style="width: 14em;" name="lastName" type="text" placeholder="Last Name">
          <button class="button-index" name="button-index" type="submit">
            register
            <img style="width: 0.8em;" src="img\enter-button.png">
          </button>
        </div>
      </div>
    </form>  
  </section>

<div class="footer-container-login">
  <button class="button-index" id="returnToIndex">Return</button>
</div>
<script>
  $(document).on('click', "#returnToIndex", function(){
    console.log("test");
    window.location.href = '..';
  })
</script>
</body>
</html>