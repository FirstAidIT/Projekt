<?php
//include './datenbank/db_connection.php'; 
include 'create_entry.php';
include 'database.php';

SESSION_START();
 
if(ISSET($_POST['update'])){
  $stunden_anzahl = calculateTime($_POST['stunden_anzahl']);
	$update_entry = "UPDATE zeitkonto SET zuordnung=?, erfassungs_tag=?, stunden_anzahl=?, kommentar=? WHERE zeitkontoID =?";

       $stmt_update = $conn->prepare($update_entry);
       $stmt_update->execute([$_POST['zuordnung'], $_POST['erfassungs_tag'], $stunden_anzahl, $_POST['kommentar'], $_POST['zeitkontoID']]);
       
 
		header("location: zeitkonto.php");
    }

?>