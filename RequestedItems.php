<?php
  session_start();
  ob_start();
?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Item Requests</title>
  <script src="jQuery331.js"></script>
  <link rel="stylesheet" href="astyles.css">
</head>
<?php include("Connection.php"); ?>
<?php include("NavBar.php");?>
<body>

<div class="logo"><a href="#home">SCIENCE LABORATORY</a></div>
<?php DisplayNavBar();  $RequestStatus = 0;
if(!empty($_POST['SelectTable'])) $_SESSION["RequestStatus"]= $_POST['SelectTable'];  
?>

<div class="MarginForNavBarPersistance">

<form action="" class="forming" method="post" style="margin:1em;margin-bottom:0;">
  <a>View : </a>
  <select name="SelectTable" class="inputbox" onChange="this.form.submit()">
    <option value="pending" <?php  if($_SESSION["RequestStatus"]=="pending"){ echo 'selected'; $RequestStatus = 0;}?>>Pending Requests</option>
    <option value="confirmed" <?php  if($_SESSION["RequestStatus"]=="confirmed"){ echo 'selected'; $RequestStatus = 1;}?>>Confirmed Requests</option>
  </select>
</form> 
  

<div class="TableContainer" style="margin:1em;">
  
  <table id="customers">
  <tr>
  <th>
    <input onClick="CheckBoxAll(this)" type="checkbox">
  </th>

<?php

  $tableitems = mysqli_query($connection, "SELECT * FROM itemrequests WHERE isApproved = ".$RequestStatus);
  
  $all_property = array();  

  while ($property = mysqli_fetch_field($tableitems)) { 
    echo '<th onclick="sortTable(0)" style="padding-top: 0;padding-bottom: 0;">'. $property->name . '</th>';
    array_push($all_property, $property->name);
  }

  while ($row = mysqli_fetch_array($tableitems)) {  
  echo '<tr><td><input type="checkbox" name="item"></td>';
  foreach ($all_property as $item){?>
  <td>
    <a class="button" href="?itemCodeRequest=<?php echo ($row[0]);?>#popup1">
      <?php echo $row[$item];?>
    </a>
    <div id="popup1" class="overlay">
      <div class="popup"><br>
      <a class="close" href="">&times;</a>
    
  <?php
    if($_SESSION['RequestStatus']=="pending"){
      echo 'CONFIRM REQUEST?<form method="post"><input type="submit" class="LargeSubmitButton" value="Confirm Request" name="ConfirmRequest"></form>';
    }
    else if($_SESSION['RequestStatus']=="confirmed"){
      echo 'DENY REQUEST?<form method="post"><input type="submit" class="LargeSubmitButton" value="Deny Request" name="DenyRequest"></form>';
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

if(isset($_POST['ConfirmRequest'])){
  mysqli_query($connection, "UPDATE itemrequests SET isApproved='1' WHERE `Item Code`='".$_GET['itemCodeRequest']."';");
  header('Location: #');
}

if(isset($_POST['DenyRequest'])){
  mysqli_query($connection, "UPDATE itemrequests SET isApproved='0' WHERE `Item Code`='".$_GET['itemCodeRequest']."';");
  header('Location: #');
}

?>