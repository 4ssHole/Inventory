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

  <button id="refresh" class="NewButton">refresh</button>

  <h1>Create</h1>
  <button id="Create" class="NewButton">Create</button>
  <input id="info" name="info" type="text">
  <input id="Brand" name="Brand" type="text">
  
  <h1>Read</h1>
  <table id="customers"></table>
  
  <h1>Update</h1>
  <button id="Update" class="NewButton">Update</button>
  <input id="infoUpdate" name="infoUpdate" type="text">
  
  <h1>Delete</h1>
  <button id="Delete" class="NewButton">Delete</button>

</div>
<script> 
  $(document).ready(function(){
    reloadTable();
  });

  $("#refresh").click(function(){
    reloadTable();
  });

  $("#Create").click(function(){

    $("input").each(function(){
      console.log($(this).val());
    });

    var params = 
    {
      'info':$("#info").val(),
      'Brand':$("#Brand").val()
    };

    $.ajax({
      url:'addItem.php',
      data: params,
      type: 'post',
      success:function(){
        reloadTable(); 
      }
    });

  });


  function reloadTable(){
    $.ajax({
    url:"table.php",
    type: 'post',
    success:function(data)
    {
      $('#customers').html(data);
    }
    })
  }
</script>
</body>
</html>