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

SESSION_START();


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

$datenprojekt = array();
if ($erg = $conn->query("SELECT * FROM projekt")) {
	if ($erg->rowCount()) {
		while($datensatz = $erg->fetchObject()) {
			$datenprojekt[] = $datensatz;
		}
	}	
}
$datenperson = array();
if ($erg = $conn->query("SELECT * FROM person")) {
	if ($erg->rowCount()) {
		while($datensatz = $erg->fetchObject()) {
			$datenperson[] = $datensatz;
		}
	}	
}
$datenskills = array();
if ($erg = $conn->query("SELECT * FROM skills")) {
	if ($erg->rowCount()) {
		while($datensatz = $erg->fetchObject()) {
			$datenskills[] = $datensatz;
		}
	}	
}

if (!count($daten)) {
    echo "<p>Es liegen keine Daten vor</p>";
} 
?>

<br>
    <table class = "table table-success">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Projektname</th>
            <th scope="col">Kunde</th>
            <th scope="col">Dauer</th>
            <th scope="col">Budget(€)</th>
            <th scope="col">Aufwand</th>
            <th scope="col">Skills</th>
            <th scope="col">Mitarbeiter</th>
            <!--<th scope="col">ProjektID</th>-->
            <th scope="col">Projektstatus</th>
            <th scope="col">Bearbeiten</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($datenprojekt as $inhalt) {
                foreach ($datenperson as $inhalt) {
                    foreach ($datenskills as $inhalt){          
            ?>			
                <tr>
                    <td><?php echo sicherheit($inhalt->projektname); ?> <br> <?php echo sicherheit($inhalt->potenzial); ?></td>
                    <td><?php echo sicherheit($inhalt->kunde); ?></td>
                    <td><?php echo sicherheit($inhalt->dauer); ?></td>
                    <td><?php echo sicherheit($inhalt->budget); ?></td>
                    <td><?php echo sicherheit($inhalt->skillname); ?></td>
                    <td><?php echo sicherheit($inhalt->mitarbeiter); ?></td>
                    <td><?php echo sicherheit($inhalt->budget); ?></td>
                    <td><?php echo sicherheit($inhalt->dauer); ?></td>
                    <?php if ($inhalt->ist_archiviert ==false){?><td><?php echo "laufend"; ?></td><?php }?>
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