<?php   
  session_start();
  ob_start();

  include("../Connection.php");
  include("../NavBar.php"); 
  date_default_timezone_set("Asia/Manila");
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>fook uff</title>
  <script src="../jQuery331.js"></script>
  <link rel="stylesheet" href="../styles.css">
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
      array_push($tableHeaderNamesArray, $property->name);
      if($property->name!="Date Updated"&&$property->name !="Date Added"){
        array_push($addArray, $property->name);
      }
  }

  DisplayNavBar();
?>
<p class="NavBarSpacer"></p>

<div class="categoryContainerForm">
  <label for="TableCategory">Category :</label>
    <select id="TableCategory" name="SelectTable" class="inputbox" onChange="this.form.submit()">
      <option value="All items">All Items</option>
    </select>
    <button id="addItem" class="NewButton">Add Item</button>
</div>

<div id="addDialog"> 
  <div class="grid-item">
    <label for="date">date</label>
  </div>
  <div class="grid-item">
    1
  </div>
  <div class="grid-item">
    132
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

<script src="../jquery.color-2.1.2.min.js"></script>
<script> 
  var header = document.getElementById("myHeader");
  var sticky = header.offsetTop;
  window.onscroll = function() {
    console.log("a");
    if (window.pageYOffset > sticky) header.classList.add("sticky");
    else header.classList.remove("sticky");
  };

    $(document).ready(function(){
      var dialog = $("#addDialog");  

      $("#addItem").click(function(){
        if($("#addDialog").is(":visible")){
          dialog.animate(
            {
              color: '#fff',
              backgroundColor: '#000000'
            }, 
            250, 
            function() { 
              dialog.hide(); 
            }
          );     
        }
        else{
          dialog.show();
          dialog.animate(
            {
              color: '#000',
              backgroundColor: '#ffffff'
            }, 250);
        }
      });
    });
</script>
</body>
</html>