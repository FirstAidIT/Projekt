<?php
include 'db_connection.php'; 


$zuordnung = filter_input(INPUT_POST, 'Zuordnung');

$erfassungs_tag = filter_input(INPUT_POST, 'Erfassungstag');
$stunden_anzahl = filter_input(INPUT_POST, 'Stunden');
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
    kommentar) VALUES (
    '$mitarbeiterID',
    '$zuordnung', 
    '$erfassungs_tag', 
    '$startzeit',
    '$endzeit',
    '$stunden_anzahl', 
    '$kommentar' )";
        if ($conn->query($insert)) { 
            echo "Neuer Eintrag wurde hinzugefügt";
        } else {
            echo "Fehler:". $insert ."
            ".$conn->error;
        }
    $conn = null;

?>