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

if (isset($_POST['aktion']) and $_POST['aktion']=='korrigieren') {
    $upd_erstellungsdatum = "";
    if (isset($_POST['erstellungsdatum'])) {
        $upd_erstellungsdatum = (INT) trim($_POST['erstellungsdatum']);
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

    $hashed_password = password_hash($upd_passwort, PASSWORD_DEFAULT);

    
    if ($upd_erstellungsdatum != '' or $upd_aufwand != '')
    {
        // speichern
        $update = $db->prepare("UPDATE person SET erstellungsdatum =?, aufwand=?, projektname=?, wahrscheinlichkeit=? WHERE projektID=?");
        $update->execute([$upd_erstellungsdatum, $upd_aufwand, $upd_projektname, $upd_wahrscheinlichkeit, $upd_projektID]);
        if ($update->execute()) {
            echo '<p class="feedbackerfolg">Datensatz wurde geändert</p>';
            $modus_aendern = false;
        }
    }
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
                <th scope="col">erstellung</th>
                <th scope="col">aufwand</th>
                <th scope="col">projektname</th>
                <th scope="col">wahrscheinlichkeit</th>
                <th scope="col">kunde</th>
                <th scope="col">budget</th>
                <th scope="col">projektID</th>
                <th scope="col">dauer</th>
                <th scope="col">archivierung</th>
                <th scope="col">potenzial</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($daten as $inhalt) {
            ?>			
                <tr>
                    <td><?php echo $inhalt->erstellungsdatum; ?></td>
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
                    <td><a href = "?aktion=loeschen&mitarbeiterID=<?php echo $inhalt->projektID; ?>" class="w3-btn w3-red">Löschen</a></td>
                    <td><a href = "?aktion=bearbeiten&mitarbeiterID=<?php echo $inhalt->projektID; ?>" class="w3-btn w3-black">Bearbeiten</a></td>
                </tr>
            <?php
            }
}

if ( $modus_aendern == true and isset($_GET['projektID']) ) {
    
    $id_einlesen = (INT) $_GET['projektID'];
    ?>
    <?php
    if ($id_einlesen > 0)
    {   
        $dseinlesen = $db->prepare("SELECT projektID, erstellungsdatum, aufwand, projektname, wahrscheinlichkeit FROM projekt WHERE projektID=? ");
        $dseinlesen->execute([$id_einlesen]);
        $dseinlesen->execute();
        while ($row = $dseinlesen->fetch()) {
            $projektID = $row['projektID'];
            $erstellungsdatum = $row['erstellungsdatum'];
            $aufwand = $row['aufwand'];
            $projektname = $row['projektname'];
            $wahrscheinlichkeit = $row['wahrscheinlichkeit'];
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
        <label>erstellungsdatum: <br>
            <input type="text" name="erstellungsdatum" id="erstellungsdatum" value="<?php echo $erstellungsdatum; ?>">
        </label><br>
        <label>aufwand:<br>
            <input type="text" name="aufwand" id="aufwand" value="">
        </label><br>
        <label>projektame: <br>
            <input type="text" name="projektname" id="projektname" value="<?php echo $projektname; ?>">       
        </label><br>
        <label>wahrscheinlichkeit: <br>
            <input type="text" name="wahrscheinlichkeit" id="wahrscheinlichkeit" value="<?php echo $wahrscheinlichkeit; ?>">       
        </label><br>
        <input type="hidden" name="aktion" value="speichern">
    
    
    <?php
} 

if ($modus_aendern == true)
{   
    echo '<input type="hidden" name="aktion" value="korrigieren">';
    echo '<input type="submit" value="Projekt ändern">';
    echo '</form>';
}
            ?>			
        </tbody>
    </table>
    </body>
</html>