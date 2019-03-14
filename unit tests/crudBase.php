<?php   
  session_start();
  ob_start();

  include("../Connection.php");
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>fook uff</title>
  <script src="../jQuery331.js"></script>
  <link rel="stylesheet" href="stylesTesting.css">
</head>

<body>
<div class="TableContainer" style="margin:1em;">
  
    <table id="customers">

        <?php  
          $tableHeaderNamesArray = array();

          $tableitems = mysqli_query($connection, "SELECT * FROM items");

          while ($property = mysqli_fetch_field($tableitems)) {
            array_push($tableHeaderNamesArray, $property->name);
          }  
          
          foreach($tableHeaderNamesArray as $tableheader)  
          echo '<th>'.$tableheader.'</th>'; //header

          while ($row = mysqli_fetch_array($tableitems)) { //row
              echo '<tr id="'.$row[0].'">';
              
              foreach ($tableHeaderNamesArray as $item) 
              echo '<td>'.$row[$item].'</td>';  //data

              echo '</tr>';
          }
        ?>
    </table>
</div>
<script> 

</script>
</body>
</html>