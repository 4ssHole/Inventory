<?php include("Connection.php"); ?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Inventory System</title>
  <script src="jQuery331.js"></script>
  <link rel="stylesheet" href="astyles.css">
</head>

<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="tableAndLower">
    <div class="TableContainer" style="margin:1em;">

      <table id="customers">
      <tr>
        <th>
          <input onClick="CheckBoxAll(this)" type="checkbox">
        </th>

        <?php 
          $tableitems = mysqli_query($connection, "SELECT * FROM `! list of all items`");

          $tableHeaderNamesArray = array();

          while ($property = mysqli_fetch_field($tableitems)) { //column header
            if($property->name == "Item Number"){}
            else{echo '<th>'. $property->name . '</th>';}
            array_push($tableHeaderNamesArray, $property->name);
          }

          while ($row = mysqli_fetch_array($tableitems)) { //row
            echo '<tr id="'.$row[0].'">';
            foreach ($tableHeaderNamesArray as $item){ //data 
              if($row[$item]==$row[0])
                echo '<td><input type="checkbox" id="checkbox" name="checklist[]" value="'.$row[0].'" class="ItemCheckboxes"></td>';
              else {
                echo '<td><label class="button" title="'.$row[$item].'">'.$row[$item].'</label></td>';
              }
            }
            echo '</tr>';
          }
        ?>
      </table>

    </div>
  <input id="testbutton" type="button" value="get selected" title="piss">
  </div>
</form>
</body>

<script>

  function CheckBoxAll(source) { 
    checkboxes = document.getElementsByClassName("ItemCheckboxes");  
    for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = source.checked;
  }

  $('#testbutton').click(function(){
    var allVals = [];
      $('#customers').find('td :checked').each(function() {
        allVals.push($(this).val());
      });

    window.alert(allVals);
  })

  $('tr').dblclick(function(){
    var id = $(this).attr('id');
    window.alert(id);
    document.location.href = '#id1='+id;
  })


  $('#customers').find('tr').click(function(){
    var x = ($(this).index()-1);
    checkboxes = document.getElementsByClassName("ItemCheckboxes"); 
    $(checkboxes[x]).click();
  });

</script>