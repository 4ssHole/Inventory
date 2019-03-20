<?php
    session_start();
    ob_start();

    include("../Connection.php");
    
    $tableMeta = array('itemcode', 'Brand', 'Model');
    
    $columns = implode(', ', $tableMeta);
    $values = ':'.implode(', :', $tableMeta);
    
    $data = array($_POST['info'], $_POST['info'], $_POST['info']);
    
    $STH = $pdo->prepare("INSERT INTO items ({$columns}) VALUES ({$values})");
    $STH->execute(array_values($data));

    //$statement = $pdo->prepare('INSERT INTO items ('.$aarray.') VALUES ('.$bbrray.')');
    // $statement->execute([
    //     'itemcode' => $_POST['info'],
    //     'Brand' => $_POST['info'],
    //     'Model' => $_POST['info'],
    // ]);
?>
