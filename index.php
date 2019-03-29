<?php
  session_start();
  ob_start();
?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Inventory System</title>
  <script src="jQuery331.js"></script>
  <style type="text/css">
    @import url("../styles.css");
  </style>
</head>

<?php
  include("Connection.php");

  if(isset($_POST["LoginButton"])){
    $result1= "SELECT * FROM Users WHERE UserName='" .$_POST["UserName"] . "' and Password = '". $_POST["Password"]."'";
    $result = mysqli_query($Users, $result1);
    $count = mysqli_num_rows($result);
    $row  = mysqli_fetch_array($result);

    if($row) {
      $_SESSION["UserName"] = $row[0];
      $_SESSION["Password"] = $row[1];
      $_SESSION["Privilege"] = $row[2];
      $_SESSION["FirstName"] = $row[3];
      $_SESSION["LastName"] = $row[4];
      $_SESSION["GradeLevel"] = $row[5];

      $_SESSION["FilterValue"] = 'All items';
      $_SESSION['InitialUserTypeValue'] = 'admin';
      $_SESSION["RequestStatus"] = 'pending';

      $_SESSION['checkedCheckboxes'] = array();
    }
    if($count == 1)  //if data found is 1
    {
      if($_SESSION["Privilege"] == "admin")
        header("location:InventoryAdministrator.php");
      else header("location:NonAdministrator.php");
    }
    else echo "Incorrect username/password";
  }
?>
<body>

<section class="section">
  <div class="logoLogin">SCIENCE LABORATORY</div>  
  <main class="flex-center">
    <div class="intro">welcome</div>
    <div style="margin-top: 1.75em;">      
      <form action="" method="post">

        <input type="text" name="UserName" id="username" class="input-login" style="display:block; width:14.25em;" placeholder="User name">
        <input type="password" name="Password" class="input-login" style="display:inline; margin-right:0;" placeholder="Password">
        <button class="button" name="LoginButton"> 
          <img src="img\enter-button.png" style="width:1em;"></button>
      
      </form>
    </div>
  </main>
</section>


<div class="footer-container-login">
  <button id="register" class="button-index" type="submit">register here</button>
</div>
<script>
  $(document).ready(function(){
    $("#username").focus(); 
  })

  $(document).on('click', "#register", function(){
    console.log("test");
    window.location.href = 'registration.php';
  })
</script>
</body>
</html>