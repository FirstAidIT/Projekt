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


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="start.php">Menü <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="stunden.php">Gesamtstundenübersicht</a> 
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
    </li>
    <li class="nav-item ">
        <a class="fas fa-user fa-2x" href="mitarbeiterdashboard.php" ></a>
    </li>
    </ul>
  </div>
</nav>

<br>
</body>
</html>

<?php

include 'check_login.php';
include 'database.php'; 


$sql = "SELECT projekt.projektname, projekt.kunde, projekt.dauer, zeitkonto.stunden_anzahl
	      FROM projekt, zeitkonto, Arbeitet_an, person
        WHERE Arbeitet_an.mitarbeiterID = person.mitarbeiterID
        AND Arbeitet_an.projektID = projekt.projektID";

	echo '<table class="table">'; 
	echo 	"<thead>";
	echo		"<tr>";
	echo			"<th>Projektname</th>";
	echo			"<th>Kunde</th>";
	echo	  		"<th>Projektdauer</th>";		
	echo	  		"<th>Gebuchte Stunden insgesamt</th>";
 //   echo	  		"<th>aktuelle Stunden</th>";
	echo		"</tr>";
	echo	  "</thead>";

	foreach ($db->query($sql) as $row) {
	echo "<tr>";
	echo "<td>".$row['projektname'] . "</td>";
	echo "<td>".$row['kunde'] . "</td>";
	echo "<td>". $row['dauer'] . "</td>";
	echo "<td>".$row['stunden_anzahl']. "</td>";
	echo "</tr>";}

    echo "</table>";
?>