<?php 
include 'database.php'; 
$rolle = $conn->prepare(sprintf("SELECT Rolle FROM users where id = %d", $_SESSION['userid']));
        $rolle->execute();
        $dbRolle = $rolle->fetch()['Rolle'];
        switch($dbRolle){
            case "Manager": 
                break;
            default: 
                header("location: login.php");
                die();
                break;
        }    
?> 