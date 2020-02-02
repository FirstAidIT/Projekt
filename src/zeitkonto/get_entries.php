<?php
//include 'datenbank/db_connection.php'; 
include 'database.php';

SESSION_START(); 
/*$_SESSION['userid'] = $mitarbeiterID;

// SQL Abfrage für Monatsübersicht - Projektebene

$sql_month_projects= "SELECT 
zuordnung,
Kunde, 
SEC_TO_TIME(SUM(TIME_TO_SEC(zeitkonto.stunden_anzahl))) as gesamt 
FROM zeitkonto 
WHERE erfassungs_tag BETWEEN curdate()- INTERVAL 30 DAY and curdate()
AND zuordnung is not null
GROUP BY zuordnung ,kunde 
";
$result_month_projects = $conn->query($sql_month_projects);
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');

};

// SQL Abfrage für Monatsübersicht - inkl. nicht zurechenbar

$sql_month= "SELECT 
zuordnung,
Kunde,
SEC_TO_TIME(SUM(TIME_TO_SEC(zeitkonto.stunden_anzahl))) as gesamt 
FROM zeitkonto 
WHERE erfassungs_tag BETWEEN curdate()- INTERVAL 7 DAY and curdate()
GROUP BY zuordnung ,kunde 
";
$result_month = $conn->query($sql_month);
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');

};

// SQL Abfrage für Kundennamen 
$sql_kunde = "SELECT `projektname`,projekt.kunde FROM `projekt` 
LEFT JOIN zeitkonto
ON projekt.projektname = zeitkonto.zuordnung GROUP BY projekt.kunde, projekt.projektname";

// SQL Abfrage für Wochenübersicht der einzelnen gebuchten Stunden 
$sql2= "SELECT  
zeitkontoID,
zuordnung, 
kunde,
erfassungs_tag, 
stunden_anzahl,
kommentar 
FROM zeitkonto
WHERE erfassungs_tag between curdate() - interval 7 day and curdate()" ;
$result2= $conn->query($sql2);
$e = function($value) {
    return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');

};


/*$projekt = sprintf("SELECT projektID, projektname , kunde, startzeit, endzeit
FROM projekt 
WHERE EXISTS ( SELECT * FROM Arbeiten_an WHERE mitarbeiterID = %d)
AND ist_archiviert is null", $_SESSION['userid']);*/
/*
$stmt = $conn->prepare(sprintf("SELECT projektID, projektname , kunde, startzeit, endzeit
FROM projekt 
WHERE EXISTS ( SELECT * FROM Arbeiten_an WHERE mitarbeiterID = %d)
AND ist_archiviert is null", $_SESSION['userid']));
$stmt-> execute([$mitarbeiterID]);
$projects = $stmt->fetchAll(\PDO::FETCH_ASSOC);



  //Abfrage bisher gebuchte Wochenstunden
  $sql_week_hours = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(stunden_anzahl))) as weekhours
  FROM zeitkonto
  WHERE erfassungs_tag between curdate() - interval 7 day and curdate()";
  $week_hours= $conn->query($sql_week_hours);
  $e = function($value) {
      return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
  
  };


//getDate
$month = date('m');
$day = date('d');
$year = date('Y');
$today = $year . '-' . $month . '-' . $day;






*/







?>