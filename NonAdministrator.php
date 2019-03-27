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
        for (var i = 0; i < result.length; i++) ColumnNames.push(result[i])
      }
    })
  })

  $(document).on('click', '#RequestItem',function(){
      var requestedValue = $(this).val();

      $.ajax({
          url:'../ajax/handleRequest.php',
          data: {
            requestedItem:requestedValue,
            decision:"sendrequest",
            quantityProvided:$(this).parent().find('#Quantity-request'+requestedValue).val()
            },
          type: 'post',
          success:function(data){
              $('#test').html(data);
              if(data =="pending-request"){
                console.log("prompt modify")
              }
              else if(data =="sent-request"){
                reloadTable()
                console.log("tooltip click here to modify your request")
              }
              else if(data =="promt-change-quantity"){
                console.log("request invalid")
              }
          }  
      })
      $(this).closest('tr').remove();
  })



  function reloadTable(){
    tableName = "items";

    $.ajax({
      url:"../ajax/UsermodeTable.php",
      data: {selectedTable:tableName},
      type: 'post',
      success:function(data){
        $('#customers').html(data)
      }
    })
  }

</script>
</body>
</html>