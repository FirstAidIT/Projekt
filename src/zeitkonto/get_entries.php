<?php
include 'datenbank/db_connection.php'; 

$sql= "SELECT 
zeitkontoID,
zuordnung, 
Kunde,
erfassungs_tag, 
startzeit, 
DATE_FORMAT(endzeit,\"%d.%m.%Y\") as endzeit,
stunden_anzahl,
stunden_gesamt
FROM zeitkonto
WHERE zuordnung is not null";
$result = $db->query($sql);
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');

};




$sql2= "SELECT  
zeitkontoID,
zuordnung, 
DATE_FORMAT(erfassungs_tag,\"%d.%m.%Y\") as erfassungs_tag, 
startzeit, 
endzeit, 
stunden_anzahl,
kommentar 
FROM zeitkonto";
$result2= $db->query($sql2);
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');

};

$mitarbeiterID = 1;

$projekt = "SELECT projektID, projektname 
FROM projekt 
WHERE EXISTS ( SELECT * FROM Arbeiten_an WHERE mitarbeiterID=?)";

$stmt = $db->prepare($projekt);
$stmt-> execute([$mitarbeiterID]);
$projects = $stmt->fetchAll(\PDO::FETCH_ASSOC);


//getDate
$month = date('m');
$day = date('d');
$year = date('Y');
$today = $year . '-' . $month . '-' . $day;








?>