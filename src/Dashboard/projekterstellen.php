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
</body>

<body>
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
    <select name = "potenzial">
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

</body>
</html>

<?php
include 'check_login.php';
include 'database.php'; 


 if($db->connect_error){
    echo 'keine Verbindung zur Datenbank';
 }

if(isset(§_Post['aktion'])){
     $projektname = $_POST['projektname'];
}
if(isset(§_Post['aktion'])){
     $aufwand = $_POST['aufwand'];
}
if(isset(§_Post['aktion'])){
     $wahrscheinlichkeit = $_POST['wahrscheinlichkeit'];         
}
if(isset(§_Post['aktion'])){
     $kunde = $_POST['kunde']; 
}     
if(isset(§_Post['aktion'])){
     $dauer = $_POST['dauer'];
}
if(isset(§_Post['aktion'])){
     $potenzial = $_POST['potenzial'];
}   
if(isset(§_Post['aktion'])){
      $erstellungsdatum = $_POST['erstellungsdatum'];
}                   
if(isset(§_Post['aktion'])){
     $projektID = $_POST['projektID'];    
}
if(isset(§_Post['aktion'])){
        $mitarbeiterID = $_POST['mitarbeiterID'];
}
if(isset(§_Post['aktion'])){
        $skillID = $_POST['skillID'];
}        

if ($projektname != '' and $kunde != '')
    {

    $speichern = $db->prepare("INSERT INTO projekt(projetname, aufwand, wahrscheinlichkeit, kunde, budget, dauer, potenzial, erstellungsdatum)
                               VALUES (?,?,?,?,?,?,?,NOW())");
    $speichern->bind_param('siisiis', $projektname, $aufwand, $wahrscheinlichkeit, $kunde, $dauer, $potenzial);                           
        
    $speichern = $db->prepare("INSERT INTO braucht(projektID, skillID)
                                VALUES(?,?)");
    $speichern->bind_param('ii', $projektID, skillID);
    $speichern = $db->prepare("INSERT INTO Arbeitet_an(projektID, mitarbeiterID)
                                VALUES(?,?)");
    $speichern->bind_param('ii', $projektID, mitarbeiterID);

   
    $speichern->execute();    
     } 
?>