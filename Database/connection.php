<?php

function connect() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=MidtermSystem",  $username, $password);
    
        // sets the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // established connection
        return $conn;
    } catch (PDOException $e) {
        // failed to establish a connection
        error_log($e->getMessage());
    }   
}
