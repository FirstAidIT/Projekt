<?php
    include '//wip19_g3@web06.iis.uni-bamberg.de/wip19_g3/config.php';

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
    } catch(PDOException $e) {
        echo "Currently out of order.";
        die();
    }
?>