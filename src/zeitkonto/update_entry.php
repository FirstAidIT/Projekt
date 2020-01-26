<?php
include './datenbank/db_connection.php'; 

 
	if(ISSET($_POST['update'])){
	$update_entry = "UPDATE zeitkonto SET zuordnung=?, erfassungs_tag=?, stunden_anzahl=?, kommentar=? WHERE zeitkontoID =?";

       $stmt_update = $db->prepare($update_entry);
       $stmt_update->execute([$_POST['zuordnung'], $_POST['erfassungs_tag'], $_POST['stunden_anzahl'], $_POST['kommentar'], $_POST['zeitkontoID']]);
       
 
		header("location: ./../../index.php");
    }
    

?>