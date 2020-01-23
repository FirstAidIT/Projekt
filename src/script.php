
<?php
if(isset($_POST['sent'])){
	$sql = "SELECT skills.skillname, skills.skillauspraegung, mitarbeiter.name, besitzt.timestmp 
	FROM bestitzt, mitarbeiter, skills
	WHERE mitarbeiter.mitarbeiterID = besitzt.mitarbeiterID 
	AND besitzt.skillID = skills.skillID
	AND besitzt.timestmp >= now() - INTERVAL 1 WEEK";

	$result = $conn->query($sql);

	while($row = $result->fetch_assoc()) {
		echo "<br>  " . $row["Skillname"].  
		" <br> Skillausprägung: " . $row["skillauspraegung"].   " <br> Mitarbeitername " . $row["mitarbeiter.name"]. 
		" <br> Änderungszeitpunkt: " . $row["besitzt.timestmp"]. "<br>";
	}
}
?>