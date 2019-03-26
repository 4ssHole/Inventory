<?php
    session_start();
    ob_start();
    include("../Connection.php");
    echo 'session : '.$_SESSION['UserNumber'];

    echo "INSERT INTO borrowed (itemcode,UserNumber) VALUES ('".$_POST['requestedItem']."', '".$_SESSION['UserNumber']."')";
    
    $STH = $pdo->prepare("INSERT INTO borrowed (itemcode,UserNumber) VALUES ('".$_POST['requestedItem']."', '".$_SESSION['UserNumber']."')");
    $STH->execute();
?>