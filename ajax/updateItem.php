<?php 
    include("../Connection.php");

    $result = $pdo->prepare("SELECT * FROM borrowed WHERE itemcode ='".$_POST['selectedItem']."' LIMIT 1");
    $result->execute();
    $itemExists = $result->fetch();

    if($itemExists['itemcode']==$_POST['selectedItem']){
        $pdo->query("UPDATE borrowed SET itemcode='".$_POST['newItemCode']."' WHERE itemcode ='".$_POST['selectedItem']."'");
    }

    $pdo->query("UPDATE items SET ".implode(', ', $_POST['updateItems'])." WHERE itemcode='".$_POST['selectedItem']."'");
?>