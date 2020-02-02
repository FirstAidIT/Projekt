<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<title>Mitarbeiterverwaltung</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="css/mitarbeiterverwaltung.css">


</head>
<body>
<?php

$erfolg = false;

//require 'inc/db.php';

include 'check_login.php';
include 'database.php';

session_start();


if (isset($_POST['aktion']) and $_POST['aktion']=='Übernehmen') {



    $upd_id = "";
    if (isset($_POST['mitarbeiterID'])) {
        $upd_id = (INT) trim($_POST['mitarbeiterID']);
    }
    $upd_email = "";
    if (isset($_POST['email'])) {
        $upd_email = trim($_POST['email']);
    }
    $upd_passwort = "";
    if (isset($_POST['passwortneu1'])) {
        $upd_passwort = trim($_POST['passwortneu1']);
    }
    $upd_name = "";
    if (isset($_POST['name'])) {
        $upd_name = trim($_POST['name']);
    }
    $upd_rolle = "";
    if (isset($_POST['rolle'])) {
        $upd_rolle = trim($_POST['rolle']);
    }

    $passwortneu1 = $_POST ['passwortneu1'];
    $passwortneu2 = $_POST ['passwortneu2'];




        if (!empty($passwortneu1)){


            if(PassStrength($passwortneu1)<30){
                //echo "Bitte ein sicheres Passwort wählen";
            }

            else{

                if ($passwortneu1!=$passwortneu2){
                   // echo '<p>Die Passwörter stimmen nicht überein</p>';
                }

                else {
                $hashed_password = password_hash($upd_passwort, PASSWORD_DEFAULT);

                
                if ($upd_email != '' or $upd_passwort != '' or $upd_name != '' or $upd_rolle != '' && passCheck($upd_passwort, $passwortalt))
                {
                    // speichern
                    $update = $conn->prepare("UPDATE person SET email =?, passwort=?, name=?, rolle=? WHERE mitarbeiterID=?");
                    $update->execute([$upd_email, $hashed_password, $upd_name, $upd_rolle, $upd_id]);
                    if ($update->execute()) {
                        //header("Location: mitarbeiterverwaltung.php");
                        $erfolg = true;
                    }
                }
            }
            }
    }
    else{
        if ($upd_email != ''or $upd_name != '' or $upd_rolle != '')
        {
            // speichern
            $update = $conn->prepare("UPDATE person SET email =?, name=?, rolle=? WHERE mitarbeiterID=?");
            $update->execute([$upd_email, $upd_name, $upd_rolle, $upd_id]);
            if ($update->execute()) {
               
                $erfolg = true;
            }
        }
    }
}

$id = $_SESSION['userid'];
$dseinlesen = $conn->prepare("SELECT mitarbeiterID, email, passwort, name, rolle FROM person WHERE mitarbeiterID = '$id'");
        $dseinlesen->execute();
        while ($row = $dseinlesen->fetch()) {
            $mitarbeiterID = $row['mitarbeiterID'];
            $email = $row['email'];
            $passwort = $row['passwort'];
            $name = $row['name'];
            $rolle = $row['rolle'];
        }

function PassStrength($Password) {
    // length check
    $numCount = 0;
    // initial strength = len^2/6
    $W = (strlen($Password) * strlen($Password)) / 6;
    if (is_numeric(substr($Password, 0, 1))) {
        $numCount + 1; // note first character is numeric
    }
    for ($i=1; $i<strlen($Password); $i++) {
        // if previous char was another one this is good, otherwise bad
        $t = substr($Password, $i, 1); // this
        $p = substr($Password, $i-1, 1); // previous
        if ($t != $p) {
            $W = $W + 2;
        } else {
            $W = $W - 1;
        }
        // check, if previous char was other case the current (good)
        $upper =  ($t == strtoupper($t));
        $lower =  ($t == strtolower($t));
        $pupper = ($p == strtoupper($p));
        $plower = ($p == strtolower($p));

        // good if previous case is different than current
        if ($upper != $pupper || $lower != $plower) {
            $W = $W + 2;
        }

        // check if value is used multiple times
        $occurences = explode($t, $Password);
        if (count($occurences) > 3) {
            $W = $W - 2;
        }

        // count number of numeric characters
        if (is_numeric($t)) {
            $numCount = $numCount + 1;
        }
    }

    // extra points if number of numeric characters is between 20 and 70 percent
    if ($numCount > strlen($Password) * 0.2 && $numCount < strlen($Password) * 0.7) {
        $W = $W + 5;
    }

    // not good if password is more than 70% numbers
    if ($numCount > strlen($Password) * 0.7) {
        $W = $W - 5;
    }

    // no negative results
    if ($W < 0) { $W = 0; }

    // return rounded result
    return round($W);
}


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

<form class = "form-horizontal" style= "width:400;  margin:auto;" action="mitarbeiterverwaltung.php" method="post">
    

    <h3>Eigene Informationen bearbeiten</h3>
    
    <label>
        <input type="hidden" name="mitarbeiterID" id="mitarbeiterID" value="<?php echo $mitarbeiterID;?>">
    </label> <br>
    <label>
        <input type="hidden" name="email" id="email" value="<?php echo $email;?>">
    </label><br>
    <label>Name:<br>
        <input type="text" name="name" class= "form-control" id="name" value="<?php echo $name; ?>">        
    </label><br>
    <label>Neues Passwort:<br>
        <input type="password" name="passwortneu1" class= "form-control" id="passwortneu1" value="">
    </label><br>
    <label>Neues Passwort wiederholen:<br>
        <input type="password" name="passwortneu2" class= "form-control" id="passwortneu2" value="">    
    </label><br>
    <label>Rolle:<br>
    <input type = "text" class= "form-control" name = "rolle" value="<?php echo $rolle; ?>" readonly><br>
    </label>
    <?php $check = "";?>
    <?php   if (isset($_POST['aktion']) and $_POST['aktion']=='Übernehmen'){ 
                if (!empty($passwortneu1)){ 
                    if (PassStrength($passwortneu1)<30){
                        $check = "Bitte geben Sie ein sicheres Passwort an.";
                        $erfolg = false;
                    }
                }
            }

       if (isset($_POST['aktion']) and $_POST['aktion']=='Übernehmen') {  
                if (!empty($passwortneu1)){
                    if ($passwortneu1 != $passwortneu2 ){ 
                        if (PassStrength($passwortneu1)>=30){
                             $check = "Die angegebenen Passwörter stimmen nicht überein.";
                             $erfolg = false;
                            }
                    }
                }
            }

            if ($erfolg == true){
                echo "Die Daten wurden geändert.";
            }
    ?><br>

    <?php echo "<font color='#FF0000'> $check</font>"; ?><br><br>
            
    <input type="submit"  class="btn btn-success" name = "aktion" value="Übernehmen">
    <br><br>
    <a href = "benutzerverwaltungma.php" class="btn btn-dark">Zurück zur Benutzerverwaltung</a>
      

</form>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>