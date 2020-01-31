<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/main.css">
<title>Einzelprojektansicht</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php
//require 'inc/db.php';

include 'check_login.php';
include 'database.php';



$daten = array();
if ($erg = $db->query("SELECT * FROM projekt order by erstellungsdatum asc")) {
	if ($erg->rowCount()) {
		while($datensatz = $erg->fetchObject()) {
			$daten[] = $datensatz;
		}
	}	
}
if (!count($daten)) {
    echo "<p>Es liegen keine Daten vor :(</p>";
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="start.php">Übersicht <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="projekterstellen.php">Projekt erstellen</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
    </li>
    <li class="nav-item ">
        <a class="fas fa-user fa-2x" href="managerdashboard.php" ></a>
    </li>
    </ul>
  </div>
</nav>

<br>
<?php
$sql = "SELECT projekt.projektname, projekt.kunde, projekt.dauer, zeitkonto.stunden_anzahl, projekt.budget, projekt.aufwand, person.name, SKILLS????
  FROM projekt, person";

echo '<table class="table">'; 
echo 	"<thead>";
echo		"<tr>";
echo			"<th>Projektname</th>";
echo			"<th>Kunde</th>";
echo	  		"<th>Projektdauer</th>";		
echo	  		"<th>Budget insgesamt</th>";
echo	  		"<th>Budget pro Monat</th>";
echo	  		"<th>Aufwand</th>";
echo	  		"<th>Skills</th>";
echo	  		"<th>Aufwand Mitarbeiter</th>";
echo	  		"<th>Bearbeiten</th>";


echo		"</tr>";
echo	  "</thead>";

foreach ($db->query($sql) as $row) {
echo "<tr>";
echo "<td>".$row['projektname'] . "</td>";
echo "<td>".$row['kunde'] . "</td>";
echo "<td>". $row['dauer'] . "</td>";
echo "<td>".$row['budget']. "</td>";
echo "<td>".$row['budget/dauer']. "</td>";
echo "<td>".$row['aufwand']. "</td>";
echo "<td>".$row['SKILLS']. "</td>";
echo "<td>".$row['person.name']. "</td>";
echo "<td><a href='einzelprojekt.php'>bearbeiten</a></td>";
echo "</tr>";}

echo "</table>";


function sicherheit($inhalt='') {
  $inhalt = trim($inhalt);
  $inhalt = htmlentities($inhalt, ENT_QUOTES, "UTF-8");
  return($inhalt);
}
 ?>			
      </tbody>
  </table>
  </body>
</html>