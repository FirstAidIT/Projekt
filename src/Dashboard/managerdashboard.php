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

//Kommentar

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
} else {
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
      <li class="nav-item">
        <a class="nav-link" href="einzelprojekt.php">Einzelprojektansicht</a>
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
if ($modus_aendern==false){?>
    <table class = "table table-success">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Projektname</th>
            <th scope="col">Kunde</th>
            <th scope="col">Dauer</th>
            <th scope="col">Budget (€)</th>
            <th scope="col">Budget/pro Monat (€)</th>
            <th scope="col">Aufwand (h)</th>
            <th scope="col">Skills</th> 
            <th scope="col">Aufwand der Mitarbeiter(h)</th>      
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($daten as $inhalt) {
            ?>			
                <tr>
                    <td><?php echo sicherheit($inhalt->projektname); ?> <br> <?php echo sicherheit($inhalt->potenzial); ?></td>
                    <td><?php echo sicherheit($inhalt->kunde); ?></td>
                    <td><?php echo sicherheit($inhalt->dauer); ?></td>
                    <td><?php echo sicherheit($inhalt->budget); ?></td>
                    <td><?php echo sicherheit($inhalt->budget/30); ?></td>
                    <td><?php echo sicherheit($inhalt->aufwand); ?></td>
                   
                    <td><a href = "?aktion=bearbeiten&projektID=<?php echo $inhalt->projektID; ?>" class="btn btn-secondary">Bearbeiten</a></td>
                </tr>
                <?php
            }
        }
}

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