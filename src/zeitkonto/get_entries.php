<?php
include 'datenbank/db_connection.php'; 

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

$sql2 = "SELECT erfassungs_tag, stunden_anzahl, kommentar,
FROM zeitkonto where zuordenbar = 1";
$resultExtraHours = $db->query($sql2);
$r = function($newValue) {
    return htmlspecialchars($newValue, ENT_COMPAT, 'UTF-8');
};


?>