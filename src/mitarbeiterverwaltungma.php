<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/main.css">
<title>WI-Projekt</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="css/mitarbeiterverwaltungma.css">
</head>
<body>
<?php


//require 'inc/db.php';

include 'check_login.php';
include 'database.php';

SESSION_START();




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
