<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  
    <link rel="stylesheet" href="/main.css">
<title>Einzelprojektansicht</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php


require 'inc/db.php';

if (isset($_GET['aktion']) and $_GET['aktion']=='loeschen') {
    if (isset($_GET['projektID'])) {
        $projektID =$_GET['projektID'];
        if ($projektID > 0)
        {
            $loeschen = $db->prepare("DELETE FROM projekt WHERE projektID=(?) LIMIT 1");
            $loeschen->bindParam(1, $projektID, PDO::PARAM_STR);
            if ($loeschen->execute()) {
                echo "<p>Datensatz wurde gelöscht</p>";
            }
        }       
    }
}

if (isset($_POST['aktion']) and $_POST['aktion']=='korrigieren') {
    $upd_erstellungsdatum = "";
    if (isset($_POST['erstellungsdatum'])) {
        $upd_erstellungsdatum = trim($_POST['erstellungsdatum']);
    }
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


    if ($upd_erstellungsdatum != '' or $upd_aufwand != '')
    {
        // speichern
        $update = $db->prepare("UPDATE projekt SET erstellungsdatum =?, aufwand=?, projektname=?, wahrscheinlichkeit=? , kunde=?, budget=?, dauer=?, archivierungsdatum=?, potenzial=? WHERE projektID=?");
        $update->execute([$upd_erstellungsdatum, $upd_aufwand, $upd_projektname, $upd_wahrscheinlichkeit, $upd_kunde, $upd_budget, $upd_dauer, $upd_archivierungsdatum, $upd_potenzial, $upd_projektID]);
        if ($update->execute()) {
            echo '<p class="feedbackerfolg">Datensatz wurde geändert</p>';
            $modus_aendern = false;
        }
    }
    else echo "Bitte geben sie alle notwendigen Informationen an!";
}

$modus_aendern = false;
if (isset($_GET['aktion']) and $_GET['aktion']=='bearbeiten') {
    $modus_aendern = true;
}

$daten = array();
if ($erg = $db->query("SELECT * FROM projekt")) {
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


    <table class = "table table-dark">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Erstellung</th>
                <th scope="col">Aufwand</th>
                <th scope="col">Projektname</th>
                <th scope="col">Wahrscheinlichkeit</th>
                <th scope="col">Kunde</th>
                <th scope="col">Budget</th>
                <th scope="col">ProjektID</th>
                <th scope="col">Dauer</th>
                <th scope="col">Archivierung</th>
                <th scope="col">Potenzial</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($daten as $inhalt) {
            ?>			
                <tr>
                    <td><?php echo sicherheit($inhalt->erstellungsdatum); ?></td>
                    <td><?php echo sicherheit($inhalt->aufwand); ?></td>
                    <td><?php echo sicherheit($inhalt->projektname); ?></td>
                    <td><?php echo sicherheit($inhalt->wahrscheinlichkeit); ?></td>
                    <td><?php echo sicherheit($inhalt->kunde); ?></td>
                    <td><?php echo sicherheit($inhalt->budget); ?></td>
                    <td><?php echo sicherheit($inhalt->projektID); ?></td>
                    <td><?php echo sicherheit($inhalt->dauer); ?></td>
                    <td><?php echo sicherheit($inhalt->archivierungsdatum); ?></td>
                    <td><?php echo sicherheit($inhalt->potenzial); ?></td>
                    <!--<td><a href = "?aktion=anzeigen&mitarbeiterID=<?php echo $inhalt->projektID; ?>" class="w3-btn w3-black">Anzeigen</a></td>-->
                    <td><a href = "?aktion=bearbeiten&projektID=<?php echo $inhalt->projektID; ?>" class="w3-btn w3-black">Bearbeiten</a></td>
                </tr>
            <?php
            }
}

if ( $modus_aendern == true and isset($_GET['projektID']) ) {
    
    $id_einlesen = (INT) $_GET['projektID'];
    if ($id_einlesen > 0)
    {   
        $dseinlesen = $db->prepare("SELECT * FROM projekt WHERE projektID=? ");
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
        }
    }
}

function sicherheit($inhalt='') {
    $inhalt = trim($inhalt);
    $inhalt = htmlentities($inhalt, ENT_QUOTES, "UTF-8");
    return($inhalt);
}
if ($modus_aendern == true){
    ?>
    <form class = "form-horizontal" action="einzelprojekt.php" method="post">
    
    
        <h3>Projekt  bearbeiten</h3>
        
        <label>
            <input type="hidden" name="projektID" id="projektID" value="<?php echo $projektID; ?>">
        </label><br>
        <label>Erstellungsdatum: <br>
            <input type="date" name="erstellungsdatum" id="erstellungsdatum" value="<?php echo $erstellungsdatum; ?>">
        </label><br>
        <label>Aufwand:<br>
            <input type="text" name="aufwand" id="aufwand" value="<?php echo $aufwand; ?>">
        </label><br>
        <label>Projektame: <br>
            <input type="text" name="projektname" id="projektname" value="<?php echo $projektname; ?>">       
        </label><br>
        <label>Wahrscheinlichkeit: <br>
            <input type="text" name="wahrscheinlichkeit" id="wahrscheinlichkeit" value="<?php echo $wahrscheinlichkeit; ?>">       
        </label><br>
        <label>Kunde: <br>
            <input type="text" name="kunde" id="kunde" value="<?php echo $kunde; ?>">       
        </label><br>
        <label>Budget: <br>
            <input type="text" name="budget" id="budget" value="<?php echo $budget; ?>">       
        </label><br>
        <label>Dauer: <br>
            <input type="text" name="dauer" id="dauer" value="<?php echo $dauer; ?>">       
        </label><br>
        <label>Archivierung: <br>
            <input type="date" name="archivierungsdatum" id="archivierungsdatum" value="<?php echo $archivierungsdatum; ?>">       
        </label><br>
        Potenzial:<br>
        <select name = "potenzial">
            <option value ="+">+</option>
           <option value ="++">++</option>
           <option value ="+++">+++</option>
           value="<?php echo $potenzial; ?>"
        </select><br> <br>
        <input type="hidden" name="aktion" value="speichern"><br>
        <a href = "?aktion=loeschen&projektID=<?php echo $inhalt->projektID; ?>" onclick="return confirm('Soll das Projekt wirklich gelöscht werden?')"  class="w3-btn w3-red">Löschen</a></td>
    
    
    <?php
} 

if ($modus_aendern == true)
{   
    echo '<input type="hidden" name="aktion" value="korrigieren">';
    echo '<input type="submit" class="w3-btn w3-black" value="Projekt ändern">';
    echo '</form>';
}
            ?>			
        </tbody>
    </table>
    </body>
</html>