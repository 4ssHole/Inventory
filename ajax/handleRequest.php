<?php
    session_start();
    ob_start();
    include("../Connection.php");

    if($_POST['decision'] == "sendrequest"){
        $result = $pdo->prepare("SELECT * FROM borrowed WHERE itemcode ='".$_POST['requestedItem']."' AND UserNumber='".$_SESSION['UserNumber']."'");
        $itemExists = $result->fetch();

        if($itemExists){
            if($itemExists['ReturnDate'] == null){
                if($itemExists['request'] == "approved"){
                    $pdo->query("UPDATE borrowed SET request='pending' WHERE borrowid='".$itemExists['borrowid']."'"); //revokepending
                }
                echo 'promptModifyRequest pending';
            }
        }
    }

    else{        
        $STH = $pdo->prepare("INSERT INTO borrowed (itemcode,UserNumber,Quantity) VALUES ('".$_POST['requestedItem']."', '".$_SESSION['UserNumber']."', '".$_POST['quantityProvided']."')");
        $STH->execute();
        echo "sent request";
    }

    if($_POST['decision'] == "approve"){
        $stmt = $pdo->query("SELECT * FROM borrowed WHERE borrowid='".$_POST['borrowid']."'");
        $row = $stmt->fetch();

        $pdo->query("UPDATE items SET Quantity=Quantity-'".$row['Quantity']."' WHERE itemcode ='".$row['itemcode']."'");
        $pdo->query("UPDATE borrowed SET request='approved' WHERE borrowid='".$_POST['borrowid']."'");
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
            $pdo->query("UPDATE borrowed SET request='item does not exist' WHERE itemcode='".$item."'");
        }
    }

    if($_POST['decision'] == "addItem"){
        foreach($_POST['addItems'] as $item){
            $pdo->query("UPDATE borrowed SET request='pending' WHERE itemcode='".$item."'");
        }
    }
?>