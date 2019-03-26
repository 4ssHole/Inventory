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

<?php DisplayNavBar();?>
<div id="test"></div>
<p class="NavBarSpacer">
<div class="tablecontrols">  

  <a id="Create" class="NewButton">Add Item</a>
  <a id="Delete" class="NewButton">Delete Selected Items</a>
  <a name="NewCategory" class="NewButton">Modify Categories</a>

</div>

<div class="tableAndLower">
  <div class="TableContainer" style="margin:1em;">
    <table id="customers" class="newTable"></table>
  </div>
</div>

<script> 
  var ColumnNames = []; 

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

  function reloadTable(){
    var tableName = "items";

    $.ajax({
      url:"../ajax/table.php",
      data: {selectedTable:tableName},
      type: 'post',
      success:function(data){
        $('#customers').html(data);
      }
    });
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


  window.onscroll = function() {
    var header = document.getElementById("myHeader");
    var sticky = header.offsetTop;
    if (window.pageYOffset > sticky) header.classList.add("sticky");
    else header.classList.remove("sticky");
  };

</script>
</body>
</html>