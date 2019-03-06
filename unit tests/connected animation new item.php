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
  <title>fook uff</title>
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
<div>  
  <form class="categoryContainerForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="TableCategory">Category :</label>
      <select id="TableCategory" name="SelectTable" class="inputbox" onChange="this.form.submit()">
        <option value="All items">All Items</option>
      </select>
    </form>

    <button id="addItem" class="NewButton">Add Item</button>
    <div id="addDialog"> 
        <label for="date">date</label>
        <input type="date" id="date">

        <label for="name">name</label>
        <input type="text" id="name">

        <label for="email">email</label>
        <input type="email" id="email">

        <label for="address">address</label>
        <input type="text" id="address">
    </div>
</div>

<div class="TableContainer" style="margin:1em;">
  
    <table id="customers">
        <tr><th><input onClick="CheckBoxAll(this)" type="checkbox"></th>
        <?php  
            if($_SESSION["FilterValue"] != 'All items')  
            $tableitems = mysqli_query($connection, "SELECT * FROM `! list of all items` WHERE Category ='".$_SESSION["FilterValue"]."';");
            
            foreach($tableHeaderNamesArray as $tableheader)  echo '<th>'.$tableheader.'</th>'; //header

            while ($row = mysqli_fetch_array($tableitems)) { //row
                echo '<tr id="'.$row[0].'"><td><input type="checkbox" name="checklist[]" value="'.$row[0].'" class="ItemCheckboxes"></td>';
                foreach ($tableHeaderNamesArray as $item) echo '<td><label class="button">'.$row[$item].'</label>';//data
                echo '</tr>';
            }
        ?>
    </table>
</div>

<script> 
    $(document).ready(function(){
        var dialog = $("#addDialog");  
        //dialog.hide();
        $("#addItem").click(function(){
            dialog.show();
            dialog.animate({fontSize: '3em'}, "slow");
        });
    });
</script>
</body>
</html>