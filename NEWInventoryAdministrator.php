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
  <a name="ShowDeleteConfirm" class="NewButton">Delete Selected Items</a>
  <a name="NewCategory" class="NewButton">Modify Categories</a>

</div>

<div class="tableAndLower">
<div class="TableContainer" style="margin:1em;">
  
  <table id="customers"></table>


<script> 
  var ColumnNames = []; 

  function reloadTable(){
    $.ajax({
      url:"../ajax/table.php",
      success:function(data){$('#customers').html(data);}
    })
  }

  function createInputs(data,target) {
    $(target).append('<br><label for="'+data+'">'+data+'<input id="'+data+'" name="'+data+'" type="text">');
  }

  function addTextboxes() {
    $.ajax({
      type: 'post',
      url: '../ajax/ColumnNames.php',
      dataType: 'json',
      cache: false,
      success: function(result) { 
        for (var i = 0; i < result.length; i++) ColumnNames.push(result[i]);
        for (var i = 0; i < ColumnNames.length; i++) createInputs(ColumnNames[i],'#Create-container');     
        }
    })
  }

  $("#Create").click(function(){
    var addJson = {};
    
    for(var i = 0;i<ColumnNames.length;i++) addJson[ColumnNames[i]] = $("#"+ColumnNames[i]).val(); 
    $.ajax({
      url:'../ajax/addItem.php',
      data: addJson,
      type: 'post',
      success:function(data){reloadTable();$('#test').html(data);}  
    });
  });

  $("#Delete").click(function(){
    var deleteArray = [];
    
    $("#customers :checkbox:checked").each(function(){ 
      deleteArray.push('"'+$(this).val()+'"'); 
    });

    $.ajax({
      url:'../ajax/removeItem.php',
      data: {deleteItems:deleteArray},
      type: 'post',
      success:function(data){
        reloadTable();
        $('#test').html(data);
      }  
    });
  });

  $("#refresh").click(function(){
    reloadTable();    
  });

  $(document).ready(function(){
    reloadTable();
    addTextboxes();
  });




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


</script>
</body>
</html>