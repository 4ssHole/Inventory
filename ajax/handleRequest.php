<?php
    session_start();
    ob_start();
    include("../Connection.php");

    $fullname = $_SESSION['FirstName']." ".$_SESSION['LastName'];
    $itemname = "";
    
    if(isset($_POST['requestedItem'])){
        $result = $pdo->query("SELECT Brand,Name,Model FROM items WHERE itemcode ='".$_POST['requestedItem']."'");
        $itemExists = $result->fetch();
        $itemname = addslashes($itemExists['Brand']." ".$itemExists['Name']." ".$itemExists['Model']);
    }

    if($_POST['decision'] == "get-request"){
        $result = $pdo->query("SELECT * FROM borrowed WHERE borrowid ='".$_POST['requestedItem']."'");
        $itemExists = $result->fetch();

        echo $itemExists['request'];
    }
    if($_POST['decision'] == "sendrequest"){
        $sql = "SELECT * FROM borrowed WHERE itemcode ='".$_POST['requestedItem']."' AND Name='".$fullname."'";
        $result = $pdo->query($sql);
        $itemExists = $result->fetch();

        $getQuantity = $pdo->query("SELECT Quantity FROM items WHERE itemcode ='".$_POST['requestedItem']."'");
        $ItemQuantity = $getQuantity->fetch();

        if($itemExists && $itemExists['ReturnDate'] == null){
            if($itemExists['request'] == "approved"){
                $pdo->query("UPDATE borrowed SET request='pending' WHERE borrowid='".$itemExists['borrowid']."'"); //revokepending
            }
            echo 'pending-request';
        }    
        else if($_POST['quantityProvided'] <= $ItemQuantity['Quantity']){      
            $STH = $pdo->query("INSERT INTO borrowed (itemcode,item,Name,Quantity) VALUES ('".$_POST['requestedItem']."','".$itemname."', '".$fullname."', '".$_POST['quantityProvided']."')");
            echo "sent-request";
        }
        else if($_POST['quantityProvided'] > $ItemQuantity['Quantity']){
            echo "promt-change-quantity";
        } 
    }    
    if($_POST['decision'] == "recieved"){
        $pdo->query("UPDATE borrowed SET request='recieved', RecieveDate=CURRENT_TIMESTAMP WHERE borrowid='".$_POST['borrowid']."'");
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
        $stmt = $pdo->query("SELECT request FROM borrowed WHERE borrowid='".$_POST['borrowId']."'");
        $requestStatus = $stmt->fetch();
    
        if($requestStatus['request']=="recieved"){
            if($requestStatus['request']!="returned"){
                $stmt = $pdo->query("SELECT * FROM borrowed WHERE borrowid='".$_POST['borrowId']."'");
                $CurrentQuantity = $stmt->fetch();
    
                $pdo->query("UPDATE items SET Quantity=Quantity+'".$CurrentQuantity['Quantity']."' WHERE itemcode ='".$CurrentQuantity['itemcode']."'");
                $pdo->query("UPDATE borrowed SET request='returned', ReturnDate=CURRENT_TIMESTAMP WHERE borrowid='".$_POST['borrowId']."'");
            }
            else{
                echo 'item already returned';
            }
        }
        else{
            echo 'item is pending approval';
        }
    }
    if($_POST['decision'] == "deleteitem"){
        foreach($_POST['deleteItems'] as $item){
            $pdo->query("UPDATE borrowed SET request='item no longer available' WHERE item='".$item."'");
        }
        
        $delete = '\''.implode('\', \'', $_POST['deleteItems']).'\'';
        $pdo->query('DELETE FROM items WHERE itemcode IN ('.$delete.')');
    }


    if($_POST['decision'] == "addItem"){
        $data = $tableMeta = array();
    
        $stmt = $pdo->query("SELECT * FROM items LIMIT 0");
    
        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $col = $stmt->getColumnMeta($i);    
            array_push($tableMeta, addslashes($col['name']));
            array_push($data, addslashes($_POST[$col['name']]));
        }
        
        $STH = $pdo->prepare("INSERT INTO items (".implode(', ', $tableMeta).") VALUES (:".implode(', :', $tableMeta).")");
        $STH->execute(array_values($data));
    }
?>