<?php
try{
    $db= new PDO('mysql:host=localhost;dbname=benutzerverwaltung', 'ASK', '123');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
    echo 'Verbindung fehlgeschlagen: ' . $e->getMessage();}
?>
