<?php
include 'db_connection.php'; 

$sql="SELECT zuordnung, 
erfassungs_tag, 
startzeit, 
endzeit, 
stunden_anzahl, 
kommentar FROM zeitkonto";
$result = $db->query($sql);
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');

};

?>