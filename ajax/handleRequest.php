<?php
    session_start();
    ob_start();
    include("../Connection.php");

    if($_POST['decision'] == "approve"){
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