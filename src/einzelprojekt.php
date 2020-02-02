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

SESSION_START();




// Rolle abfragen

//$id = $_SESSION['mitarbeiterid'];
//$bearbeitung_projektid = $_POST['projektID'];

/*$abfrage = $conn->prepare("SELECT * from person where mitarbeiterID = $id");
$abfrage -> execute();
while ($row = $abfrage ->fetch()){
    $rolle_eingeloggt = $row['rolle'];
}

//Beteiligte Mitarbeiter abfragen

$abfrage_ma = $conn->prepare("SELECT mitarbeiterID from Arbeiten_an where projektID = $bearbeitung_projektid");
$abfrage_ma -> execute();
while ($row_ma = $abfrage_ma ->fetch()){
    $ma_beteiligt = $row_ma['rolle'];
    echo $ma_beteiligt;
}

//Skills abfragen

$abfrage_sk = $conn->prepare("SELECT skillID from braucht where projektID = $bearbeitung_projektid");
$abfrage_sk -> execute();
while ($row_sk = $abfrage_sk ->fetch()){
    $sk_projekt = $row_sk['skillID'];
    echo $sk_projekt;
}*/

// Projekt löschen


mitarbeiter = $_SESSION['mitarbeiterid'];
// Rolle abfragen

$abfrage = $db->prepare("SELECT * from person where mitarbeiterID = $mitarbeiter");
$abfrage -> execute();
while ($row = $abfrage ->fetch()){
    echo $row['rolle'];
    echo $row['name'];

    $rolle_eingeloggt = $row['rolle'];
}





if (isset($_POST['aktion']) and $_POST['aktion']=='Projekt loeschen') {
    if (isset($_POST['projektID'])) {
        $projektID =$_POST['projektID'];
        if ($projektID > 0)
        {
            $loeschen = $db->prepare("DELETE FROM projekt WHERE projektID=(?) LIMIT 1");
            $loeschen->bindParam(1, $projektID, PDO::PARAM_STR);
            if ($loeschen->execute()) {
                ?>
                <meta http-equiv="refresh" content="5; URL=einzelprojekt.php"> 
                <?php
                echo "<p>Datensatz wurde gelöscht</p>";
            }
        }       
    }
}

$start = time();
$datum = date("Y-m-d", $start);
if (isset($_POST['aktion']) and $_POST['aktion']=='Projekt starten') {
    if (isset($_POST['projektID'])) {
        $projektID =$_POST['projektID'];
            $starten = $db->prepare("UPDATE projekt SET startzeit = '$datum' WHERE projektID=?");
            $starten->bindParam(1, $projektID, PDO::PARAM_STR);
            if ($starten->execute()) {
                header ("Location: einzelprojekt.php");
                echo "<p>Projekt gestartet</p>";
            }
    }       
}

$end = time();
$datumend = date("Y-m-d", $end);
if (isset($_POST['aktion']) and $_POST['aktion']=='Projekt beenden') {
    if (isset($_POST['projektID'])) {
        $projektID =$_POST['projektID'];
            $starten = $db->prepare("UPDATE projekt SET endzeit = '$datumend' WHERE projektID=?");
            $starten->bindParam(1, $projektID, PDO::PARAM_STR);
            if ($starten->execute()) {
                header ("Location: einzelprojekt.php");
                echo "<p>Projekt gestartet</p>";
            }
    }       
}
//Projekt archivieren
if (isset($_POST['aktion']) and $_POST['aktion']=='Archivieren') {
    $projektIDarchivieren = $_POST['projektID'];
    $update = $conn->prepare("UPDATE projekt SET ist_archiviert = 1 WHERE projektID=?");
    $update -> execute([$projektIDarchivieren]);
    header ("Location: ?aktion=bearbeiten&projektID=$projektIDarchivieren");
}


if (isset($_POST['aktion']) and $_POST['aktion']=='Übernehmen') {


    $upd_erstellungsdatum = "";
    if (isset($_POST['erstellungsdatum'])) {
        $upd_erstellungsdatum = trim($_POST['erstellungsdatum']);
    }
    //zum Vergleichen
    $projektnamealt = $_POST['projektnamealt'];
    $upd_aufwand = "";
    if (isset($_POST['aufwand'])) {
        $upd_aufwand = trim($_POST['aufwand']);
    }
    $upd_projektname = "";
    if (isset($_POST['projektname'])) {
        $upd_projektname = trim($_POST['projektname']);
    }
    $upd_wahrscheinlichkeit = "";
    if (isset($_POST['wahrscheinlichkeit'])) {
        $upd_wahrscheinlichkeit = trim($_POST['wahrscheinlichkeit']);
    }
    $upd_projektID = "";
    if (isset($_POST['projektID'])) {
        $upd_projektID = trim($_POST['projektID']);
    }
    $upd_kunde = "";
    if (isset($_POST['kunde'])) {
        $upd_kunde = trim($_POST['kunde']);
    }
    $upd_budget = "";
    if (isset($_POST['budget'])) {
        $upd_budget = trim($_POST['budget']);
    }
    $upd_dauer = "";
    if (isset($_POST['dauer'])) {
        $upd_dauer = trim($_POST['dauer']);
    }
    $upd_archivierungsdatum = "";
    if (isset($_POST['archivierungsdatum'])) {
        $upd_archivierungsdatum = trim($_POST['archivierungsdatum']);
    }
    $upd_potenzial = "";
    if (isset($_POST['potenzial'])) {
        $upd_potenzial = trim($_POST['potenzial']);
    }
    $upd_startdatum = "";
    if (isset($_POST['startdatum'])) {
        $upd_startdatum = trim($_POST['startdatum']);
    }
    $upd_enddatum = "";
    if (isset($_POST['enddatum'])) {
        $upd_enddatum = trim($_POST['enddatum']);
    }

    $statement = $conn->prepare("SELECT* FROM projekt WHERE projektname = '$upd_projektname'");
    $statement->execute(array('Max')); 
    $anzahl_projekte = $statement->rowCount();

    if ($anzahl_projekte > 0 && $upd_projektname != $projektnamealt ){
        header ("Location: ?aktion=bearbeiten&projektID=$upd_projektID");
        echo "Dieser Projektname ist bereits vorhanden";
    }

    else{
        if ($upd_erstellungsdatum != '' AND $upd_aufwand != '' AND  $upd_projektname != '' AND $upd_wahrscheinlichkeit != '' AND $upd_kunde != '' AND  $upd_budget != '')
        {
            // speichern
            $update = $conn->prepare("UPDATE projekt SET erstellungsdatum =?, aufwand=?, projektname=?, wahrscheinlichkeit=? , kunde=?, budget=?, dauer=?, archivierungsdatum=?, potenzial=?, startzeit=?, endzeit=? WHERE projektID=?");
            $update->execute([$upd_erstellungsdatum, $upd_aufwand, $upd_projektname, $upd_wahrscheinlichkeit, $upd_kunde, $upd_budget, $upd_dauer, $upd_archivierungsdatum, $upd_potenzial,  $upd_startdatum, $upd_enddatum, $upd_projektID]);
            if ($update->execute()) {
                header ("Location: einzelprojekt.php");
                echo '<p class="feedbackerfolg">Datensatz wurde geändert</p>';
                $modus_aendern = false;

            }
        }
        else echo "Bitte geben sie alle notwendigen Informationen an!";
    }   
}

$modus_aendern = false;
if (isset($_GET['aktion']) and $_GET['aktion']=='bearbeiten') {
    $modus_aendern = true;
}

$daten = array();
if ($erg = $conn->query("SELECT * FROM projekt order by erstellungsdatum asc")) {
	if ($erg->rowCount()) {
		while($datensatz = $erg->fetchObject()) {
			$daten[] = $datensatz;
		}
	}	
}
if (!count($daten)) {
    echo "<p>Es liegen keine Daten vor</p>";
} else {
?>

<?php
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
<?php
if ($modus_aendern==false){?>
    <table class = "table table-success">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Projektname</th>
            <th scope="col">Aufwand (h)</th>
            <th scope="col">Erstellung</th>
            <th scope="col">Startdatum</th>
            <th scope="col">Wahrscheinlichkeit (%)</th>
            <th scope="col">Kunde</th>
            <th scope="col">Budget (€)</th>
            <!--<th scope="col">ProjektID</th>-->
            <th scope="col">Dauer</th>
            <th scope="col">Enddatum</th>
            <th scope="col">Archivierung</th>
            <th scope="col">Projektstatus</th>
            <th scope="col">Bearbeiten</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($daten as $inhalt) {
            ?>			
                <tr>
                    <td><?php echo sicherheit($inhalt->projektname); ?> <br> <?php echo sicherheit($inhalt->potenzial); ?></td>
                    <td><?php echo sicherheit($inhalt->aufwand); ?></td>
                    <td><?php echo sicherheit($inhalt->erstellungsdatum); ?></td>
                    <td><?php echo sicherheit($inhalt->startzeit); ?></td>
                    <td><?php echo sicherheit($inhalt->wahrscheinlichkeit); ?></td>
                    <td><?php echo sicherheit($inhalt->kunde); ?></td>
                    <td><?php echo sicherheit($inhalt->budget); ?></td>
                    <!--<td><?php echo sicherheit($inhalt->projektID); ?></td>-->
                    <td><?php echo sicherheit($inhalt->dauer); ?></td>
                    <td><?php echo sicherheit($inhalt->endzeit); ?></td>
                    <td><?php echo sicherheit($inhalt->archivierungsdatum); ?></td>
                    <!--<td><a href = "?aktion=anzeigen&mitarbeiterID=<?php echo $inhalt->projektID; ?>" class="w3-btn w3-black">Anzeigen</a></td>-->
                    <?php if ($inhalt->ist_archiviert ==true){?><td><?php echo "archiviert"; ?></td><?php }?>
                    <?php if ($inhalt->ist_archiviert ==false){?><td><?php echo "laufend"; ?></td><?php }?>
                    <td><a href = "?aktion=bearbeiten&projektID=<?php echo $inhalt->projektID; ?>" class="btn btn-secondary">Bearbeiten</a></td>
                </tr>
                <?php
            }
        }
}

if ( $modus_aendern == true and isset($_GET['projektID']) ) {
    
    $id_einlesen = (INT) $_GET['projektID'];
    if ($id_einlesen > 0)
    {   
        $dseinlesen = $conn->prepare("SELECT * FROM projekt WHERE projektID=? order by erstellungsdatum asc ");
        $dseinlesen->execute([$id_einlesen]);
        $dseinlesen->execute();
        while ($row = $dseinlesen->fetch()) {
            $projektID = $row['projektID'];
            $erstellungsdatum = $row['erstellungsdatum'];
            $aufwand = $row['aufwand'];
            $projektname = $row['projektname'];
            $wahrscheinlichkeit = $row['wahrscheinlichkeit'];
            $kunde = $row['kunde'];
            $budget = $row['budget'];
            $dauer = $row['dauer'];
            $archivierungsdatum = $row['archivierungsdatum'];
            $potenzial = $row['potenzial'];
            $startdatum = $row['startzeit'];
            $enddatum = $row ['endzeit'];
            $ist_archiviert = $row['ist_archiviert'];
        }
    }
}

function sicherheit($inhalt='') {
    $inhalt = trim($inhalt);
    $inhalt = htmlentities($inhalt, ENT_QUOTES, "UTF-8");
    return($inhalt);
}
if ($modus_aendern == true){
    $heute = time();
    $datumheute = date("Y-m-d", $heute);
    $dh = strtotime($datumheute);
    $ds = strtotime($startdatum);
    $de = strtotime($enddatum);
    ?>
    <div style = "width:400; margin:auto">
    <form class = "form-horizontal" action="einzelprojekt.php?aktion=bearbeiten&projektID=$projektID" method="post">

        <br>
        <h3>Projekt  bearbeiten</h3>
        
        <label>
            <input type="hidden" name="projektID" id="projektID" value="<?php echo $projektID; ?>">
        </label><br>
        <label>Projektame: <br>
            <input type="text" name="projektname" class= "form-control" id="projektname" value="<?php echo $projektname; ?>">       
        </label><br>

        <input type="hidden" name="projektnamealt" class= "form-control" id="projektnamealt" value="<?php echo $projektname; ?>">       

        <label>Aufwand (Stunden/Woche):<br>
            <input type="text" name="aufwand" class= "form-control" id="aufwand" value="<?php echo $aufwand; ?>">
        </label><br>
        <label>Erstellungsdatum: <br>
            <input type="date" name="erstellungsdatum" class= "form-control" id="erstellungsdatum" value="<?php echo $erstellungsdatum; ?>" readonly>
        </label><br>
        <label>Startdatum: <br>
            <input type="date" name="startdatum" class= "form-control" id="startdatum" value="<?php echo $startdatum; ?>">
        </label><br>
        <label>Wahrscheinlichkeit: <br>
            <input type="text" name="wahrscheinlichkeit" class= "form-control" id="wahrscheinlichkeit" value="<?php echo $wahrscheinlichkeit; ?>">       
        </label><br>
        <label>Kunde: <br>
            <input type="text" name="kunde" class= "form-control" id="kunde" value="<?php echo $kunde; ?>" readonly>       
        </label><br>
        <label>Budget: <br>
            <input type="text" name="budget" class= "form-control" id="budget" value="<?php echo $budget; ?>">       
        </label><br>
        <label>Dauer: <br>
            <input type="text" name="dauer" class= "form-control" id="dauer" value="<?php echo $dauer; ?>">       
        </label><br>
        <label>Enddatum: <br>
            <input type="date" name="enddatum" class= "form-control" id="enddatum" value="<?php echo $enddatum; ?>">
        </label><br>
        <label>Archivierung: <br>
            <input type="date" name="archivierungsdatum" class= "form-control" id="archivierungsdatum" value="<?php echo $archivierungsdatum; ?>">       
        </label><br>
        <label><br>
            <input type="hidden" name="ist_archiviert" id="ist_archiviert" value="<?php echo $ist_archiviert; ?>">       
        </label>
        Potenzial:<br>
        <select name = "potenzial">
            <option value='<?php echo $potenzial?>' selected='selected'><?php echo $potenzial?></option>
            <option value ="+">+</option>
            <option value ="++">++</option>
            <option value ="+++">+++</option>
        </select>
        <?php
        /*
        $skillsabfrage = $conn->prepare("SELECT * from braucht WHERE projektID = '$bearbeitung_projektid'");
        $skillsabfrage ->execute();
        $while ($saf = $skillsabfrage->fetch()){
            $skills = $row['skillID'];
        }
        */
        ?>
<br> <br>
        <br>
        <!--<a href = "?aktion=loeschen&projektID=<?php echo $inhalt->projektID; ?>" onclick="return confirm('Soll das Projekt wirklich gelöscht werden?')"  class="btn btn-danger">Löschen</a></td>-->
        <input type="submit"  name="aktion" value="Übernehmen" class="btn btn-success">
        <input type ="submit" onclick="return confirm('Soll das Projekt wirklich gelöscht werden?')" name ="aktion" value ="Projekt loeschen" class="btn btn-danger">        
        <?php 
        if ($dh < $ds){?>
        <input type ="submit" name ="aktion" value ="Projekt starten" class="btn btn-primary">
        <?php
        }
        if ($dh < $de){?>
            <input type ="submit" name ="aktion" value ="Projekt beenden" class="btn btn-primary">
            <?php
            }
        if ($ist_archiviert == 0 && $rolle_eingeloggt == "Management"){?>
            <input type="submit" name = "aktion" class="btn btn-warning" value="Archivieren">
        <?php
        }?>
        <!--<input type="hidden" name="aktion" value="speichern">-->
        <br><br>
        <a href = "einzelprojekt.php" class="btn btn-dark">Zurück zum Dashboard</a></td>
        </form>  
        <?php
} 

            ?>			
        </tbody>
    </table>
    </body>
</html>