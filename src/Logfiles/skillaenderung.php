<?php
	require_once('db.php');

	$sql = "SELECT person.name, skills.skillname, besitzt.auspraegung, besitzt.timestmp 
	FROM besitzt, person, skills
	WHERE person.mitarbeiterID = besitzt.mitarbeiterID 
	AND besitzt.skillID = skills.skillID
	AND besitzt.timestmp >= now() - INTERVAL 1 WEEK";

	echo '<table class="table">'; 
	echo 	"<thead>";
	echo		"<tr>";
	echo			"<th>Mitarbeitername</th>";
	echo			"<th>Skill</th>";
	echo	  		"<th>Ausprägung</th>";		
	echo	  		"<th>Änderungszeitpunkt</th>";
	echo		"</tr>";
	echo	  "</thead>";

	foreach ($db->query($sql) as $row) {
	echo "<tr>";
	echo "<td>".$row['name'] . "</td>";
	echo "<td>".$row['skillname'] . "</td>";
	echo "<td>". $row['auspraegung'] . "</td>";
	echo "<td>".$row['timestmp']. "</td>";
	echo "</tr>";}

	echo "</table>";
?> 		