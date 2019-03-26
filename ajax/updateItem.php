<?php 
    include("../Connection.php");

    echo "UPDATE items SET ".implode(', ', $_POST['updateItems'])." WHERE itemcode='".$_POST['selectedItem']."'";
    $pdo->query("UPDATE items SET ".implode(', ', $_POST['updateItems'])." WHERE itemcode='".$_POST['selectedItem']."'");
?>