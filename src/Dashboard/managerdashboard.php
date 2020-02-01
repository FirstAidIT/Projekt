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
</body>
</html>

<?php

include 'check_login.php';
include 'database.php'; 

$sql = "SELECT projekt.kunde, projekt.projektname, projekt.dauer, projekt.budget, projekt.aufwand, person.name, skills.skillname
	      FROM projekt, person, braucht, Arbeitet_an
        WHERE projekt.projektId = braucht.projektId
        AND skills.skillID = braucht.skillID
        AND person.mitarbeiterID = Arbeitet_an.mitarbeiterID ";

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
	echo "<tr>";
	echo "<td>".$row['projektname'] . "</td>";
	echo "<td>".$row['kunde'] . "</td>";
  echo "<td>". $row['dauer'] . "</td>";
  echo "<td>". $row['budget'] . "</td>";
  echo "<td>".$row['aufwand']. "</td>";
  echo "<td>". $row['skillname'] . "</td>";
  echo "<td>". $row['name'] . "</td>";
  echo '<td ><button type="button" class="btn btn-outline-success btn-edit-modal"  data-toggle="modal" data-target="#myEditModal">Bearbeiten</button></td>';
	echo "</tr>";}

    echo "</table>";
?>