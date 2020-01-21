<?php
include '/datenbank/db_connection.php'; 


$zuordnung = filter_input(INPUT_POST, 'Zuordnung');

$erfassungs_tag = filter_input(INPUT_POST, 'Erfassungstag');
$stunden_anzahl = filter_input(INPUT_POST, 'Stunden');
$zuordenbar = filter_input(INPUT_POST, 'zuordenbar');
$kommentar = filter_input(INPUT_POST, 'Kommentar');

$startzeit = filter_input(INPUT_POST, 'Startzeit');
$endzeit = filter_input(INPUT_POST, 'Endzeit');

$mitarbeiterID = 1; // Set with session user 

    $conn = $db;
    $insert = "INSERT INTO zeitkonto (
    mitarbeiterID,
    zuordnung, 
    erfassungs_tag, 
    startzeit, 
    endzeit, 
    stunden_anzahl, 
    zuordenbar)
    kommentar
     VALUES (
    '$mitarbeiterID',
    '$zuordnung', 
    '$erfassungs_tag', 
    '$startzeit',
    '$endzeit',
    '$stunden_anzahl',
    '$zuordenbar', 
    '$kommentar' )";
        if ($conn->query($insert)) { 
            echo "Neuer Eintrag wurde hinzugefügt";
        } else {
            echo "Fehler:". $insert ."
            ".$conn->error;
        }
    $conn = null;

?>