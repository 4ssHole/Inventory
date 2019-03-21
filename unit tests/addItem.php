<?php
    session_start();
    ob_start();

    include("../Connection.php");

    $data = $tableMeta = array();
    
    $stmt = $pdo->query("SELECT * FROM items LIMIT 0");

    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $col = $stmt->getColumnMeta($i);    
        array_push($tableMeta, $col['name']);
        array_push($data, $_POST[$col['name']]);
    }
    
    $columns = implode(', ', $tableMeta);
    $values = ':'.implode(', :', $tableMeta);

    $data = array($_POST['itemcode'], $_POST['Brand'], $_POST['Model'], $_POST['Price'], $_POST['Quantity']);
    
    $STH = $pdo->prepare("INSERT INTO items ({$columns}) VALUES ({$values})");
    $STH->execute(array_values($data));
?>
