<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  
    <link rel="stylesheet" href="/main.css">
<title>Benutzerverwaltung Manager</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php



/* Update 20.1.
Noch fehlend
-Suche nach einzelnen Mitarbeitern
*/

require 'inc/db.php';

//User löschen
if (isset($_GET['aktion']) and $_GET['aktion']=='loeschen') {
    if (isset($_GET['mitarbeiterID'])) {
        $mitarbeiterID =$_GET['mitarbeiterID'];
        if ($mitarbeiterID > 0)
        {
            $loeschen = $db->prepare("DELETE FROM person WHERE mitarbeiterID=(?) LIMIT 1");
            $loeschen->bindParam(1, $mitarbeiterID, PDO::PARAM_STR);
            if ($loeschen->execute()) {
                ?>
                <meta http-equiv="refresh" content="5; URL=benutzerverwaltungma.php"> 
                <?php
                echo "<p>Datensatz wurde gelöscht</p>";
            }
        }       
    }
}

//Bestehenden User ändern
if (isset($_POST['aktion']) and $_POST['aktion']=='korrigieren') {
    $upd_id = "";
    if (isset($_POST['mitarbeiterID'])) {
        $upd_id = (INT) trim($_POST['mitarbeiterID']);
    }
    $upd_email = "";
    if (isset($_POST['email'])) {
        $upd_email = trim($_POST['email']);
    }
    $upd_passwort = "";
    if (isset($_POST['passwort'])) {
        $upd_passwort = trim($_POST['passwort']);
    }
    $upd_name = "";
    if (isset($_POST['name'])) {
        $upd_name = trim($_POST['name']);
    }
    $upd_rolle = "";
    if (isset($_POST['rolle'])) {
        $upd_rolle = trim($_POST['rolle']);
    }

    $hashed_password = password_hash($upd_passwort, PASSWORD_DEFAULT);

    
    if ($upd_email != '' or $upd_passwort != '' or $upd_name != '' or $upd_rolle != '')
    {
        // speichern
        $update = $db->prepare("UPDATE person SET email =?, passwort=?, name=?, rolle=? WHERE mitarbeiterID=?");
        $update->execute([$upd_email, $hashed_password, $upd_name, $upd_rolle, $upd_id]);
        if ($update->execute()) {
            ?>
            <meta http-equiv="refresh" content="5; URL=benutzerverwaltungma.php"> 
            <?php
            echo '<p class="feedbackerfolg">Datensatz wurde geändert</p>';
            $modus_aendern = false;
        }
    }
}

//Anlegen eines neuen Users

if (isset($_POST['aktion']) and $_POST['aktion']=='speichern') {
    $email = "";
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
    }
    $passwort = "";
    if (isset($_POST['passwort'])) {
        $passwort = trim($_POST['passwort']);
    }
    $name = "";
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
    }
    $rolle = "";
    if (isset($_POST['rolle'])) {
        $rolle = trim($_POST['rolle']);
    }


    $passwortwdh = $_POST['passwortwdh'];



    $hashed_password = password_hash($passwort, PASSWORD_DEFAULT);
    

    $statement = $db->prepare("SELECT* FROM person WHERE email = '$email'");
    $statement->execute(array('Max')); 
    $anzahl_user = $statement->rowCount();

    if ($passwort!=$passwortwdh){
        ?>
        <meta http-equiv="refresh" content="5; URL=mitarbeiterverwaltungma.php"> 
        <?php
        echo "Passwörter stimmen nicht überein";
    }
    else{

    if (PassStrength($passwort) < 30){
        ?>
        <meta http-equiv="refresh" content="5; URL=mitarbeiterverwaltungma.php"> 
        <?php
        echo "Bitte ein sicheres Passwort angeben";  
    }

    else {

    if(check_email($email) == false){
        ?>
        <meta http-equiv="refresh" content="5; URL=mitarbeiterverwaltungma.php"> 
        <?php
        echo "Bitte eine gültige E-Mail angeben";
    }

    else {
    if ($anzahl_user > 0){
        ?>
        <meta http-equiv="refresh" content="5; URL=mitarbeiterverwaltungma.php"> 
        <?php
        echo ("E-Mail bereits vergeben");
    }
    
    else {

        if ( $email != '' AND $passwort != '' AND $name != '' )
        {
        // speichern
            $einfuegen = $db->prepare("INSERT INTO person(email, passwort, name, rolle) VALUES (?,?,?,?)");
            $einfuegen->bindParam(1, $email, PDO::PARAM_STR);
            $einfuegen->bindParam(2, $hashed_password, PDO::PARAM_STR);
            $einfuegen->bindParam(3, $name, PDO::PARAM_STR);
            $einfuegen->bindParam(4, $rolle, PDO::PARAM_STR);
    
            if ($einfuegen->execute()) {
               header('Location: benutzerverwaltungma.php?aktion=feedbackgespeichert');
            die();
            }
        }

    else {
        echo "Bitte geben sie alle nötigen Informationen an";
    }
}
}
}
}
if (isset($_POST['aktion']) and $_POST['aktion']=='feedbackgespeichert') {
    ?>
    <meta http-equiv="refresh" content="5; URL=benutzerverwaltungma.php"> 
    <?php
    echo '<p class="feedbackerfolg">Datensatz wurde gespeichert</p>';
}
}
$modus_aendern = false;
if (isset($_GET['aktion']) and $_GET['aktion']=='bearbeiten') {
    $modus_aendern = true;
}
if ($modus_aendern != true) 
{

$daten = array();
if ($erg = $db->query("SELECT * FROM person")) {
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


 <form action="" method="get">
    suchen nach:
    <input type="hidden" name="aktion" value="suchen">
    <input type="text" name="suchbegriff" id="suchbegriff">
    <input type="submit" value="suchen">
 </form>

 <?php

 // Nach einem Mitarbeiter suchen
 // Die IDs der Mitarbeiter stimmen überein, die Tabellenansicht funktioniert aber noch nicht
 if ($modus_aendern == false ) {
    $daten = array();
    if ( isset($_GET['suchbegriff']) and trim ($_GET['suchbegriff']) != '' )
    {
        $suchbegriff = trim ($_GET['suchbegriff']);
        echo "<p>Gesucht wird nach: <b>$suchbegriff</b></p>"; 
        $suche_nach = "%{$suchbegriff}%";
        $suche = $db->prepare("SELECT mitarbeiterID, email, passwort, name, rolle 
                     FROM person
                     WHERE name LIKE ? OR email LIKE ?");
        $suche->bindParam(1, $suche_nach, PDO::PARAM_STR);
        $suche->bindParam(2, $suche_nach, PDO::PARAM_STR);
        $suche->execute();
        while ($row = $suche->fetch()) {
            $mitarbeiterID = $row['mitarbeiterID'];
            $email = $row['email'];
            $passwort = $row['passwort'];
            $name = $row['name'];
            $rolle = $row['rolle'];
            //Mitarbeiter ID wird immer richtig ausgegeben
            echo $mitarbeiterID;
        }
        /*while ($suche->fetch()) {
            $daten[] = (object) array($mitarbeiterID = $['mitarbeiterID'], 
                              'passwort'=> $passwort,
                              'email'   => $email, 
                              'name'  => $name, 
                              'rolle' => $rolle);
        }*/
        $suche = null;
        $mitarbeiterID       = '';
        $email   = '';
        $name  = '';
        $rolle = '';     
    }
    else
    {
        if ($erg = $db->query("SELECT *  FROM person ORDER BY name ASC")) {
            if ($erg->rowCount()) {
                while ($datensatz = $erg->fetchObject()) {
                    $daten[] = $datensatz;
                }
            }
        }
    }

?>
    <table class = "table table-dark">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <!--<th scope="col">ID</th>-->
                <th scope="col">E-Mail</th>
                <th scope="col">Rolle</th>
                <th scope="col">Bearbeiten</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($daten as $inhalt) {
            ?>			
                <tr>
                    <td><?php echo sicherheit($inhalt->name); ?></td>
                    <!--<td><?php echo $inhalt->mitarbeiterID; ?></td>-->
                    <td><?php echo sicherheit($inhalt->email); ?></td>
                    <td><?php echo sicherheit($inhalt->rolle); ?></td>
                    <!--<td><a href = "?aktion=anzeigen&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" class="w3-btn w3-black">Anzeigen</a></td>-->
                    <!--<td><a href = "?aktion=loeschen&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" onclick="return confirm('Soll der Mitarbeiter wirklich gelöscht werden?')"  class="w3-btn w3-red">Löschen</a></td>-->
                    <td><a href = "?aktion=bearbeiten&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" class="w3-btn w3-black">Bearbeiten</a></td>
                </tr>
            <?php
            }
            ?>			
        </tbody>
    </table>

    <br><br>

    <form method="get" action="mitarbeiterverwaltungma.php"> 
         <input type="submit" value="Neuen Benutzer anlegen" class="w3-btn w3-blue">
    </form>
<?php	

}
}
}
//Einlesen der Daten 
if ( $modus_aendern == true and isset($_GET['mitarbeiterID']) ) {
    
    $id_einlesen = (INT) $_GET['mitarbeiterID'];
    if ($id_einlesen > 0)
    {   
        $dseinlesen = $db->prepare("SELECT mitarbeiterID, email, passwort, name, rolle FROM person WHERE mitarbeiterID=? ORDER BY name ASC");
        $dseinlesen->execute([$id_einlesen]);
        $dseinlesen->execute();
        while ($row = $dseinlesen->fetch()) {
            $mitarbeiterID = $row['mitarbeiterID'];
            $email = $row['email'];
            $passwort = $row['passwort'];
            $name = $row['name'];
            $rolle = $row['rolle'];
        }
    }
}

function sicherheit($inhalt='') {
    $inhalt = trim($inhalt);
    $inhalt = htmlentities($inhalt, ENT_QUOTES, "UTF-8");
    return($inhalt);
}

function check_email($email) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
}

//Vorgefertigte PHP-Passwortfunktion

function PassStrength($Password) {
    // length check
    $numCount = 0;
    // initial strength = len^2/6
    $W = (strlen($Password) * strlen($Password)) / 6;
    if (is_numeric(substr($Password, 0, 1))) {
        $numCount + 1; // note first character is numeric
    }
    for ($i=1; $i<strlen($Password); $i++) {
        // if previous char was another one this is good, otherwise bad
        $t = substr($Password, $i, 1); // this
        $p = substr($Password, $i-1, 1); // previous
        if ($t != $p) {
            $W = $W + 2;
        } else {
            $W = $W - 1;
        }
        // check, if previous char was other case the current (good)
        $upper =  ($t == strtoupper($t));
        $lower =  ($t == strtolower($t));
        $pupper = ($p == strtoupper($p));
        $plower = ($p == strtolower($p));

        // good if previous case is different than current
        if ($upper != $pupper || $lower != $plower) {
            $W = $W + 2;
        }

        // check if value is used multiple times
        $occurences = explode($t, $Password);
        if (count($occurences) > 3) {
            $W = $W - 2;
        }

        // count number of numeric characters
        if (is_numeric($t)) {
            $numCount = $numCount + 1;
        }
    }

    // extra points if number of numeric characters is between 20 and 70 percent
    if ($numCount > strlen($Password) * 0.2 && $numCount < strlen($Password) * 0.7) {
        $W = $W + 5;
    }

    // not good if password is more than 70% numbers
    if ($numCount > strlen($Password) * 0.7) {
        $W = $W - 5;
    }

    // no negative results
    if ($W < 0) { $W = 0; }

    // return rounded result
    return round($W);
}


if ($modus_aendern == true){
?>
<form class = "form-horizontal" action="benutzerverwaltungma.php" method="post">


    <h3>Benutzer <?php echo $name ?> bearbeiten</h3>
    <!--MitarbeiterID-->
    <label>
        <input type="hidden" name="mitarbeiterID" id="mitarbeiterID" value="<?php echo $mitarbeiterID; ?>">
    </label>
    <!--Mail-->
    <label>
        <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
    </label><br>
    <label>Name: <br>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>">       
    </label><br>
    <!--<label>Passwort:<br>
        <input type="password" name="passwort" id="passwort" value="">
    </label><br>
    <label>Passwort wiederholen:<br>
        <input type="password" name="passwortwdh" id="passwortwdh" value="">
    </label><br>--> 
    Rolle:<br>
    <select name = "rolle">
        <option value ="Mitarbeiter">Mitarbeiter</option>
        <option value ="Vertrieb">Vertrieb</option>
        <option value ="Management">Management</option>
        value="<?php echo $rolle; ?>"
    </select><br> <br>
    <input type="hidden" name="aktion" value="speichern">


<?php

}
//Hier muss noch geupdated werden
/*if ($modus_aendern != true) {
    echo '<input type="hidden" name="aktion" value="speichern">';
    echo '<input type="submit" value="Benutzer anlegen">';
    echo '</form>';
}*/
if ($modus_aendern == true)
{
    echo '<input type="hidden" name="id" value="'. $id_einlesen .'">';   
    echo '<input type="hidden" name="aktion" value="korrigieren">';?>
    <input type="submit" onclick="return confirm('Änderungen wirklich übernehmen?')" class="w3-btn w3-green" value="Änderungen speichern">
    <a href = "?aktion=loeschen&mitarbeiterID=<?php echo $mitarbeiterID; ?>" onclick="return confirm('Soll der Mitarbeiter wirklich gelöscht werden?')"  class="w3-btn w3-red">Löschen</a></td>
    <?php
    echo '</form>';
}
?> 
 
</form>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>