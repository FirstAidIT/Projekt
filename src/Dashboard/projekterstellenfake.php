<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

<title>Projekt erstellen</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" type="text/css" href="css/projekterstellen.css">
</head>


<?php

include 'check_login.php';
include 'database.php'; 

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

<body>
<h3>Neues Projekt erstellen</h3>
<form action="" method="post">
    <label>Projektname: <br>
        <input type="text" name="projektname" id="projektname">
    </label><br>
    <label>Kunde: <br>
        <input type="text" name="kunde" id="kunde">
    </label><br>
    <label>Budget: <br>
        <input type="number" name="budget" id="budget" value=""> 
    </label><br>
	<label>Dauer: <br>
        <input type="number" name="dauer" id="dauer" value=""> 
    </label><br>
	<label>Aufwand: <br>
        <input type="number" name="aufwand" id="aufwand" value=""> 
    </label><br>
	<label>Wahrscheinlichkeit: <br>
        <input type="number" name="wahrscheinlichkeit" id="wahrscheinlichkeit" value=""> 
    </label><br>
	Potenzial:<br>
    <select name = "potenzial">
        <option value ="+">+</option>
        <option value ="++">++</option>
        <option value ="+++">+++</option>
        value=""
    </select><br>
	Mitarbeiter:<br>	
    <?php
    $sql = "SELECT name FROM person";
	foreach ($conn->query($sql) as $row) {
		echo "<input type=\"checkbox\">" . $row['person']. "";
    }
    ?> <br>
	Skills:<br>	
    <?php
    $sql = "SELECT skillname FROM skills";
	foreach ($conn->query($sql) as $row) {
		echo "<input type=\"checkbox\">" . $row['skillname']. "";
    }
    ?> <br>
    <input type="submit" name="aktion" onclick="return confirm('Soll das Projekt erstellt werden?')" value="speichern" class="w3-btn w3-green">
    <input type="submit" name="back" value="Zurück" class="w3-btn w3-black" href = "projekterstellenfake.php">

</form>
</body>
</html>

<?php

SESSION_START();

$_SESSION['check'] = "";

$_SESSION['angelegt'] = false;

$_SESSION['checkchange'] = "";

$_SESSION['checkaendern']= "";

$_SESSION['geaendert'] = false;

require 'db.php';
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
	$dauer = "";
    if (isset($_POST['dauer'])) {
        $dauer = trim($_POST['dauer']);
    }
	$aufwand = "";
    if (isset($_POST['aufwand'])) {
        $aufwand = trim($_POST['aufwand']);
    } 
	$wahrscheinlichkeit = "";
    if (isset($_POST['wahrscheinlichkeit'])) {
        $wahrscheinlichkeit = trim($_POST['wahrscheinlichkeit']);
    }
	$potenzial = "";
    if (isset($_POST['potenzial'])) {
        $potenzial = trim($_POST['potenzial']);
    }
	$projektID = "";
    if (isset($_POST['projektID'])) {
        $projektID = trim($_POST['projektID']);
    }
	$mitarbeiterID = "";
    if (isset($_POST['mitarbeiterID'])) {
        $mitarbeiterID = trim($_POST['mitarbeiterID']);	
    }
	$skillID = "";
    if (isset($_POST['skillID'])) {
        $skillID = trim($_POST['skillID']);	
    }
	
    $erstellungsdatum = date("Y-m-d H:i:s");
    if ( $projektname != '')
    {
        // speichern
        $einfuegen = $conn->prepare("
                INSERT INTO tester (projektname, kunde, budget, dauer, aufwand, wahrscheinlichkeit, potenzial, erstellungsdatum) 
                VALUES (?, ?, ?, ? , ?, ?, ?, NOW())
                ");
        $einfuegen->bind_param('ssiiiis', $projektname, $kunde, $budget, $dauer, $aufwand, $wahrscheinlichkeit, $potenzial);



		$einfuegen = $conn->prepare("
				INSERT INTO Arbeiten_an(projektID, mitarbeiterID)
				VALUES ('$projektID', '$mitarbeiterID')
				");

     
		$einfuegen = $conn->prepare("
				INSERT INTO braucht(projektID, skillID)
				VALUES ('$projektID','$mitarbeiterID')
				");

		
		
        if ($einfuegen->execute()) {
            header('Location: projekterstellenfake.php?aktion=feedbackgespeichert');
            die();
            echo "<h1>gespeichert</h1>";
        }
    }   
}
if (isset($_GET['aktion']) and $_GET['aktion']=='feedbackgespeichert') {
    echo '<p class="feedbackerfolg">Datensatz wurde gespeichert</p>';
}
