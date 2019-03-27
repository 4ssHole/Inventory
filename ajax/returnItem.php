<?php
    session_start();
    ob_start();
    include("../Connection.php");

    $stmt = $pdo->query("SELECT request FROM borrowed WHERE borrowid='".$_POST['borrowId']."'");
    $requestStatus = $stmt->fetch();

    if($requestStatus['request']=="approved"){
        if($requestStatus['request']!="returned"){
            $stmt = $pdo->query("SELECT * FROM borrowed WHERE borrowid='".$_POST['borrowId']."'");
            $CurrentQuantity = $stmt->fetch();

            $pdo->query("UPDATE items SET Quantity=Quantity+'".$CurrentQuantity['Quantity']."' WHERE itemcode ='".$CurrentQuantity['itemcode']."'");
            $pdo->query("UPDATE borrowed SET request='returned' WHERE borrowid='".$_POST['borrowId']."'");
        }
        else{
            echo 'item already returned';
        }
    }
?>