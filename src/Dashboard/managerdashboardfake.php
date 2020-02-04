<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<title>Mitarbeiterdashboard</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/mitarbeiterdashboard.css">


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
                <li class="nav-item">
        <a class="nav-link" href="zeitkonto.php">Gesamtstundenübersicht</a> 
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


$sql = "SELECT *
	    FROM projekt
        ";

	echo '<table class="table">'; 
	echo 	"<thead>";
	echo		"<tr>";
	echo			"<th>Projektname</th>";
	echo			"<th>Kunde</th>";
	echo	  		"<th>Projektdauer(in Wochen)</th>";		
	echo	  		"<th>Budget(€)</th>";
	echo	  		"<th>Aufwand(in h)</th>";
	echo	  		"<th>Skills</th>";
	echo	  		"<th>Mitarbeiter</th>";
	echo	  		"<th>Bearbeiten</th>";
   	echo		"</tr>";
	echo	  "</thead>";

	foreach ($conn->query($sql) as $row) {
	echo "<tr>";
	echo "<td>".$row['projektname'] . "</td>";
	echo "<td>".$row['kunde'] . "</td>";
	echo "<td>". $row['dauer'] . "</td>";
    echo "<td>".$row['budget']. "</td>";
	echo "<td>".$row['aufwand']. "</td>";
	echo "<td>".$row['skillan']. "</td>";
	echo "<td>".$row['mitarbeiteran']. "</td>";
	echo "<td><a href='einzelprojekt.php&projektid'>Bearbeiten</a></td>";
	echo "</tr>";}

    echo "</table>";
?>