<?php
    include("../Connection.php");
    echo 'DELETE FROM items WHERE itemcode IN (\''.implode(', \'', $_POST['deleteItems']).'\')';
    $pdo->query('DELETE FROM items WHERE itemcode IN (\''.implode(', \'', $_POST['deleteItems']).'\')');
?>