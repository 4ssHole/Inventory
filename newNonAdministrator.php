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
  <link rel="stylesheet" href="astyles.css">
  <link rel="stylesheet" href="pop.css">
</head>

<body>

<?php include("Connection.php");?>
<?php include("NavBar.php"); date_default_timezone_set("Asia/Manila");?>
<div class="logo"><a>SCIENCE LABORATORY</a></div>

<?php
  $AddItemsFieldsSQL = mysqli_query($connection, "SELECT * FROM `! list of all items` WHERE Category ='".$_SESSION["FilterValue"]."';"); 
  $tablenames = mysqli_query($connection, "SELECT categories FROM `categories`");

  $categoryNameArray = array(); 
  while ($property = mysqli_fetch_field($tablenames))array_push($categoryNameArray, $property->name);
?>




<?php DisplayNonAdminNavBar();?>

<div class="MarginForNavBarPersistance">  
  <form class="forming" method="post" style="margin:1em .25em 0 1em;display: inline-block;">
    <a>Category : </a><select name="SelectTable" class="inputbox" onChange="this.form.submit()">
      <option value="All items">All Items</option>

<?php
  $tablenames = mysqli_query($connection, "SELECT categories FROM categories");
  $categoryNameArray = array(); 
  while ($property = mysqli_fetch_field($tablenames))array_push($categoryNameArray, $property->name);
  if(!empty($_POST['SelectTable'])) $_SESSION["FilterValue"]= $_POST['SelectTable'];  
  


  while ($row = mysqli_fetch_array($tablenames)) {
    foreach ($categoryNameArray as $item) {
      if($row[$item]==$_SESSION["FilterValue"]) echo '<option value="'.$row[$item].'" selected>' .$row[$item]. '</option>';
      else echo '<option value="'.$row[$item].'">' .$row[$item]. '</option>';
    }
  }

  echo '</select></form>';
?>

  <form action="#ConfirmDelete" method="post" style="display: inline;">
    <input type="submit" name="ShowDeleteConfirm" class="NewButton">Delete Selected Items</a>

    <div id="ConfirmDelete" class="overlay">
      <div class="popup">
      <a style="font-size:2.5em;">YOU ARE ABOUT TO DELETE ITEMS</a>
      <a class="close">&times;</a>
        <input type="submit" name="DeleteRows" value="Confirm" class="LargeSubmitButton">
      </div>
    </div>
  </form>

<div class="tableAndLower">
<div class="TableContainer" style="margin:1em;">
  
  <table id="customers">
  <tbody><tr><th><input onClick="CheckBoxAll(this)" type="checkbox"></th>

<?php 
  if($_SESSION["FilterValue"] == 'All items'){$tableitems = mysqli_query($connection, "SELECT * FROM `! list of all items`");}
  else{$tableitems = mysqli_query($connection, "SELECT * FROM `! list of all items` WHERE Category ='".$_SESSION["FilterValue"]."';");}

  $tableHeaderNamesArray = array();

  while ($property = mysqli_fetch_field($tableitems)) { //column header
    if($property->name == "Item Number"){}
    else{echo '<th>'. $property->name . '</th>';}
    array_push($tableHeaderNamesArray, $property->name);
  }

  while ($row = mysqli_fetch_array($tableitems)) { //row
    echo '<tr>';
    foreach ($tableHeaderNamesArray as $item){ //data 
      if($row[$item]==$row[0])echo '<td><input type="checkbox" name="checklist2[]" value="'.$row[0].'" class="ItemCheckboxes"></td>';
      
      else {
        echo '<td><div>
              <a class="button" href="?id1='.$row[0].'#popup1">'.$row[$item].'</a>
              </div>';
      }
    }
  }
?>
</tbody>
</table>

<?php 
  $tests = '';
    if(isset($_POST['ShowDeleteConfirm'])){
        $numberOfItemsToDelete=0;
        foreach($_POST['checklist2'] as $selectedForDelete){
          $numberOfItemsToDelete++;
          echo 'test';
        }
      }

  if(isset($_POST['DeleteRows'])){ //Delete function REMINDER: CHECKLIST NEEDS TO BE IN ONE FORM
    foreach($_POST['checklist2'] as $selectedForDelete){
      mysqli_query($connection, "DELETE FROM `! list of all items` WHERE `Item Number` = ".$selectedForDelete);
    }
    //header("refresh:1;url=InventoryAdministrator.php");
  }

?>
<script> 
  var header = document.getElementById("myHeader");
  var sticky = header.offsetTop;

  window.onscroll = function() {if (window.pageYOffset > sticky) header.classList.add("sticky");else header.classList.remove("sticky");};

  function CheckBoxAll(source) { 
    checkboxes = document.getElementsByClassName("ItemCheckboxes");  
    for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = source.checked;
  }

</script>
</body>
</html>