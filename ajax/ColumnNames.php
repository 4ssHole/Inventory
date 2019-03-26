<?php
    include("../Connection.php");
    session_start();
    ob_start();
    
    $stmt = $pdo->query("SELECT * FROM items LIMIT 0");
    $headers = array();

    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $col = $stmt->getColumnMeta($i);    
        array_push($headers, $col['name']);
    } 

    echo json_encode($headers);
?>