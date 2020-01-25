<?php
include 'datenbank/db_connection.php'; 

$sql= "SELECT zuordnung, 
Kunde,
erfassungs_tag, 
startzeit, 
endzeit, 
stunden_anzahl,
stunden_gesamt
FROM zeitkonto
WHERE zuordnung is not null";
$result = $db->query($sql);
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');

};




$sql2= "SELECT zuordnung, 
erfassungs_tag, 
startzeit, 
endzeit, 
stunden_anzahl,
kommentar 
FROM zeitkonto";
$result2= $db->query($sql2);
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');

};

$projekt = "SELECT zuordnung 
FROM zeitkonto 
where zuordnung is not null";
$result_projekt = $db->query($projekt); 
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
};

//getDate

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;



$stmt = $db->prepare($projekt);
$stmt-> execute();




?>