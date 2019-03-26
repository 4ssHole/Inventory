<?php   
  session_start();
  ob_start();
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>s</title>
  <script src="../jQuery331.js"></script>

  <link rel="stylesheet" href="stylesTesting.css">
</head>

<body>
  <div class="TableContainer" style="margin:1em;">

    <button id="refresh" class="NewButton">refresh</button>

    <div id="test"></div>
    <div id="Create-container">
      <h1>Create</h1>
      <button id="Create" class="NewButton">Create</button>
    </div>

    <h1>Read</h1>
    <table id="customers">
    </table>
    
    <h1>Delete</h1>
    <button id="Delete" class="NewButton">Delete</button>

  </div>
</body>
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

  </script>

</html>

<!-- todo update function get item/s to update otherwise complete-->
<!-- todo dynamic colspan table.php-->