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

  <button id="addButton" class="NewButton">Add Item</button>
  <button id="Delete" class="NewButton">Delete Selected Items</button>
  <button name="NewCategory" class="NewButton">Modify Categories</button>

</div>

<div class="tableAndLower">
  <div class="TableContainer" style="margin:1em;">
    <table id="customers" class="newTable"></table>
  </div>
</div>

<script src="../jquery.color-2.1.2.min.js"></script>
<script src="../jquery.easing.1.3.js"></script>
<script> 
  var ColumnNames = [];

  $(document).on('click', "#addButton", function(){
    if($("#Generated-addBar").length !== 1){
      $('<tr id="Generated-addBar"><td colspan=7><div id="addBar"></div></td></tr>').insertAfter($('#customers tr:first-child').closest('tr'));
      
      for (var i = 0; i < ColumnNames.length; i++) createInputs(ColumnNames[i],'#addBar');     
      $('#addBar').append('<button id="Create" class="NewButton">Add</button>');
    }
    else{
      $("#Generated-addBar").remove();
    }
  })

  $(document).on('click', "#Create", function(){
    var addJson = {};
    
    for(var i = 0;i<ColumnNames.length;i++) addJson[ColumnNames[i]] = $("#"+ColumnNames[i]).val(); 
    $.ajax({
      url:'../ajax/addItem.php',
      data: addJson,
      type: 'post',
      success:function(data){reloadTable();$('#test').html(data);}  
    });
  });

  $(document).on('click', '#Update',function(){
      var updateArray = [];

      for(var i = 0;i<ColumnNames.length;i++) {
          if($("#"+ColumnNames[i]+".editBar").val() != ''){
              updateArray.push(ColumnNames[i]+"= '"+$("#"+ColumnNames[i]+".editBar").val()+"' ");
          }
      }

      $.ajax({
          url:'../ajax/updateItem.php',
          data: 
          {
              updateItems:updateArray,
              selectedItem:selectItem,
          },
          type: 'post',
          success:function(data){
              reloadTable();
              $('#test').html(data);
          }  
      });
  });

  $(document).on('click', "#singleDelete", function(){
      deleteWithBorrowed([$(this).val()]);
  });

  $(document).on('click', '#Delete',function(){
    var deleteArray = [];
    $("#customers :checkbox:checked").each(function(){ deleteArray.push($(this).val()); });
    deleteWithBorrowed(deleteArray);
  });


  $(document).ready(function(){
    reloadTable();  
    $.ajax({
      type: 'post',
      url: '../ajax/ColumnNames.php',
      dataType: 'json',
      cache: false,
      success: function(result) { 
        for (var i = 0; i < result.length; i++) ColumnNames.push(result[i]);
      }
    });
  });
  
  function deleteWithBorrowed(deleteArray){
    $.ajax({
      url:"../ajax/handleRequest.php",
      data: {
        decision:"deleteitem",
        deleteItems:deleteArray,
        },
      type: 'post',    
      success:function(data){
        reloadTable();
        $('#test').html(data);
      }  
    })

    $.ajax({
      url:'../ajax/removeItem.php',
      data: {deleteItems:deleteArray},
      type: 'post'
    });
  }

  function reloadTable(){
    tableName = "items";

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

  // window.onscroll = function() {
  //   var header = document.getElementById("myHeader");
  //   var sticky = header.offsetTop;
  //   if (window.pageYOffset > sticky) header.classList.add("sticky");
  //   else header.classList.remove("sticky");
  // };

</script>
</body>
</html>