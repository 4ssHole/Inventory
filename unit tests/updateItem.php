<?php 
    include("../Connection.php");
    $STH = $pdo->query("UPDATE items SET ".implode(', ', $_POST['updateItems'])." WHERE itemcode='".$_POST['selectedItem']."'");
?>