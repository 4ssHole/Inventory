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
<div id="test"></div>


<div class="tableAndLower">
  <div class="TableContainer" style="margin:1em;">
    <table id="requests-table" class="newTable"></table>
  </div>
</div>

<script>
    $(document).ready(function(){
    reloadTable();
  });

  function reloadTable(){
    var tableName = "borrowed";

    $.ajax({
      url:"../ajax/table.php",
      data: {selectedTable:tableName},
      type: 'post',
      success:function(data){
        $('#requests-table').html(data);
      }
    });
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