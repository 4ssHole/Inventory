<?php
    session_start();
    ob_start();
    include("../Connection.php");

    if($_POST['return']=="return"){
        echo "item returned";

        $pdo->query("UPDATE borrowed SET request='returned' WHERE borrowid='".$_POST['borrowId']."'");
    }
?>