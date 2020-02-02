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
<form class = "form-horizontal" action="projekterstellen.php" method="post">
    <label>Projektname:  <br>
        <input type="text" name="projektname" id="projektname">
    </label><br>
    <label>Kunde: <br>
        <input type="text" name="kunde" id="kunde">
    </label>	<br>
    <label>Budget: <br>
        <input type="number" name="budget" id="budget" value=""> 
    </label><br>
	<label>Aufwand: <br>
        <input type="number" name="aufwand" id="aufwand" value=""> 
    </label><br>
	<label>Dauer: <br>
        <input type="number" name="dauer" id="dauer" value=""> 
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
		echo "<input type=\"checkbox\">" .$row['name']. "";
    }
    ?>
    <br>
	Skills:<br>	
    <?php
    $sql = "SELECT skillname FROM skills";
	foreach ($conn->query($sql) as $row) {
		echo "<input type=\"checkbox\">" .$row['skillname']. "";
    }
    ?>
<br>

    <input type="submit" name="aktion" onclick="return confirm('Soll das Projekt erstellt werden?')" value="speichern" class="w3-btn w3-green">
    <input type="submit" name="back" value="Zurück" class="w3-btn w3-black" href = "managerdashboard.php">


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

    

    $statement = $conn->prepare("SELECT* FROM projekt WHERE projektname = '$projektname'");
    $statement->execute(array('Max')); 
    $anzahl_projektname = $statement->rowCount();

    if ( $projektname == '')
        {
        $_SESSION['check'] = "Bitte alle nötigen Infos angeben";
        header("Location: projekterstellen.php");

        }
       
        else {
            if ($anzahl_projektname > 0){
                $_SESSION['check'] = "Projektname bereits vergeben";
                header("Location: projekterstellen.php");
            }
                    else{
                
                        // speichern
                        $einfuegen = $conn->prepare("INSERT INTO projekt(projetname, aufwand, wahrscheinlichkeit, kunde, budget, dauer, potenzial, erstellungsdatum VALUES (?,?,?,?,?,?,?,time)");
                        $einfuegen->bindParam(1, $projektname, PDO::PARAM_STR);
                        $einfuegen->bindParam(2, $aufwand, PDO::PARAM_INT);
                        $einfuegen->bindParam(3, $wahrscheinlichkeit, PDO::PARAM_INT);
                        $einfuegen->bindParam(4, $kunde, PDO::PARAM_INT);
                        $einfuegen->bindParam(5, $budget, PDO::PARAM_INT);
                        $einfuegen->bindParam(6, $dauer, PDO::PARAM_INT);
                        $einfuegen->bindParam(7, $potenzial, PDO::PARAM_STR);
                        $einfuegen->bindParam(8, $erstellungsdatum, PDO::PARAM_STR);
                
                        $einfuegen = $conn->prepare("INSERT INTO braucht VALUES(?,?)");
                        $einfuegen->bindParam(1, $projektID, PDO::PARAM_INT);
                        $einfuegen->bindParam(2, $skillID, PDO::PARAM_INT);

                        $einfuegen = $conn->prepare("INSERT INTO Arbeiten_an VALUES(?,?)");
                        $einfuegen->bindParam(1, $projektID, PDO::PARAM_INT);
                        $einfuegen->bindParam(2, $mitarbeiterID, PDO::PARAM_INT);
  

                        if ($einfuegen->execute()) {
                        //header('Location: benutzerverwaltungma.php?aktion=feedbackgespeichert');
                        $_SESSION['angelegt'] = true;
                        header("Location: projekterstellen.php");  
                        //die();
                        }
                    }
                }
               
