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



/* Update 19.1.
Noch fehlend
-Suche nach einzelnen Mitarbeitern
-Passwortprüfung
-Email-Prüfung
-Sicherheitsprüfung zum löschen
*/

require 'inc/db.php';


if (isset($_GET['aktion']) and $_GET['aktion']=='loeschen') {
    if (isset($_GET['mitarbeiterID'])) {
        $mitarbeiterID =$_GET['mitarbeiterID'];
        if ($mitarbeiterID > 0)
        {
            $loeschen = $db->prepare("DELETE FROM person WHERE mitarbeiterID=(?) LIMIT 1");
            $loeschen->bindParam(1, $mitarbeiterID, PDO::PARAM_STR);
            if ($loeschen->execute()) {
                echo "<p>Datensatz wurde gelöscht</p>";
            }
        }       
    }
}

//Update eines bestehenden Users

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

    

    $hashed_password = password_hash($passwort, PASSWORD_DEFAULT);
    

    $statement = $db->prepare("SELECT* FROM person WHERE email = '$email'");
    $statement->execute(array('Max')); 
    $anzahl_user = $statement->rowCount();


    if ($anzahl_user > 0){
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

if (isset($_POST['aktion']) and $_POST['aktion']=='feedbackgespeichert') {
    echo '<p class="feedbackerfolg">Datensatz wurde gespeichert</p>';
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


    <table class = "table table-dark">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">E-Mail</th>
                <th scope="col">Passwort</th>
                <th scope="col">Name</th>
                <th scope="col">Rolle</th>
                <th scope="col">Bearbeiten</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($daten as $inhalt) {
            ?>			
                <tr>
                    <td><?php echo $inhalt->mitarbeiterID; ?></td>
                    <td><?php echo sicherheit($inhalt->email); ?></td>
                    <td><?php echo sicherheit($inhalt->passwort); ?></td>
                    <td><?php echo sicherheit($inhalt->name); ?></td>
                    <td><?php echo sicherheit($inhalt->rolle); ?></td>
                    <!--<td><a href = "?aktion=anzeigen&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" class="w3-btn w3-black">Anzeigen</a></td>-->
                    <td><a href = "?aktion=loeschen&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" onclick="return confirm('Soll der Mitarbeiter wirklich gelöscht werden?')"  class="w3-btn w3-red">Löschen</a></td>
                    <td><a href = "?aktion=bearbeiten&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" class="w3-btn w3-black">Bearbeiten</a></td>
                </tr>
            <?php
            }
            ?>			
        </tbody>
    </table>

    <br><br>

    <form method="get" action="mitarbeiterverwaltungma.php"> 
         <input type="submit" value="Neuen Benutzer anlegen">
    </form>
<?php	
}
}


//Einlesen der Daten
if ( $modus_aendern == true and isset($_GET['mitarbeiterID']) ) {
    
    $id_einlesen = (INT) $_GET['mitarbeiterID'];
    ?>
    <?php
    if ($id_einlesen > 0)
    {   
        $dseinlesen = $db->prepare("SELECT mitarbeiterID, email, passwort, name, rolle FROM person WHERE mitarbeiterID=? ");
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

if ($modus_aendern == true){
?>
<form class = "form-horizontal" action="benutzerverwaltungma.php" method="post">


    <h3>Benutzer <?php echo $name ?> bearbeiten</h3>
    
    <label>
        <input type="hidden" name="mitarbeiterID" id="mitarbeiterID" value="<?php echo $mitarbeiterID; ?>">
    </label><br>
    <label>E-Mail: <br>
        <input type="text" name="email" id="email" value="<?php echo $email; ?>">
    </label><br>
    <label>Passwort:<br>
        <input type="text" name="passwort" id="passwort" value="">
    </label><br>
    <label>Name: <br>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>">       
    </label><br>
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
    <input type="submit" onclick="return confirm('Änderungen wirklich übernehmen?')" value="Änderungen speichern">
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