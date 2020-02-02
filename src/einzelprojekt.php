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

$mitarbeiter = $_SESSION['userid'];


$abfrage = $conn->prepare("SELECT * from person where mitarbeiterID = $mitarbeiter");
$abfrage -> execute();
while ($row = $abfrage ->fetch()){
    $rolle_eingeloggt = $row['rolle'];
}




if (isset($_POST['aktion']) and $_POST['aktion']=='Projekt loeschen') {
    if (isset($_POST['projektID'])) {
        $projektID =$_POST['projektID'];
        if ($projektID > 0)
        {
            $loeschen = $conn->prepare("DELETE FROM projekt WHERE projektID=(?) LIMIT 1");
            $loeschen->execute([$projektID]);
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
            $starten = $conn->prepare("UPDATE projekt SET startzeit = '$datum' WHERE projektID=?");
            $starten->execute([$projektID]);
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
            $starten = $conn->prepare("UPDATE projekt SET endzeit = '$datumend' WHERE projektID=?");
            $starten->execute([$projektID]);
            if ($starten->execute()) {
                header ("Location: einzelprojekt.php");
                echo "<p>Projekt gestartet</p>";
            }
    }       
}

if (isset($_POST['aktion']) and $_POST['aktion']=='Mitarbeiter hinzufügen') {
    $projektIDadd = $_POST['projektID'];
    $mitarbeiterID_add = $_POST['hinzufügen'];
    $update = $conn->prepare("INSERT INTO Arbeiten_an (projektID, mitarbeiterID) VALUES ('$projektIDadd', '$mitarbeiterID_add')");
    $update -> execute();
    header ("Location: ?aktion=bearbeiten&projektID=$projektIDadd");
}

if (isset($_POST['löschen'])){
    $projektIDdelete = $_POST['projektID'];
    $mitarbeiterID_delete = $_POST['entfernenID'];
    $update = $conn->prepare("DELETE FROM Arbeiten_an WHERE projektID = '$projektIDdelete'");
    $update -> execute();
    header ("Location: ?aktion=bearbeiten&projektID=$projektIDdelete");
}


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
    echo "<p>Es liegen keine Daten vor :(</p>";
} else {
?>

<!-- navbar mit custom-link je nach Recht -->
<?php
    $rolle2 = $conn->prepare(sprintf("SELECT rolle FROM person where mitarbeiterID = %d", $_SESSION['userid']));
    $rolle2->execute();
    $dbRolle = $rolle2->fetch()['rolle'];
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

        <h3>Projekt  bearbeiten</h3>
        
        <label>
            <input type="hidden" name="projektID" class= "form-control" id="projektID" value="<?php echo $projektID; ?>">
        </label><br>
        <label>Projektame: <br>
            <input type="text" name="projektname" class= "form-control" id="projektname" value="<?php echo $projektname; ?>"<?php  if ($dh>=$ds){?> readonly <?php }?>>       
        </label><br>

        <input type="hidden" name="projektnamealt" id="projektnamealt" value="<?php echo $projektname; ?>">       

        <label>Aufwand:<br>
            <input type="text" name="aufwand" class= "form-control" id="aufwand" value="<?php echo $aufwand; ?>">
        </label><br>
        <label>Erstellungsdatum: <br>
            <input type="date" name="erstellungsdatum" class= "form-control" id="erstellungsdatum" value="<?php echo $erstellungsdatum; ?>" readonly>
        </label><br>
        <label>Startdatum: <br>
            <input type="date" name="startdatum" class= "form-control" id="startdatum" value="<?php echo $startdatum; ?>">
        </label><br>
        <label>Wahrscheinlichkeit: <br>
            <input type="text" name="wahrscheinlichkeit" class= "form-control" id="wahrscheinlichkeit" value="<?php echo $wahrscheinlichkeit; ?>" <?php  if ($dh>=$ds){?> readonly <?php }?>>       
        </label><br>
        <label>Kunde: <br>
            <input type="text" name="kunde" class= "form-control" id="kunde" value="<?php echo $kunde; ?>" readonly>       
        </label><br>
        <label>Budget: <br>
            <input type="text" name="budget" class= "form-control" id="budget" value="<?php echo $budget; ?>">       
        </label><br>
        <label>Dauer: <br>
            <input type="text" name="dauer"  class= "form-control" id="dauer" value="<?php echo $dauer; ?>">       
        </label><br>
        <label>Enddatum: <br>
            <input type="date" class= "form-control" name="enddatum" id="enddatum" value="<?php echo $enddatum; ?>">
        </label><br>
        <label>Archivierung: <br>
            <input type="date" name="archivierungsdatum" class= "form-control" id="archivierungsdatum" value="<?php echo $archivierungsdatum; ?>">       
        </label><br>
        <label><br>
            <input type="hidden" name="ist_archiviert" id="ist_archiviert" value="<?php echo $ist_archiviert; ?>">       
        </label>
        <?php  if ($dh<$ds){?>
        Potenzial:<br>
        <select name = "potenzial">
            <option value='<?php echo $potenzial?>' selected='selected'><?php echo $potenzial?></option>
            <option value ="+">+</option>
            <option value ="++">++</option>
            <option value ="+++">+++</option>
        </select><br>
        <?php }?><br>
        <label>Beteiligte Mitarbeiter:<br>
        <?php 
        $abfrage2 = $conn->prepare("SELECT * FROM Arbeiten_an WHERE projektID = $projektID");
        $abfrage2 -> execute();
        while ($row2 = $abfrage2 ->fetch()){
            $mitarbeiter2 = $row2['mitarbeiterID'];
            $abfrage4 = $conn->prepare("SELECT * FROM person WHERE mitarbeiterID = $mitarbeiter2");
            $abfrage4 -> execute();
            while ($row4 = $abfrage4 ->fetch()){
            $beteiligter = $row4['name'];
            $beteiligterID = $row4['mitarbeiterID']?>
            <input type="hidden" class= "form-control" name="entfernenID" id="dauer" value="<?php echo "$beteiligterID"; ?>">
            <input type="hidden" class= "form-control" name="entfernenprojektID" id="dauer" value="<?php echo "$projektID"; ?>">
            <input type="text" class= "form-control" name="beteiligter" id="beteiligter" value="<?php echo "$beteiligter"; ?>">
            <?php
        }}?>
        <br><input type="submit"  name="löschen" value="Mitarbeiter entfernen" class="btn btn-danger"></label><br>
        <br>
        <select name = "hinzufügen">
        <?php
                    $abfrage5 = $conn->prepare("SELECT name, mitarbeiterID FROM person");
                    $abfrage5 -> execute();
                    while ($row5 = $abfrage5 ->fetch()){
                    $maID = $row5['mitarbeiterID'];
                    $maauswahl = $row5['name'];
                    ?>
                    <option value='<?php echo $maID?>'><?php echo $maauswahl?></option>
                    <?php }?>
        </select><br><br><input type="submit"  name="aktion" value="Mitarbeiter hinzufügen" class="btn btn-success">
        <br><br>
        <!--<a href = "?aktion=loeschen&projektID=<?php echo $inhalt->projektID; ?>" onclick="return confirm('Soll das Projekt wirklich gelöscht werden?')"  class="btn btn-danger">Löschen</a></td>-->
        <input type="submit"  name="aktion" value="Übernehmen" class="btn btn-success">
        <input type ="submit" onclick="return confirm('Soll das Projekt wirklich gelöscht werden?')" name ="aktion" value ="Projekt loeschen" class="btn btn-danger">
        <?php
        //echo $ds;
        //echo '<br>';
        //echo $dh;
        if ($dh < $ds){?>
        <input type ="submit" name ="aktion" value ="Projekt starten" class="btn btn-primary">
        <?php
        }
        if ($dh < $de && $ds <= $dh){?>
            <input type ="submit" name ="aktion" value ="Projekt beenden" class="btn btn-primary">
            <?php
            }
        if ($ist_archiviert == 0 && $rolle_eingeloggt == "Management"){?>
            <input type="submit" name = "aktion" class="btn btn-warning" value="Archivieren">
        <?php
        }?>
        <!--<input type="hidden" name="aktion" value="speichern">-->
        <br><br>
        </form>  
        <?php
} 

            ?>			
        </tbody>
    </table>
    </body>
</html>