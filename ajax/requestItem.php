<?php
    session_start();
    ob_start();
    include("../Connection.php");



    $result = $pdo->query("SELECT * FROM borrowed WHERE itemcode ='".$_POST['requestedItem']."' AND UserNumber='".$_SESSION['UserNumber']."'");
   // $result->execute();

    $itemExists = $result->fetch();

    if($itemExists){
        if($itemExists['ReturnDate'] == null){
            if($itemExists['request'] == "approved"){
                $pdo->query("UPDATE borrowed SET request='pending' WHERE borrowid='".$itemExists['borrowid']."'"); //revokepending
            }
            echo 'promptModifyRequest pending';
        }
    }

    else{        
        $STH = $pdo->prepare("INSERT INTO borrowed (itemcode,UserNumber,Quantity) VALUES ('".$_POST['requestedItem']."', '".$_SESSION['UserNumber']."', '".$_POST['quantityProvided']."')");
        $STH->execute();
        echo "sent request";
    }
?>

<!--
    TODO: 

    prompt to modify a request
    
    (((
        if request exists and is pending or allowed do not add a new request
        allowed: -> prompt to make changes to request, quantity and revoke allowed make pending
        pending: -> prompt to make changes to request, quantity

        if requested item has been returned allow
    )))
-->