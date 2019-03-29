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
<p class="NavBarSpacer">
<div class="tablecontrols">  
  <button id="addButton" class="NewButton">Add Item</button>
  <button id="Delete" class="NewButton">Delete Selected Items</button>
  <div style="float:right">
    <label for="searchbox">Search : </label>
    <input type="text" id="searchbox">
    <label for="columnSelect">Category : </label>
    <select name="columnSelect" id="columnSelect"></select>
  </div>
</div>

<div class="tableAndLower">
  <div class="TableContainer" style="margin:1em;">
    <table id="customers" class="newTable"></table>
  </div>
  <div id="test"></div>
</div>

<script src="../jquery.color-2.1.2.min.js"></script>
<script src="../jquery.easing.1.3.js"></script>
<script> 
  var ColumnNames = [];

  window.onscroll = function() {myFunction()};

  var header = document.getElementById("myHeader");
  var sticky = header.offsetTop;

  function myFunction() {
    if (window.pageYOffset > sticky) {
      header.classList.add("sticky");
    } else {
      header.classList.remove("sticky");
    }
  }

  $(document).on('click', "#addButton", function(){
    if($("#Generated-addBar").length !== 1){
      $('<tr id="Generated-addBar"><td colspan='+getColumns()+'><div id="addBar"></div></td></tr>').insertAfter($('#customers tr:first-child').closest('tr'));
      
      for (var i = 0; i < ColumnNames.length; i++) createInputs(ColumnNames[i],'#addBar');     
      $('#addBar').append('<button id="Create" class="NewButton">Add</button>');
    }
    else{
      $("#Generated-addBar").remove();
    }
    $('#itemcode').focus();
  })

  $(document).on('click', "#Create", function(){
    var addArray = [];
    
    for(var i = 0;i<ColumnNames.length;i++){
      var column = addslashes(ColumnNames[i]);
      var update = addslashes($("#"+ColumnNames[i]+".editBar").val());
      
      addArray.push(column+"= '"+update+"' ");  
    }
    $.ajax({
      url:'../ajax/handleRequest.php',
      data: {
        addArray:addArray,
        decision:"addItem"
        },
      type: 'post',
      success:function(data){
        reloadTable();
        $('#test').html(data);
      }  
    });
  });

  $(document).on('click', '#Update',function(){
      var updateArray = [];

      for(var i = 0;i<ColumnNames.length;i++) {
          if($("#"+ColumnNames[i]+".editBar").val() != ''){
              var column = addslashes(ColumnNames[i]);
              var update = addslashes($("#"+ColumnNames[i]+".editBar").val());
              
              updateArray.push(column+"= '"+update+"' ");
          }
      }

      $.ajax({
          url:'../ajax/updateItem.php',
          data: 
          {
              updateItems:updateArray,
              selectedItem:selectItem,
              newItemCode:$("#itemcode.editBar").val(),
          },
          type: 'post',
          success:function(data){
              reloadTable();
              $('#test').html(data);
          }  
      });
  });

  $(document).on('click', "#singleDelete", function(){
      deleteWithBorrowed([addslashes($(this).val())]);
  });

  $(document).on('click', '#Delete',function(){
    var deleteArray = [];
   
    $("#customers :checkbox:checked").each(function(){ 
      deleteArray.push(addslashes($(this).val())); 
    });
    
    deleteWithBorrowed(deleteArray);
  });

  $("#searchbox").keyup(function() {
    $.ajax({
      url:"../ajax/table.php",
      data: {
        selectedTable:"items",
        selectedColumn:$("#columnSelect").val(),
        query:'%'+$(this).val()+'%'        
      },
      type: 'post',
      success:function(data){
        $('#customers').html(data)
      }
    })
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
        for (var i = 0; i < result.length; i++) $("#columnSelect").append(new Option(result[i], result[i]));
      }
    });
  });

  function addslashes(str) {
    if(str){
      if(str.trim())
      {
        str = str.replace(/\\/g, '\\\\');
        str = str.replace(/\'/g, '\\\'');
        str = str.replace(/\"/g, '\\"');
        str = str.replace(/\0/g, '\\0');
      }
    }
    return str;
  }
  
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
    $(target).append('<label for="'+data+'">'+data+'<input class="inputinbar-addItem" id="'+data+'" name="'+data+'" type="text">');
  }

</script>
</body>
</html>