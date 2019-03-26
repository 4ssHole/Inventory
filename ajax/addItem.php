<?php
    include("../Connection.php");

    $data = $tableMeta = array();
    
    $stmt = $pdo->query("SELECT * FROM items LIMIT 0");

    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $col = $stmt->getColumnMeta($i);    
        array_push($tableMeta, $col['name']);
        array_push($data, $_POST[$col['name']]);
    }
    
    $STH = $pdo->prepare("INSERT INTO items (".implode(', ', $tableMeta).") VALUES (:".implode(', :', $tableMeta).")");
    $STH->execute(array_values($data));
?>
