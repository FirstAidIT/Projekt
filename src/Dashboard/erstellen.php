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
	$skillan = "";
    if (isset($_POST['skillan'])) {
        $skillan = trim($_POST['skillan']);	
    }
	$mitarbeiteran = "";
    if (isset($_POST['mitarbeiteran'])) {
        $mitarbeiteran = trim($_POST['mitarbeiteran']);	
    }
	
    $erstellungsdatum = date("Y-m-d H:i:s");
    if ( $projektname != '')
    {
        // speichern
        $einfuegen = $conn->prepare("
                INSERT INTO projekt (projektname, kunde, budget, dauer, aufwand, wahrscheinlichkeit, potenzial, skillan, mitarbeiteran, erstellungsdatum) 
                VALUES (?, ?, ?, ? , ?, ?, ?, ?, ?, NOW())
                ");
        $einfuegen->bind_param('ssiiiisss', $projektname, $kunde, $budget, $dauer, $aufwand, $wahrscheinlichkeit, $potenzial, $skillan, $mitarbeiteran);
		

		
		
        if ($einfuegen->execute()) {
            header('Location: managerdashboardfake.php?aktion=feedbackgespeichert');
            die();
            echo "<h1>gespeichert</h1>";
        }
    }   
}
if (isset($_GET['aktion']) and $_GET['aktion']=='feedbackgespeichert') {
    echo '<p class="feedbackerfolg">Datensatz wurde gespeichert</p>';
}

?>
 
<?php   

function bereinigen($inhalt='') {
    $inhalt = trim($inhalt);
    $inhalt = htmlentities($inhalt, ENT_QUOTES, "UTF-8");
    return($inhalt);
}
?>
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
	<label>Mitarbeiter: <br>
        <input type="text" name="mitarbeiteran" id="mitarbeiteran">
    </label><br>
	<label>Skills: <br>
        <input type="text" name="skillan" id="skillan">
    </label><br>
    <br>
    <input type="submit" name="aktion" onclick="return confirm('Soll das Projekt erstellt werden?')" value="speichern" class="w3-btn w3-green">
    <input type="submit" name="back" value="Zurück" class="w3-btn w3-black" href = "managerdashboardfake.php">

</form>