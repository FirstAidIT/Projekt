<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/main.css">
<title>WI-Projekt</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php


//require 'inc/db.php';

include 'check_login.php';
include 'database.php';


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

    $passwortwdh = $POST['passwortwdh'];
    echo $passwortwdh;

    $hashed_password = password_hash($passwort, PASSWORD_DEFAULT);
    

    $statement = $db->prepare("SELECT* FROM person WHERE email = '$email'");
    $statement->execute(array('Max')); 
    $anzahl_user = $statement->rowCount();

    if(check_email($email) == false){
        echo "Bitte eine gültige E-Mail angeben";
    }

else{

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

function check_email($email) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
}

}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="benutzerverwaltungma.php">Benutzerverwaltung <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="einzelprojekt.php">Projekt bearbeiten</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
    </li>
    <li class="nav-item ">
        <a class="fas fa-user fa-2x" href="mitarbeiterverwaltung.php" ></a>
    </li>
    </ul>
  </div>
</nav>


<form action="benutzerverwaltungma.php" method="post">
    <h3>Neuen Mitarbeiter anlegen</h3>
    <label>
        <input type="hidden" name="mitarbeiterID" class= "form-control" id="mitarbeiterID" value="">
    </label><br>
    <label>E-Mail: <br>
        <input type="text" name="email" class= "form-control" id="email" value="">
    </label><br>
    <label>Passwort:<br>
        <input type="password" name="passwort" class= "form-control" id="passwort" value="">
    </label><br>
    <label>Passwort wiederholen:<br>
        <input type="password" name="passwortwdh" class= "form-control" id="passwortwdh" value="">
    </label><br> 
    <label>Name: <br>
        <input type="text" name="name" class= "form-control" id="name" value="">       
    </label><br>
    Rolle:<br>
    <select name = "rolle">
        <option value ="Mitarbeiter">Mitarbeiter</option>
        <option value ="Vertrieb">Vertrieb</option>
        <option value ="Management">Management</option>
        value=""
    </select><br> <br>
    <input type="submit" name="aktion" onclick="return confirm('Soll der Mitarbeiter wirklich angelegt werden?')" value="speichern" class="btn btn-success">
    <!--<button type="button" class="btn btn-success">Anlegen</button>-->
    <input type="hidden" name="back" value="Zurück" class="w3-btn w3-black" href = "benutzerverwaltungma.php">
    <!--<button type="button" class="btn btn-primary">Zurück</button>-->
</form>
