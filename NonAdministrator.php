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
</head>

<body>

<?php include("Connection.php");?>
<?php include("NavBar.php"); date_default_timezone_set("Asia/Manila");?>

<div class="logo"><a>SCIENCE LABORATORY</a></div>

<?php
  $AddItemsFieldsSQL = mysqli_query($connection, "SELECT * FROM `! list of all items` WHERE Category ='".$_SESSION["FilterValue"]."';"); 
  $tablenames = mysqli_query($connection, "SELECT categories FROM `categories`");$categoryNameArray = array(); 

  DisplayNonAdminNavBar();
?>

<div class="MarginForNavBarPersistance">  
  <form class="forming" method="post" style="margin:1em .25em 0 1em;display: inline-block;">
    <a>Category : </a><select name="SelectTable" class="inputbox" onChange="this.form.submit()">
      <option value="All items">All Items</option>
      
  <?php
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
  
    


<form method="post" style="display: inline;">

<input type="submit" formaction="#ConfirmDelete" class="NewButton" name="ShowBorrowConfirm" value="Borrow Selected Items">
    <div id="ConfirmDelete" class="overlay">
      <div class="popup">
      <a style="font-size:2.5em;">BORROW ITEMS</a>
      <a class="close" href="">&times;</a>
        <input type="submit" formaction="#" name="ConfirmBorrow" value="Confirm" class="LargeSubmitButton">  
        <?php
          if(isset($_POST['ShowBorrowConfirm'])){ //displays ui 

             foreach($_POST['checklist'] as $selectedForBorrow){ 
               
              array_push($_SESSION['checkedCheckboxes'],$selectedForBorrow);
              
              $selectedItemData = mysqli_query($connection,"SELECT * FROM `! list of all items` WHERE `Item Code`='".$selectedForBorrow."'");
              $tableHeaderNamesArray = array();
              $int = 0;

              while ($property = mysqli_fetch_field($selectedItemData)) array_push($tableHeaderNamesArray, $property->name);
              
              echo '<br><form method="post">';
              
              while ($row = mysqli_fetch_array($selectedItemData)){

                foreach ($tableHeaderNamesArray as $item){
                  if($tableHeaderNamesArray[$int]=="Quantity") echo '<input type="number" class="inputbox" placeholder="Quantity" name="Quantity'.$row[1].'">';
                  else echo ' '.$row[$item].' '; 
                  $int++;
                }
              }
            }      
          }
        ?>
      </div>
    </div>

<div class="tableAndLower"><div class="TableContainer" style="margin:1em;"><table id="customers"><tbody><tr><th><input onClick="CheckBoxAll(this)" type="checkbox"></th>

<?php 
  if($_SESSION["FilterValue"] == 'All items'){$tableitems = mysqli_query($connection, "SELECT * FROM `! list of all items`");}
  else{$tableitems = mysqli_query($connection, "SELECT * FROM `! list of all items` WHERE Category ='".$_SESSION["FilterValue"]."';");}

  $tableHeaderNamesArray = array();

  while ($property = mysqli_fetch_field($tableitems)) { //column header
    if($property->name == "Item Code"||$property->name == "Item Number");
    else echo '<th>'. $property->name . '</th>';
    array_push($tableHeaderNamesArray, $property->name);
  }

  while ($row = mysqli_fetch_array($tableitems)) { //row
    echo '<tr>';
    foreach ($tableHeaderNamesArray as $item){ //data 
      if($row[$item]==$row[1])echo '<td><input type="checkbox" name="checklist[]" value="'.$row[$item].'" class="ItemCheckboxes"></td>';
      else if($row[$item]==$row[0]) ;

      else echo '<td><a class="button">'.$row[$item].'</a>';
    }
  }?>
</form>
</tbody>
</table>

<?php 
  if(isset($_POST['ConfirmBorrow'])){ //only sends query does not display ui
    foreach($_SESSION['checkedCheckboxes'] as $selectedFinal){

      mysqli_query($connection, 
      "INSERT INTO itemrequests(`Item Code`,`Quantity`,`User Name`,`Grade Level`,`isApproved`) 
       VALUES ('".$selectedFinal."',".$_POST['Quantity'.$selectedFinal].",'".$_SESSION['FirstName'].$_SESSION['LastName']."','GRADE LEVEL',0)");

    }
    $_SESSION['checkedCheckboxes'] = array();
    header("refresh:0;url=NonAdministrator.php");
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