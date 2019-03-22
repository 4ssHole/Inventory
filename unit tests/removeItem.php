<?php
    session_start();
    ob_start();

    include("../Connection.php");

    $data = $tableMeta = array();
    
    $stmt = $pdo->query("DELETE FROM items WHERE itemcode IN ( )");

    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $col = $stmt->getColumnMeta($i);    
        array_push($tableMeta, $col['name']);
        array_push($data, $_POST[$col['name']]);
    }
    
    $columns = implode(', ', $tableMeta);
    $values = ':'.implode(', :', $tableMeta);

    $STH = $pdo->prepare("INSERT INTO items ({$columns}) VALUES ({$values})");
    $STH->execute(array_values($data));
?>
