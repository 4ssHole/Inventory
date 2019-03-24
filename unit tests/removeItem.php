<?php
    include("../Connection.php");
    $pdo->query('DELETE FROM items WHERE itemcode IN ('.implode(', ', $_POST['deleteItems']).')');
?>