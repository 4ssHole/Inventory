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

  <button id="borrow" class="NewButton">Queue for approval</button>

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

  $(document).on('click', '#Return',function(){
      $.ajax({
          url:'../ajax/handleRequest.php',
          data: {
            borrowid:$(this).val()
            },
          type: 'post',
          success:function(data){
              $('#test').html(data);
          }  
      });
      $(this).closest('tr').remove();
  });

  function reloadTable(){
    tableName = "return";

    $.ajax({
      url:"../ajax/table.php",
      data: {
        selectedTable:tableName
        
      },
      type: 'post',
      success:function(data){
        $('#customers').html(data);
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