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
  <input type="text">

  <h1>Read</h1>
  <table id="customers"></table>
  
  <h1>Delete</h1>
  <button id="Delete" class="NewButton">Delete</button>

  <h1>Update</h1>

</div>
<script> 
$(document).ready(function(){
  $("#customers").load("ajax.php");

  $("#refresh").click(function(){
    $("#customers").load("ajax.php");
  });
});
</script>
</body>
</html>