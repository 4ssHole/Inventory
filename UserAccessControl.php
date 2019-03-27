<?php
  session_start();
  ob_start();
  
  include("Connection.php");
  include("NavBar.php");
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Registered Users</title>
  <script src="jQuery331.js"></script>
  <link rel="stylesheet" href="styles.css">
</head>

<?php   
  $AdministratorCount = 0;
  $AdministratorCountSQL = mysqli_query($Users,"SELECT COUNT(*) FROM users WHERE Privilege='admin'");
   while ($data = mysqli_fetch_array($AdministratorCountSQL)){
      $AdministratorCount =  $data[0];
   }
?>
<body>

<div class="logo"><a href="#home">SCIENCE LABORATORY</a></div>
<?php DisplayNavBar();
if(!empty($_POST['SelectTable'])) $_SESSION["InitialUserTypeValue"]= $_POST['SelectTable'];  
?>

<div class="MarginForNavBarPersistance">

<form action="" class="forming" method="post" style="margin:1em;margin-bottom:0;">
  <a>User type : </a>
  <select name="SelectTable" class="inputbox" onChange="this.form.submit()">
    <?php
      if($_SESSION["InitialUserTypeValue"]=="admin"){ echo '
        <option value="admin" selected>Administrator</option>
        <option value="user">User</option>';
      }
      else{ echo '
        <option value="admin">Administrator</option>
        <option value="user" selected>User</option>';
      }
    ?>

  </select>
</form> 
  

<div class="TableContainer" style="margin:1em;">
  
  <table id="users" class="newTable">
  <tr>
  <th>
    <input onClick="CheckBoxAll(this)" type="checkbox">
  </th>

<?php
  $tableitems = mysqli_query($Users, "SELECT * FROM users WHERE `Privilege` = '".$_SESSION['InitialUserTypeValue']."'");
  $all_property = array();  

  while ($property = mysqli_fetch_field($tableitems)) { 
    echo '<th onclick="sortTable(0)" style="padding-top: 0;padding-bottom: 0;">'. $property->name . '</th>';
    array_push($all_property, $property->name);
  }

  while ($row = mysqli_fetch_array($tableitems)) {  
  echo '<tr><td style="padding: .75em .75em .75em 0;"><input type="checkbox" name="item"></td>';
  foreach ($all_property as $item){?>

  <td>
    <a class="button-useraccess" href="?id1=<?php echo ($row[0]);?>#popup1">
      <?php echo $row[$item];?>
    </a>
    <div id="popup1" class="overlay">
      <div class="popup"><br>
      <a class="close" href="">&times;</a>
    
  <?php
    if($_SESSION['InitialUserTypeValue']=="user"){
      if($AdministratorCount > 2) echo 'MAXIMUM NUMBER OF ADMINISTRATORS';
      
      else if($AdministratorCount<=2) echo 'CHANGE USER TO ADMINISTRATOR?
      <form method="post"><input type="submit" class="LargeSubmitButton" value="Confirm" name="MakeAdministratorConfirmed"></form>';
    }
    else if($_SESSION['InitialUserTypeValue']=="admin"){
      if($AdministratorCount > 1) echo 'CHANGE ADMINISTRATOR TO USER?
      <form method="post"><input type="submit" class="LargeSubmitButton" value="Confirm" name="MakeUserConfirmed"></form>';
      
      else if($AdministratorCount<=1) echo 'MINIMUM NUMBER OF ADMINISTRATORS';
      
    }
  }
}
?>
  </div>
  </div>
  </td>
  </tr>



<script> 
  var header = document.getElementById("myHeader");
  var sticky = header.offsetTop;

  window.onscroll = function() {if (window.pageYOffset > sticky) header.classList.add("sticky");else header.classList.remove("sticky");};

  function CheckBoxAll(source) {
    checkboxes = document.getElementsByName('item');  for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = source.checked;
  }

    $('#customers').find('tr').click(function(){
    var x = ($(this).index()-1);
    checkboxes = document.getElementsByClassName("ItemCheckboxes"); 
    
    if(!$(checkboxes[x]).is(":checked")){
      $(checkboxes[x]).prop("checked",true);
    }
    else{
      $(checkboxes[x]).prop("checked",false);
    }


  });

</script>
</body>
</html>

<?php

if(isset($_POST['MakeUserConfirmed'])){
  mysqli_query($Users, "UPDATE users SET Privilege='user' WHERE UserNumber='".$_GET['id1']."'");
  header('Location: UserAccessControl.php#');
}

if(isset($_POST['MakeAdministratorConfirmed'])){
  mysqli_query($Users, "UPDATE users SET Privilege='admin' WHERE UserNumber='".$_GET['id1']."'");
  header('Location: UserAccessControl.php#');
}

?>