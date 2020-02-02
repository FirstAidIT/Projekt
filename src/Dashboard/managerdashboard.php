<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/main.css">
<title>Mitarbeiterdashboard</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


</head>
<body>

<?php
include 'check_login.php';
include 'database.php'; 
    $rolle = $conn->prepare(sprintf("SELECT rolle FROM person where mitarbeiterID = %d", $_SESSION['userid']));
    $rolle->execute();
    $dbRolle = $rolle->fetch()['rolle'];
    switch($dbRolle){
        case "Management": 
            $link = "management.php";
            break;
        case "Vertrieb":
            $link = "vertrieb.php";
            break;
        case "Mitarbeiter":
            $link = "start.php";
            break;
    }
    ?>

<nav class="navbar navbar-default navbar-expand-sm">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                        <a class="btn btn-light custom-btn" href="<?php echo $link ?>">Zurück zum Hauptmenü</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                        <a class="btn btn-light custom-btn" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>

<br>
</body>
</html>

<?php



$sql = "SELECT projekt.projektname, projekt.kunde, projekt.dauer, zeitkonto.stunden_anzahl, projekt.projektID, projekt.startzeit
        FROM projekt, zeitkonto, Arbeiten_an, person
        WHERE Arbeiten_an.mitarbeiterID = person.mitarbeiterID
        AND Arbeiten_an.projektID = projekt.projektID
        AND projekt.ist_archiviert is null";


	echo '<table class="table">'; 
	echo 	"<thead>";
	echo		"<tr>";
	echo			"<th>Projektname</th>";
	echo			"<th>Kunde</th>";
	echo	  		"<th>Projektdauer</th>";		
  echo	  		"<th>Budget</th>";
  echo	  		"<th>Aufwand</th>";
  echo	  		"<th>Skills</th>";
  echo	  		"<th>Mitarbeiter</th>";
  echo	  		"<th>Projektansicht</th>";
	echo		"</tr>";
	echo	  "</thead>";
    
	foreach ($db->query($sql) as $row) {
        /*$startzeit=$row['startzeit']; 
        $dh = strtotime($startzeit);
    if ($dh <= NOW()) {
      $color = "0000FF";}*/
	echo "<tr>";
	echo "<td style='background: #" . $color . "'>".$row['projektname'] . "</td>";
	echo "<td style='background: #" . $color . "'>".$row['kunde'] . "</td>";
  echo "<td style='background: #" . $color . "'>". $row['dauer'] . "</td>";
  echo "<td style='background: #" . $color . "'>". $row['budget'] . "</td>";
  echo "<td style='background: #" . $color . "'>".$row['aufwand']. "</td>";
  echo "<td style='background: #" . $color . "'>". $row['skillname'] . "</td>";
  echo "<td style='background: #" . $color . "'>". $row['name'] . "</td>";
  echo "<td><a href='einzelprojekt.php' &projektID >Bearbeiten</a></td>";
	echo "</tr>";}

    echo "</table>";
?>