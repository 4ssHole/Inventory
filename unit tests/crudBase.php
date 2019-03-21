<?php   
  session_start();
  ob_start();
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

  <button id="refresh" class="NewButton">refresh</button>

  <div id="Create-container">
    <h1>Create</h1>
    <button id="Create" class="NewButton">Create</button>
  </div>

  <h1>Read</h1>
  <table id="customers"></table>
  
  <h1>Update</h1>
  <button id="Update" class="NewButton">Update</button>
  <input id="infoUpdate" name="infoUpdate" type="text">
  
  <h1>Delete</h1>
  <button id="Delete" class="NewButton">Delete</button>

</div>
<script>
  $(":checkbox:checked").each(function(){ console.log($(this).val()); });

  var ColumnNames = []; 
  var paramsJson = {};

  $("#Create").click(function(){
    for(var i = 0;i<ColumnNames.length;i++) paramsJson[ColumnNames[i]] = $("#"+ColumnNames[i]).val(); 
    
    $.ajax({
      url:'addItem.php',
      data: paramsJson,
      type: 'post',
      success:function(){reloadTable();}  
    });
  });

  $(document).ready(function(){
    reloadTable();
  });

  $("#refresh").click(function(){
    reloadTable();

    $.ajax({
      type: 'post',
      url: 'ColumnNames.php',
      dataType: 'json',
      cache: false,
      success: function(result) { 
        for (var i = 0; i < result.length; i++) ColumnNames.push(result[i]);     
        }
    })

    for (var i = 0; i < ColumnNames.length; i++) createInputs(ColumnNames[i],'#Create-container');
  });
  
  function reloadTable(){
    $.ajax({
      url:"table.php",
      type: 'post',
      success:function(data){$('#customers').html(data);}
    })
  }

  function createInputs(data,target) {
    $(target).append(
      '<label for="'+data+'">'+data+'<input id="'+data+'" name="'+data+'" type="text"><br>');
  }
</script>
</body>
</html>