<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  
    <link rel="stylesheet" href="/main.css">
<title>WI-Projekt</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php

// Was auf jeden Fall gemacht werden muss: Mitarbeiter ID kontrollieren
// Letzter Stand: Seit hinzufügen der Ändern-funktion läuft der Code zwar, aber die Änderung wid nur ausgelöst, nicht gespeichert
// Auf jeden Fall alles durchgehen, was mit korrigieren bzw. ändern zu tun hat
// Rest passt soweit und gibt keine Fehlermeldungen
// Suche muss eingefügt werdenß
//Passwortprüfung

require 'inc/db.php';


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
               header('Location: index.php?aktion=feedbackgespeichert');
            die();
            }
        }

    else {
        echo "Bitte geben sie alle nötigen Informationen an";
    }
}
}

function sicherheit($inhalt='') {
    $inhalt = trim($inhalt);
    $inhalt = htmlentities($inhalt, ENT_QUOTES, "UTF-8");
    return($inhalt);
}



?>
<h3>Neuen Mitarbeiter anlegen</h3>
<form class = "form-horizontal" action="benutzerverwaltungma.php" method="post">
    
    <label>
        <input type="hidden" name="mitarbeiterID" id="mitarbeiterID" value="">
    </label><br>
    <label>E-Mail: <br>
        <input type="text" name="email" id="email" value="">
    </label><br>
    <label>Passwort:<br>
        <input type="text" name="passwort" id="passwort" value="">
    </label><br>
    <label>Name: <br>
        <input type="text" name="name" id="name" value="">       
    </label><br>
    Rolle:<br>
    <select name = "rolle">
        <option value ="Mitarbeiter">Mitarbeiter</option>
        <option value ="Vertrieb">Vertrieb</option>
        <option value ="Management">Management</option>
        value=""
    </select><br> <br>
    <input type="submit" name="aktion" value="speichern">

</form>