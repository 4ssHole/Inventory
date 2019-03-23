<?php
    include("../Connection.php");
    $stmt = $pdo->query('DELETE FROM items WHERE itemcode IN ('.implode(', ', $_POST['deleteItems']).')');
?>