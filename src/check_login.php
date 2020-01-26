<?php
session_start();
    if(!isset($_SESSION['userid'])) {
        die(header("location: login.php"));
    }
?>