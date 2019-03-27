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
    <table id="customers" class="newTable"></table>
  </div>
</div>

<script>
    $(document).ready(function(){
    reloadTable();
  });

  function reloadTable(){
    tableName = "borrowed";

    $.ajax({
      url:"../ajax/table.php",
      data: {selectedTable:tableName},
      type: 'post',
      success:function(data){
        $('#customers').html(data);
      }
    });
  }

  $(document).on('click', "#Approve", function(){
    $.ajax({
      url:"../ajax/handleRequest.php",
      data: {
        decision:"approve",
        borrowid: $(this).val()
      },
      type: 'post',
      success:function(data){
        reloadTable();
      }
    })
  });
  $(document).on('click', "#Deny", function(){
    $.ajax({
      url:"../ajax/handleRequest.php",
      data: {
        decision:"deny",
        borrowid:$(this).val(),
        remarks:$(remarks+selectItem).val()
        },
      type: 'post',
      success:function(data){
        reloadTable();
        console.log($(remarks+selectItem).val());
      }
    })
  });
  $(document).on('click', "#Remove", function(){
    $.ajax({
      url:"../ajax/handleRequest.php",
      data: {
        decision:"remove",
        borrowid:$(this).val(),
        },
      type: 'post',
      success:function(data){
        reloadTable();
      }
    })
  });

</script>
</body>
</html>