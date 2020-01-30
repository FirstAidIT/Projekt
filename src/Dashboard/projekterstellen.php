<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/main.css">
<title>WI-Projekt</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>


<?php
include 'check_login.php';
include 'database.php';



if (isset($_POST['aktion']) and $_POST['aktion']=='speichern') {
    $projetname = "";
    if (isset($_POST['projetname'])) {
        $projetname = trim($_POST['projetname']);
    }
    $aufwand = "";
    if (isset($_POST['aufwand'])) {
        $aufwand = trim($_POST['aufwand']);
    } 
    $wahrscheinlichkeit = "";
    if (isset($_POST['wahrscheinlichkeit'])) {
        $wahrscheinlichkeit = trim($_POST['wahrscheinlichkeit']);
    }
    $kunde = "";
    if (isset($_POST['kunde'])) {
        $kunde = trim($_POST['kunde']);
    } 
    $budget = "";
    if (isset($_POST['budget'])) {
        $budget = trim($_POST['budget']);
    }
    $dauer = "";
    if (isset($_POST['dauer'])) {
        $dauer = trim($_POST['dauer']);
    }
    $potenzial = "";
    if (isset($_POST['potenzial'])) {
        $potenzial = trim($_POST['potenzial']);
    }
// nicht sicher ob richtig
//    $erstellungsdatum = "";
//    if (isset($_POST['erstellungsdatum'])) {
//        $erstellungsdatum = trim($_POST['erstellungsdatum']);
//    } 

//    $archivierungsdatum = "";
//    if (isset($_POST['archivierungsdatum'])) {
//        $archivierungsdatum = trim($_POST['archivierungsdatum']);
//    } 
    
    if ( $projetname != '' AND $aufwand != '' AND $wahrscheinlichkeit != '' AND $kunde != ''  AND $budget != '' AND $dauer != '' AND $potenzial != '')
        {
        // nicht sicher, ob hier auch erstellungsdatum und archivierungsdatum  erstellt werden muss
            $einfuegen = $db->prepare("INSERT INTO projekt(projetname, aufwand, wahrscheinlichkeit, kunde, budget, dauer, potenzial ) VALUES (?,?,?,?,?,?,?)");
            $einfuegen->bindParam(1, $projetname, PDO::PARAM_STR);
            $einfuegen->bindParam(2, $aufwand, PDO::PARAM_INT);
            $einfuegen->bindParam(3, $wahrscheinlichkeit, PDO::PARAM_INT);
            $einfuegen->bindParam(4, $kunde, PDO::PARAM_STR);
            $einfuegen->bindParam(5, $budget, PDO::PARAM_INT);
            $einfuegen->bindParam(6, $dauer, PDO::PARAM_INT);
            $einfuegen->bindParam(7, $potenzial, PDO::PARAM_STR);
//            $einfuegen->bindParam(8, $erstellungsdatum, PDO::PARAM_STR);
//            $einfuegen->bindParam(9, $archivierungsdatum, PDO::PARAM_STR);
    
            if ($einfuegen->execute()) {
               header('Location: index.php?aktion=feedbackgespeichert');
            die();
            }
        }

    else {
        echo "Bitte geben sie alle nötigen Informationen an";
    }
}



function sicherheit($inhalt='') {
    $inhalt = trim($inhalt);
    $inhalt = htmlentities($inhalt, ENT_QUOTES, "UTF-8");
    return($inhalt);
}



?>

<body><nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="projekterstellen.php">Projekterstellung <span class="sr-only">(current)</span></a>
      </li>
	 
    </ul>

    <ul class="navbar-nav ml-auto">
    </li>
    <li class="nav-item ">
        <a class="fas fa-user fa-2x" href="projekterstellen.php" ></a>
    </li>
    </ul>
  </div>
</nav>

<h3>Neues Projekt erstellen</h3>
<form class = "form-horizontal" action="projekterstellen.php" method="post">
    
    <label>
        <input type="hidden" name="projektID" id="projektID" value="">
    </label><br>
    <label>Projektname: <br>
        <input type="text" name="projektname" id="projektname" value="">
    </label><br>
    <label>Kunde:<br>
        <input type="text" name="kunde" id="kunde" value="">
    </label><br>
    <label>Projektdauer(in Wochen):<br>
        <input type="number" name="dauer" id="dauer" value="">
    </label><br> 
    <label>Budget(in €): <br>
        <input type="number" name="budget" id="budget" value="">       
    </label><br>
	 <label>Aufwand(in h): <br>
        <input type="number" name="aufwand" id="aufwand" value="">       
    </label><br>
    Skills:<br> 
    <select name = "skills">
    <?php
   // <option value ="Skills">Skills</option> eigentlich eins weiteroben
   // vlt verbindung zur datenbank hier angebeben
       
        $sql = "SELECT * FROM skills ORDER BY skillname";
        foreach ($pdo->query($sql) as $row) {
            echo $row['skillname']." "."<br />";
            }
        ?>
    </select><br> <br>
    Mitarbeiter:<br>
    <select name = "mitarbeiter">

    <?php
   // <option value ="Mitarbeiter">Mitarbeiter</option> eigentlich eins weiteroben
   // vlt verbindung zur datenbank hier angebeben
   // name könnte problem machen
       
        $sql = "SELECT * FROM person ORDER BY name";
        foreach ($pdo->query($sql) as $row) {
            echo $row['name']." "."<br />";
            echo "Rolle: ".$row['rolle']."<br /><br />";
            }
        ?>
    </select><br> <br>

    <label>Erstellungsdatum: <br>
        <?php
		$datum = date("d.m.Y",$timestamp);
		echo $datum;
		?>    
		</label><br>
    
    
    <input type="submit" name="aktion" onclick="return confirm('Soll das Projekt erstellt werden?')" value="speichern" class="w3-btn w3-green">
    <input type="submit" name="back" value="Zurück" class="w3-btn w3-black" href = "projekterstellen.php">

</form>