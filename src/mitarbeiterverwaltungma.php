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


require 'inc/db.php';
SESSION_START();

//include 'check_login.php';
//include 'database.php';


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
    </select><br> <br>
    <?php $check = $_SESSION['check'];
    $angelegt = $_SESSION['angelegt'];
    
    if ($angelegt == true){
        echo "Benutzer angelegt.";
        ?><br><br><input type="submit" name="back" value="Zurück" class="btn btn-dark" href = "benutzerverwaltungma.php"><?php
    }
    echo "<font color='#FF0000'> $check</font>"?><br>
    <br><br>
    <?php if ($angelegt == false){?>
    <input type="submit" name="aktion" value="speichern" class="btn btn-success"><?php
    }?>



</form>
