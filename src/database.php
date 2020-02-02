<?php
    include 'config.php';

    $conn = null;
    
    try {
        $dns = sprintf(
            "mysql:host=%s;dbname=%s", 
            $config['DB_HOST'], 
            $config['DB_DATABASE']
        );

        $conn = new PDO($dns,
            $config['DB_USERNAME'],
            $config['DB_PASSWORD']
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Currently out of order.";
        die();
    }
?>