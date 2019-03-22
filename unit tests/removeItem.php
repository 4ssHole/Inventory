<?php
    session_start();
    ob_start();

    include("../Connection.php");

    $data = implode(', ', array(1,2,3,4));
    
    $stmt = $pdo->query("DELETE FROM items WHERE itemcode IN (".$data.")");
?>
