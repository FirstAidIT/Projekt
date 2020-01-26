<?php
	require_once('db.php');
	
	
		$sql = "SELECT erstellungsdatum, projektname, kunde, dauer, budget  
		FROM projekt
		WHERE erstellungsdatum >= now() - INTERVAL 1 WEEK";
		
		echo '<table class="table">'; 
		echo 	"<thead>";
		echo		"<tr>";
		echo			"<th>Erstellungsdatum</th>";
		echo	  		"<th>Projektname</th>";		
		echo			"<th>Kunde</th>";
		echo	  		"<th>Dauer</th>";
		echo	  		"<th>Budget</th>";
		echo		"</tr>";
		echo	  "</thead>";
		
		foreach ($db->query($sql) as $row) {
		echo "<tr>";
		echo "<td>".$row['erstellungsdatum'] . "</td>";
		echo "<td>". $row['projektname'] . "</td>";
		echo "<td>".$row['kunde'] . "</td>";
		echo "<td>".$row['dauer']. "</td>";
		echo "<td>".$row['budget']. "</td>";
		echo "</tr>";}
	
	echo "</table>";
?> 		