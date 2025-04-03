<?php
function getDBConnection() {
    $host = "localhost";
    $db_name = "cleckhudders_market";
    $username = "root";
    $password = ""; 
    
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    } catch(PDOException $e) {
        echo "Connection Error: " . $e->getMessage();
        return null;
    }
}

function create_unique_id() {
    return bin2hex(random_bytes(16)); // Generates a 32-character hex string
}
?>