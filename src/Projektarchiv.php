<?php
include 'check_login.php';
include 'database.php';
?>
<!DOCTYPE html> 
<html>
<head>
	<title> Projektarchiv </title>
	
	<!-- meta data -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<!-- Javascript -->
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	
	
</head>
<body> 
<?php

	$sql = "SELECT archivierungsdatum, projektname, kunde, dauer, budget, aufwand, potenzial 
		FROM projekt
		Where ist_archiviert='1'
		ORDER BY archivierungsdatum DESC";
		
		
		echo "<br>";
		echo "<br>";
		echo '<table class="table table-hover">'; 
		echo "<thead>";
		echo		"<tr>";
		echo			"<th align=right>Archivierungsdatum</th>";
		echo			"<th>Projektname</th>";
		echo	  		"<th>Kunde</th>";		
		echo	  		"<th>Dauer</th>";
		echo	  		"<th>Budget</th>";
		echo	  		"<th>Aufwand</th>";
		echo	  		"<th>Potenzial</th>";
		echo		"</tr>";
		echo	  "</thead>";
		
		foreach ($db->query($sql) as $row) {
		echo "<tbody>";
		echo "<tr>";
		echo "<td>".$row['archivierungsdatum'] . "</td>";
		echo "<td>".$row['projektname'] . "</td>";
		echo "<td>". $row['kunde'] . "</td>";
		echo "<td>".$row['dauer']. "</td>";
		echo "<td>".$row['budget']. "</td>";
		echo "<td>".$row['aufwand']. "</td>";
		echo "<td>".$row['potenzial']. "</td>";
		echo "</tr>";
		echo "</tbody>";}
		echo "</table>";
	

?> 		
</body>
</html>