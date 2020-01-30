<?php
include 'datenbank/db_connection.php'; 

$mitarbeiterID = 1;

$sql= "SELECT 
projekt.projektID, 
projekt.projektname , 
projekt.kunde, 
projekt.endzeit, 
Arbeiten_an.mitarbeiterID, 
SEC_TO_TIME(SUM(TIME_TO_SEC(zeitkonto.stunden_anzahl))) as gesamt 
FROM projekt 
RIGHT JOIN Arbeiten_an ON projekt.projektID = Arbeiten_an.projektID
RIGHT JOIN zeitkonto ON Arbeiten_an.mitarbeiterID = zeitkonto.mitarbeiterID
WHERE projekt.ist_archiviert is null 
AND zeitkonto.erfassungs_tag BETWEEN curdate()- INTERVAL 30 DAY and curdate()
GROUP BY projekt.projektID, Arbeiten_an.mitarbeiterID, zeitkonto.mitarbeiterID, zeitkonto.zuordnung
";
$result = $db->query($sql);
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');

};




$sql2= "SELECT  
zeitkontoID,
zuordnung, 
erfassungs_tag, 
stunden_anzahl,
kommentar 
FROM zeitkonto
WHERE erfassungs_tag between curdate() - interval 7 day and curdate()" ;
$result2= $db->query($sql2);
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');

};

$mitarbeiterID = 1;

$projekt = "SELECT projektID, projektname , kunde, startzeit, endzeit
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