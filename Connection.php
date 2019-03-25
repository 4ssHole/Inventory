<?php //inventory				
        $host = 'localhost';
        $db   = 'main';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $connection =mysqli_connect($host,$user,$pass)or die(mysqli_error());     
        mysqli_select_db($connection,$db)or die(mysqli_error());
                
        $Users = mysqli_connect($host,$user,$pass)or die(mysqli_error());
        mysqli_select_db($Users,$db)or die(mysqli_error());

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
                $pdo = new PDO($dsn, $user, $pass, $options);
        } 
        catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
?>