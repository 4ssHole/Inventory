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
<button id="refresh" class="NewButton">refresh</button>
<div class="TableContainer" style="margin:1em;">
  
    <table id="customers">
    </table>
    
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