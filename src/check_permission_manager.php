<?php 
include 'database.php'; 
$rolle = $conn->prepare(sprintf("SELECT rolle FROM person where mitarbeiterID = %d", $_SESSION['userid']));
        $rolle->execute();
        $dbRolle = $rolle->fetch()['rolle'];
        switch($dbRolle){
            case "Management": 
                break;
            default: 
                header("location: login.php");
                die();
                break;
        }    
?> 