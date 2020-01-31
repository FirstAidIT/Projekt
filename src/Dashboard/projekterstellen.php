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
    $projektname = "";
    if (isset($_POST['projektname'])) {
        $projektname = trim($_POST['projektname']);
    }
    $kunde = "";
    if (isset($_POST['kunde'])) {
        $kunde = trim($_POST['kunde']);
    }
    $budget = "";
    if (isset($_POST['budget'])) {
        $budget = trim($_POST['budget']);
    }
	$aufwand = "";
    if (isset($_POST['aufwand'])) {
        $aufwand = trim($_POST['aufwand']);
    }
	$dauer = "";
    if (isset($_POST['dauer'])) {
        $dauer = trim($_POST['dauer']);
    }
	$wahrscheinlichkeit = "";
    if (isset($_POST['wahrscheinlichkeit'])) {
        $wahrscheinlichkeit = trim($_POST['wahrscheinlichkeit']);
    }
	$potenzial = "";
    if (isset($_POST['potenzial'])) {
        $potenzial = trim($_POST['potenzial']);
    }
	$skills = "";
    if (isset($_POST['skills'])) {
        $skills = trim($_POST['skills']);
    }
	$mitarbeiter = "";
    if (isset($_POST['mitarbeiter'])) {
        $mitarbeiter = trim($_POST['mitarbeiter']);
    }
	$erstellungsdatum = "";
    if (isset($_POST['erstellungsdatum'])) {
        $restellungsdatum = trim($_POST['restellungsdatum']);
    }
   
    if ( $projektname != '' or $kunde != '' or $budget != '' )
    {
        // speichern
        $einfuegen = $db->prepare("
                INSERT INTO tester (projektname, kunde, budget, aufwand, dauer, wahrscheinlichkeit, potenzial, erstellungsdatum) 
                VALUES (?, ?, ?, ?, ?, ?, ?, date)
                ");
        $einfuegen->bind_param('ssiiiiss', $projektname, $kunde, $budget, $aufwand, $dauer, $wahrscheinlichkeit, $potenzial, erstellungsdatum);
        if ($einfuegen->execute()) {
            header('Location: index.php?aktion=feedbackgespeichert');
            die();
            echo "<h1>gespeichert</h1>";
        }
    }  
}
if (isset($_GET['aktion']) and $_GET['aktion']=='feedbackgespeichert') {
    echo '<p class="feedbackerfolg">Datensatz wurde gespeichert</p>';
}
$daten = array();
if ($erg = $db->query("SELECT * FROM tester")) {
    if ($erg->num_rows) {
        while($datensatz = $erg->fetch_object()) {
            $daten[] = $datensatz;
        }
        $erg->free();
    }   
}
if (!count($daten)) {
    echo "<p>Es liegen keine Daten vor :(</p>";
} else {
?>
    
<?php   
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
    <label>projektname:  <br>
        <input type="text" name="projektname" id="projektname">
    </label><br>
    <label>kunde: <br>
        <input type="text" name="kunde" id="kunde">
    </label>	<br>
    <label>budget: <br>
        <input type="number" name="budget" id="budget" value=""> 
    </label><br>
	<label>aufwand: <br>
        <input type="number" name="aufwand" id="aufwand" value=""> 
    </label><br>
	<label>dauer: <br>
        <input type="number" name="dauer" id="dauer" value=""> 
    </label><br>
	 <label>wahrscheinlichkeit: <br>
        <input type="number" name="wahrscheinlichkeit" id="wahrscheinlichkeit" value="">       
    </label><br>
	 potenzial:<br>
    <select name = "potenial">
        <option value ="+">+</option>
        <option value ="++">++</option>
        <option value ="+++">+++</option>
        value=""
    </select><br> 	
	Mitarbeiter:<br>	
  <?php 
	$sql = "SELECT name FROM person WHERE rolle = Mitarbeiter ORDER by name";
	foreach ($db->query($sql) as $row) {
		echo "<input type=\"checkbox\">" .$row['name']. " ";
	}
    ?><br>
	Skills:<br>	
  <?php 
	$sql = "SELECT skillname FROM skills ORDER by skillID";
	foreach ($db->query($sql) as $row) {
		echo "<input type=\"checkbox\">" .$row['skillname']. " ";
	}
    ?>


</br>

    <input type="submit" name="aktion" onclick="return confirm('Soll das Projekt erstellt werden?')" value="speichern" class="w3-btn w3-green">
    <input type="submit" name="back" value="Zurück" class="w3-btn w3-black" href = "managerdashboard.php">


</form>


// Wie speicher ich welches Projekt welche skills benötigt
//wie speicher ich welche mitarbeiter an welchem projekt arbeiten