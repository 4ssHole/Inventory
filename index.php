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
    @import url("LoginStyles.css");
  </style>
</head>

<?php
  include("Connection.php");

  if(isset($_POST["LoginButton"]))
  {
    $result1= "SELECT * FROM Users WHERE UserName='" .$_POST["UserName"] . "' and Password = '". $_POST["Password"]."'";
    $result = mysqli_query($Users, $result1);
    $count = mysqli_num_rows($result);
    $row  = mysqli_fetch_array($result);

    if($row) {
      $_SESSION["UserNumber"] = $row[0];
      $_SESSION["UserName"] = $row[1];
      $_SESSION["Password"] = $row[2];
      $_SESSION["Privilege"] = $row[3];
      $_SESSION["FirstName"] = $row[4];
      $_SESSION["LastName"] = $row[5];
      $_SESSION["GradeLevel"] = $row[6];

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
  <div class="logo" align="center">SCIENCE LABORATORY</div>  
  <main class="flex-center">
    <div class="intro">welcome</div>
    <div style="margin-top: 1.75em;">      
      <form action="" method="post">

        <input type="text" name="UserName" class="inputbox" style="display:block; width:14.25em;" placeholder="User name">
        <input type="password" name="Password" class="inputbox" style="display:inline; margin-right:0;" placeholder="Password">
        <button class="button" name="LoginButton" style="height:2em;"> 
          <img src="img\enter-button.png" style="width:1em;"></button>
      
      </form>
    </div>
  </main>
</section>


<div align="center" id="footer">
  <form action="registration.php">
    <button class="Registerbutton" align="center" type="submit">register here</button>
  </form>
</div>
</body>
</html>