<?php 
    include("../Connection.php");
    $pdo->query("UPDATE items SET ".implode(', ', $_POST['updateItems'])." WHERE itemcode='".$_POST['selectedItem']."'");
?>