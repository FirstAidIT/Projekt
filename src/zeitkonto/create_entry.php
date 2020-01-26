<?php
include './datenbank/db_connection.php'; 

$mitarbeiterID = 1;

 
	if(ISSET($_POST['erfassen'])){

        $zuordnung = $_POST['zuordnung'];
        if (!empty($zuordnung)) {
            $erfassungs_tag = $_POST['erfassungs_tag_zuordenbar'];
            $stunden_anzahl = $_POST['stunden_anzahl_zuordenbar'];
        } else {
            $erfassungs_tag = $_POST['erfassungs_tag'];
            $stunden_anzahl = $_POST['stunden_anzahl'];
            $kommentar = $_POST['kommentar'];
        }

        $create_no_allocate = "INSERT INTO zeitkonto SET zuordnung=?, erfassungs_tag=?, stunden_anzahl=?, mitarbeiterID=?";

       $stmt_update = $db->prepare($create_no_allocate);
       $stmt_update->execute([$zuordnung, $erfassungs_tag , $stunden_anzahl, $mitarbeiterID ]);
       
 
		header("location: ./../../index.php");
    }
    

?>