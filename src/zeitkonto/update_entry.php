<?php
//include './datenbank/db_connection.php'; 
include 'create_entry.php';
include 'database.php';

SESSION_START();
 /*
	if(ISSET($_POST['update'])){
  $stunden_anzahl = calculateTime($_POST['stunden_anzahl']);
<<<<<<< HEAD
  $conn->prepare(sprintf("UPDATE zeitkonto VALUES (%d, %s, SET zuordnung=?, erfassungs_tag=?, stunden_anzahl=?, kommentar=? WHERE zeitkontoID =?")->execute());
  $update_entry = "UPDATE zeitkonto SET zuordnung=?, erfassungs_tag=?, stunden_anzahl=?, kommentar=? WHERE zeitkontoID =?";
  
=======
	//$update_entry = "UPDATE zeitkonto SET zuordnung=?, erfassungs_tag=?, stunden_anzahl=?, kommentar=? WHERE zeitkontoID =?";
>>>>>>> de3aff901b5f22aaa5fe2cbed4a620788b5c427e

       $stmt_update = $conn->prepare("UPDATE zeitkonto SET zuordnung=?, erfassungs_tag=?, stunden_anzahl=?, kommentar=? WHERE zeitkontoID =?");
       $stmt_update->execute([$_POST['zuordnung'], $_POST['erfassungs_tag'], $stunden_anzahl, $_POST['kommentar'], $_POST['zeitkontoID']]);
       
 
<<<<<<< HEAD
		header("location: zeitkonto.php");
    }
=======
		header("location: zeitkontostart.php");
    }*/
>>>>>>> de3aff901b5f22aaa5fe2cbed4a620788b5c427e
    

?>