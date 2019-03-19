<?php
    session_start();
    ob_start();

    include("../Connection.php");



    $statement = $pdo->prepare('INSERT INTO items (itemcode)
    VALUES (:itemcode)');

    $statement->execute([
        'itemcode' => 'zgay',
    ]);
?>
