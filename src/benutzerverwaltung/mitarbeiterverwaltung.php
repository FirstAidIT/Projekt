<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/main.css">
<title>Mitarbeiterverwaltung</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php



//require 'inc/db.php';

include 'check_login.php';
include 'database.php';

$erfolg = false;

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





    // Passwörter nur vergleichen und schreiben, wenn ein neues eingegeben wird


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

                
                if ($upd_email != '' or $upd_passwort != '' or $upd_name != '' or $upd_rolle != '')
                {
                    // speichern
                    $update = $db->prepare("UPDATE person SET email =?, passwort=?, name=?, rolle=? WHERE mitarbeiterID=?");
                    $update->execute([$upd_email, $hashed_password, $upd_name, $upd_rolle, $upd_id]);
                    if ($update->execute()) {
                        /*
                        ?>
                        <meta http-equiv="refresh" content="5; URL=mitarbeiterverwaltung.php"> 
                        <?php
                        */
                        echo '<p class="feedbackerfolg">Datensatz wurde geändert</p>';
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
            $update = $db->prepare("UPDATE person SET email =?, name=?, rolle=? WHERE mitarbeiterID=?");
            $update->execute([$upd_email, $upd_name, $upd_rolle, $upd_id]);
            if ($update->execute()) {
                echo '<p class="feedbackerfolg">Datensatz wurde geändert</p>';
                $erfolg = true;
            }
        }
    }
}

$dseinlesen = $db->prepare("SELECT mitarbeiterID, email, passwort, name, rolle FROM person WHERE email = 'andreas@kerscher.de' ");
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

<form class = "form-horizontal" style= "width:400;  margin:auto;" action="mitarbeiterverwaltung.php" method="post">


    <h3>Eigene Informationen bearbeiten</h3>
    
    <label>
        <input type="hidden" name="mitarbeiterID" id="mitarbeiterID" value="<?php echo $mitarbeiterID;?>">
    </label>
    <label>
        <input type="hidden" name="email" id="email" value="<?php echo $email;?>">
    </label><br>
    <label>Name:<br>
        <input type="text" name="name" class= "form-control" id="name" value="<?php echo $name; ?>">        
    </label><br>
    <label>Altes Passwort:<br>
        <input type="password" name="passwort" class= "form-control" id="passwort" value="">
    </label><br>
    <label>Neues Passwort:<br>
        <input type="password" name="passwortneu1" class= "form-control" id="passwortneu1" value="">
    </label><?php if (isset($_POST['aktion']) and $_POST['aktion']=='Übernehmen'){ if (!empty($passwortneu1)){ if (PassStrength($passwortneu1)<30){ echo '<span style="color:#FF0000">Bitte ein sicheres Passwort angeben!</span>';}}}?><br>
    <label>Neues Passwort wiederholen:<br>
        <input type="password" name="passwortneu2" class= "form-control" id="passwortneu2" value="">    
    </label><?php if (isset($_POST['aktion']) and $_POST['aktion']=='Übernehmen') {  if (!empty($passwortneu1)){if ($passwortneu1 != $passwortneu2 ){ if (PassStrength($passwortneu1)>=30){ echo '<span style="color:#FF0000">Die angegebenen Passwörter stimmen nicht überein!</span>';}}}}?><br>
    Rolle:<br>
    <select name = "rolle">
        <option value ="Mitarbeiter">Mitarbeiter</option>
        <option value ="Vertrieb">Vertrieb</option>
        <option value ="Management">Management</option>
        value="<?php echo $rolle; ?>"
    </select><br> <br>
    <input type="submit" onclick="return confirm('Änderungen wirklich übernehmen?')" class="btn btn-success" name = "aktion" value="Übernehmen">


</form>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>