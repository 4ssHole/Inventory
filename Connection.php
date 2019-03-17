<?php //inventory
        $host    = "localhost"; // Host name
        $db_name = "main";		// Database name
        $db_user = "root";		// Database user name
        $db_pass = "";		// Database Password
                // Table column from which suggestions will get shown

        $connection =mysqli_connect($host,$db_user,$db_pass)or die(mysqli_error());     
        mysqli_select_db($connection,$db_name)or die(mysqli_error());

        // $usersdb = "users";	
        // $Users = mysqli_connect($host,$db_user,$db_pass)or die(mysqli_error());
        // mysqli_select_db($Users,$usersdb)or die(mysqli_error());


        //$connection = new mysqli("localhost", "root", "", "main");
        //if($mysqli->connect_error) {
        //exit('Error connecting to database'); //Should be a message a typical user could understand in production
        //}
        //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        //$mysqli->set_charset("utf8mb4");


        $host = 'localhost';
        $db   = 'main';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
?>