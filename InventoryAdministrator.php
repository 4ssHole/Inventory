<?php   
  session_start();
  ob_start();

  include("Connection.php");
  include("NavBar.php"); 
  date_default_timezone_set("Asia/Manila");
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Inventory System</title>
  <script src="jQuery331.js"></script>
  <link rel="stylesheet" href="styles.css">
</head>

<body>

<div class="logo">SCIENCE LABORATORY</div>

<?php 
  $categoryNameArray = $tableHeaderNamesArray = $addArray = array();

  $categories = mysqli_query($connection, "SELECT * FROM `categories`");

  while ($row = mysqli_fetch_array($categories)) { 
    array_push($categoryNameArray,$row[1]);
  }

  $tableitems = mysqli_query($connection, "SELECT * FROM items");
  
  while ($property = mysqli_fetch_field($tableitems)) {
    if($property->name == "Item Number");
    else{
      array_push($tableHeaderNamesArray, $property->name);
      if($property->name!="Date Updated"&&$property->name !="Date Added"){
        array_push($addArray, $property->name);
      }
    } 
  }

  DisplayNavBar();
?>
<p class="NavBarSpacer">
<div class="tablecontrols">  
  <form style="display: inline" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="TableCategory">Category :</label>
      <select id="TableCategory" name="SelectTable" class="inputbox" onChange="this.form.submit()">
        <option value="All items">All Items</option>
        <?php
          if(!empty($_POST['SelectTable'])) $_SESSION["FilterValue"]= $_POST['SelectTable'];  
          foreach($categoryNameArray as $item){
              if($item==$_SESSION["FilterValue"]) echo '<option value="'.$item.'" selected>' .$item. '</option>';
              else echo '<option value="'.$item.'">' .$item. '</option>';
          }
        ?>
      </select>
    </form>

  <a id="myBtn" class="NewButton">Add Item</a>
  <form method="post" style="display: inline;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <a name="ShowDeleteConfirm" class="NewButton" href="#ConfirmDelete">Delete Selected Items</a>
    <a name="NewCategory" class="NewButton" href="#NewCategory">Modify Categories</a>

    <div id="myModal" class="modal">
      <div class="modal-content"> ADD TO TABLE
        <form method="post">
          <?php 
            $integerCounting = 0;
            $ColumnsForSqlInsert = $valueBuffer = null ;

            foreach($addArray as $header){
              
              echo '<br>';
              
              if($header =="Category"){
                echo '<select class="inputbox" name="addFieldNumber'.$integerCounting.'">';
                foreach($categoryNameArray as $item){
                    if($item==$_SESSION["FilterValue"]) echo '<option value="'.$item.'" selected>' .$item. '</option>';
                    echo '<option value="'.$item.'" >' .$item. '</option>';
                }
                echo '</select>';
              }
              else {
                echo '<input class="inputbox" type="text" name="addFieldNumber'.$integerCounting.'" placeholder="'.$header.'">';
              } 
              
              $ColumnsForSqlInsert .= '`'.$header.'`,';
              $integerCounting++;
            }
          ?>
          <input type="submit" value="submit" name="AddButtonClicked">
        </form>    
      </div>
    </div>
  
  <div id="ConfirmDelete" class="overlay">
    <div class="popup">
      <a style="font-size:2.5em;">YOU ARE ABOUT TO DELETE ITEMS</a>
      <a class="close" href="">&times;</a>
      <input type="submit" name="DeleteRows" value="Confirm" class="LargeSubmitButton">
    </div>
  </div>

  <div id="NewCategory" class="overlay">
    <div class="popup">
    <a style="font-size:1.5em;">MODIFY CATEGORIES</a><br>
      <div style="width: 50%; float:right;">
        <a class="close" href="">&times;</a>ADD<br>
        <input type="input" class="inputbox" name="AddCategoryInput" placeholder="Category">
      </div>
      <div style="height: 90%;width: 50%;float:left;overflow:scroll;">
        <?php
          foreach($categoryNameArray as $item){
            echo '<input type="checkbox" name="'.$item.'">';
            echo '<input type="text" placeholder="'.$item.'"><br>';
          }
        ?>

        <input type="submit" name="AddCategorySubmit" value="Confirm" class="LargeSubmitButton">
      </div>
    </div>
  </div>
</div>

<div class="tableAndLower">
<div class="TableContainer" style="margin:1em;">
  
  <table id="customers">
  <tr><th><input onClick="CheckBoxAll(this)" type="checkbox"></th>
    <?php  
      if($_SESSION["FilterValue"] != 'All items')
        $tableitems = mysqli_query($connection, "SELECT * FROM `! list of all items` WHERE Category ='".$_SESSION["FilterValue"]."';");
      

      foreach($tableHeaderNamesArray as $tableheader){ //header
        echo '<th>'.$tableheader.'</th>';
      }

      while ($row = mysqli_fetch_array($tableitems)) { //row
        echo '<tr id="'.$row[0].'">
                <td><input type="checkbox" name="checklist[]" value="'.$row[0].'" class="ItemCheckboxes"></td>';

        foreach ($tableHeaderNamesArray as $item){ //data 
            echo '<td>
                  <label class="button">'.$row[$item].'</label>'; //shit code #0
        }
        echo '</tr>';
      }
    ?>

</table>
</form>

<?php 
  if(isset($_POST['AddButtonClicked'])){
    // $rs = mysqli_query($connection,"SELECT * FROM `! list of all items` WHERE `Brand`= '' AND `Name` = '' AND `Model` = '' ;");
    // $data = mysqli_fetch_array($rs, MYSQLI_NUM);// if($data[0] > 1) echo "Item already exists";else{}

    for($i = 0;$i<$integerCounting;$i++) {
      $valueBuffer .= '\''.$_POST['addFieldNumber'.$i].'\',';
    }
    echo "INSERT INTO `! list of all items`(".$ColumnsForSqlInsert."`Date Added`) VALUES (".$valueBuffer."'".date("n/d/Y")."')";

    mysqli_query($connection,"INSERT INTO `! list of all items`(".$ColumnsForSqlInsert."`Date Added`) VALUES (".$valueBuffer."'".date("n/d/Y")."')");
    header('refresh:0;url=InventoryAdministrator.php');
  }

  //Add Category
  if(isset($_POST["AddCategorySubmit"])){
    mysqli_query($connection,"INSERT INTO Categories(Categories) VALUES('".$_POST["AddCategoryInput"]."');");
    header("refresh:0;url=InventoryAdministrator.php");
  }

  //Edit
  if(isset($_POST['ChangeRow'])){
    $updateValueToArray = '';$intForModify = 0; 

    foreach ($tableHeaderNamesArray as $Data){
        if($_POST['ModifyAttribute'.$intForModify]!=""){
          $updateValueToArray .= "`".$Data."` = '".$_POST['ModifyAttribute'.$intForModify]."',";
        }
      $intForModify++;
    }

    mysqli_query($connection,"UPDATE `! list of all items` SET ".$updateValueToArray."`Date Updated`='".date("n/d/Y")."' WHERE `Item Number` = ".$_GET['id1'].";");
    header("refresh:0;url=InventoryAdministrator.php");
  }

  if(isset($_POST['DeleteRows'])){ //Delete function REMINDER: CHECKLIST NEEDS TO BE IN ONE FORM
    foreach($_POST['checklist'] as $selectedDelete){
      mysqli_query($connection, "DELETE FROM `! list of all items` WHERE `Item Number` = ".$selectedDelete);
    }
    header("refresh:0;url=InventoryAdministrator.php");
  }
?>

<script> 

  var header = document.getElementById("myHeader");
  var sticky = header.offsetTop;
  window.onscroll = function() {
    if (window.pageYOffset > sticky) header.classList.add("sticky");
    else header.classList.remove("sticky");
  };

  function CheckBoxAll(source) { 
    checkboxes = document.getElementsByClassName("ItemCheckboxes");  
    for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = source.checked;
  }

  var modal = document.getElementById('myModal');
  var btn = document.getElementById("myBtn");
  var span = document.getElementsByClassName("close")[0];

  btn.onclick = function() {
      modal.style.display = "block";
  }

  span.onclick = function() {
      modal.style.display = "none";
  }

  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }

  $('tr').dblclick(function(){
    document.location.href = '?id1='+$(this).attr('id')+'#popup1';
  })

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