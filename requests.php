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


  <div class="TableContainer" style="margin:1em;">
    <table id="customers" class="newTable"></table>
  </div>
  <div id="test"></div>


<script>
  $(document).ready(function(){
    reloadTable();
  });

  function reloadTable(){
    $.ajax({
      url:"../ajax/requestsTable.php",
      data: {
        selectedTable:"borrowed",
      },
      type: 'post',
      success:function(data){
        $('#customers').html(data);
      }
    });
  }

  $(document).on('click', '#Modify',function(){
    var ReturnValue = $(this).val();

    $.ajax({
        url:'../ajax/returnItem.php',
        data: {
          borrowId:ReturnValue,
          },
        type: 'post',
        success:function(data){
            $('#test').html(data);
        }  
    });
    $(this).closest('tr').remove();
  });
  
  $(document).on('click', '#Recieved',function(){
    $.ajax({
        url:'../ajax/handleRequest.php',
        data: {
          borrowid:$(this).val(),
          decision:"recieved"
          },
        type: 'post',
        success:function(data){
          reloadTable();
          $('#test').html(data);
        }  
    });
    $(this).closest('tr').remove();
  });

  $(document).on('click', '#Cancel-request',function(){
    $.ajax({
        url:'../ajax/handleRequest.php',
        data: {
            borrowid:$(this).val(),
            decision:"cancel-request",
          },
        type: 'post',
        success:function(data){
          reloadTable();
          $('#test').html(data);
        }  
    });
    $(this).closest('tr').remove();
  });

  $(document).on('click', '#Close-bar',function(){
    $(this).closest('tr').remove();
  });

  $(document).on('click', '#Return',function(){
      var ReturnValue = $(this).val();

      $.ajax({
          url:'../ajax/handleRequest.php',
          data: {
            borrowId:ReturnValue,
            decision:"return"
            },
          type: 'post',
          success:function(data){
            reloadTable();
            $('#test').html(data);
          }  
      });
      $(this).closest('tr').remove();
  });

  window.onscroll = function() {
    var header = document.getElementById("myHeader");
    var sticky = header.offsetTop;
    if (window.pageYOffset > sticky) header.classList.add("sticky");
    else header.classList.remove("sticky");
  };
</script>
</body>
</html>