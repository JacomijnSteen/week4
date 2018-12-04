<?php
// Create connection     
        $db = "blog";
        $host = "localhost";
        $dsn = "mysql:dbname=$db;host=$localhost";
        $user_name = "root";
        $pass_word = "";  
        
        try {
            $connection = new PDO($dsn, $user_name, $pass_word);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
?>