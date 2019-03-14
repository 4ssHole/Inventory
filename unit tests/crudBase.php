<?php   
  session_start();
  ob_start();

  include("Connection.php");
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

<?php 
  $categoryNameArray = $tableHeaderNamesArray = $addArray = array();

  $categories = mysqli_query($connection, "SELECT * FROM `categories`");

  while ($row = mysqli_fetch_array($categories)) { 
    array_push($categoryNameArray,$row[1]);
  }

  $tableitems = mysqli_query($connection, "SELECT * FROM items");
  
  while ($property = mysqli_fetch_field($tableitems)) {
    array_push($tableHeaderNamesArray, $property->name);
    if($property->name!="Date Updated" && $property->name !="Date Added"){
      array_push($addArray, $property->name);
    }
  }
?>


<div class="TableContainer" style="margin:1em;">
  
    <table id="customers">

        <?php  
            if($_SESSION["FilterValue"] != 'All items')  
            $tableitems = mysqli_query($connection, "SELECT * FROM `! list of all items` WHERE Category ='".$_SESSION["FilterValue"]."';");
            
            foreach($tableHeaderNamesArray as $tableheader)  echo '<th>'.$tableheader.'</th>'; //header

            while ($row = mysqli_fetch_array($tableitems)) { //row
                echo '<tr id="'.$row[0].'">';
                foreach ($tableHeaderNamesArray as $item) echo '<td><label class="button">'.$row[$item].'</label>';//data
                echo '</tr>';
            }
        ?>
    </table>
</div>
<script> 

</script>
</body>
</html>