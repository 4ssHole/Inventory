<?php
    session_start();
    ob_start();
    include("../Connection.php");

    if($_POST['decision'] == "get-request"){
        $result = $pdo->prepare("SELECT * FROM borrowed WHERE borrowid ='".$_POST['requestedItem']."'");
        $result->execute();
        $itemExists = $result->fetch();

        echo $itemExists['request'];
    }

    if($_POST['decision'] == "sendrequest"){
        $result = $pdo->prepare("SELECT * FROM borrowed WHERE itemcode ='".$_POST['requestedItem']."' AND UserNumber='".$_SESSION['UserNumber']."'");
        $result->execute();
        $itemExists = $result->fetch();

        $getQuantity = $pdo->prepare("SELECT Quantity FROM items WHERE itemcode ='".$_POST['requestedItem']."'");
        $getQuantity->execute();
        $ItemQuantity = $getQuantity->fetch();

        if($itemExists && $itemExists['ReturnDate'] == null){
            if($itemExists['request'] == "approved"){
                $pdo->query("UPDATE borrowed SET request='pending' WHERE borrowid='".$itemExists['borrowid']."'"); //revokepending
            }
            echo 'pending-request';
        }    
        else if($_POST['quantityProvided'] <= $ItemQuantity['Quantity']){      
            $STH = $pdo->prepare("INSERT INTO borrowed (itemcode,UserNumber,Quantity) VALUES ('".$_POST['requestedItem']."', '".$_SESSION['UserNumber']."', '".$_POST['quantityProvided']."')");
            $STH->execute();
            echo "sent-request";
        }
        else if($_POST['quantityProvided'] > $ItemQuantity['Quantity']){
            echo "promt-change-quantity";
        } 
    }
    
    if($_POST['decision'] == "recieved"){
        $pdo->query("UPDATE borrowed SET request='recieved' WHERE borrowid='".$_POST['borrowid']."'");
    }
    
    if($_POST['decision'] == "approve"){
        $stmt = $pdo->query("SELECT * FROM borrowed WHERE borrowid='".$_POST['borrowid']."'");
        $row = $stmt->fetch();

        $pdo->query("UPDATE items SET Quantity=Quantity-'".$row['Quantity']."' WHERE itemcode ='".$row['itemcode']."'");
        $pdo->query("UPDATE borrowed SET request='approved', remarks= '".$_POST['remarks']."' WHERE borrowid='".$_POST['borrowid']."'");
    }
    if($_POST['decision'] == "deny"){
        $pdo->query("UPDATE borrowed SET request='denied', remarks= '".$_POST['remarks']."' WHERE borrowid='".$_POST['borrowid']."'");
    }
    if($_POST['decision'] == "remove"){
        $pdo->query("DELETE FROM borrowed WHERE borrowid='".$_POST['borrowid']."'");
    }
    if($_POST['decision'] == "return"){
        $pdo->query("UPDATE borrowed SET ReturnDate = CURRENT_TIMESTAMP WHERE borrowid='".$_POST['borrowid']."'");
    }
    if($_POST['decision'] == "deleteitem"){
        foreach($_POST['deleteItems'] as $item){
            echo "UPDATE borrowed SET request='item no longer available' WHERE itemcode='".$item."'";
            $pdo->query("UPDATE borrowed SET request='item no longer available' WHERE itemcode='".$item."'");
        }
    }
    if($_POST['decision'] == "addItem"){
        foreach($_POST['addItems'] as $item){
            $pdo->query("UPDATE borrowed SET request='pending' WHERE itemcode='".$item."'");
        }
    }
?>