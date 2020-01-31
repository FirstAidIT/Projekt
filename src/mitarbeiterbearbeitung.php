<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/main.css">
<title>Benutzerverwaltung Manager</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php

session_start();


include 'check_login.php';
include 'database.php';

if (isset($_GET['aktion']) and $_GET['aktion']=='loeschen') {
    if (isset($_GET['mitarbeiterID'])) {
        $mitarbeiterID =$_GET['mitarbeiterID'];
        if ($mitarbeiterID > 0)
        {
            $loeschen = $conn->prepare("DELETE FROM person WHERE mitarbeiterID=(?) LIMIT 1");
            $loeschen->bindParam(1, $mitarbeiterID, PDO::PARAM_STR);
            if ($loeschen->execute()) {
                header("Location: benutzerverwaltungma.php");
                echo "<p>Datensatz wurde gelöscht</p>";
            }
        }       
    }
}

if (isset($_POST['aktion']) and $_POST['aktion']=='Benutzer deaktivieren') {
    $modus_aendern = true;
    $mitarbeiterdeaktivieren = $_POST['mitarbeiterID'];

    $update = $conn->prepare("UPDATE person SET active = 0 WHERE mitarbeiterID=?");
    $update->execute([$mitarbeiterdeaktivieren]); 
    header("Location: mitarbeiterbearbeitung.php");
}

if (isset($_POST['aktion']) and $_POST['aktion']=='Übernehmen') {
    $nochfalsch=true;
    $modus_aendern = true;

    $emailalt = $_POST['emailalt'];
    $upd_id = "";
    if (isset($_POST['mitarbeiterID'])) {
        $upd_id = (INT) trim($_POST['mitarbeiterID']);
    }
    $upd_email = "";
    if (isset($_POST['email'])) {
        $upd_email = trim($_POST['email']);
    }
    $upd_passwort = "";
    if (isset($_POST['passwort'])) {
        $upd_passwort = trim($_POST['passwort']);
    }
    $upd_name = "";
    if (isset($_POST['name'])) {
        $upd_name = trim($_POST['name']);
    }
    $upd_rolle = "";
    if (isset($_POST['rolle'])) {
        $upd_rolle = trim($_POST['rolle']);
    }
    $upd_status = "";
    if (isset($_POST['active'])) {
        $upd_status = trim($_POST['active']);
    }


    $statement = $conn->prepare("SELECT* FROM person WHERE email = '$upd_email'");
    $statement->execute(array('Max')); 
    $anzahl_user = $statement->rowCount();




    if(check_email($upd_email) == false){
        echo "Bitte eine gültige E-Mail angeben";

    }

    else {
        if ($anzahl_user > 0 && $upd_email != $emailalt){
            echo ("E-Mail bereits vergeben");
        }

        else{
    $hashed_password = password_hash($upd_passwort, PASSWORD_DEFAULT);

    
    if ($upd_email != '' or $upd_passwort != '' or $upd_name != '' or $upd_rolle != '')
    {
        // speichern
        $update = $conn->prepare("UPDATE person SET email =?, passwort=?, name=?, rolle=? WHERE mitarbeiterID=?");
        $update->execute([$upd_email, $hashed_password, $upd_name, $upd_rolle, $upd_id]);
        if ($update->execute()) {
            header("Location: benutzerverwaltungma.php");
            echo '<p class="feedbackerfolg">Datensatz wurde geändert</p>';
        }
    }
    }
    }
}

$id_einlesen = $_SESSION['id'];

$dseinlesen = $conn->prepare("SELECT* FROM person where mitarbeiterID = ?");
$dseinlesen->execute([$id_einlesen]);
$dseinlesen->execute();
while ($row = $dseinlesen->fetch()) {
    $mitarbeiterID = $row['mitarbeiterID'];
    $email = $row['email'];
    $passwort = $row['passwort'];
    $name = $row['name'];
    $rolle = $row['rolle'];
    $active =$row['active'];

};
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




<div style = "width:400; margin:auto">
<form style= "width:400;  margin:auto;" class = "form-horizontal" action = "benutzerverwaltungma.php"  method="post">

<h3>Benutzer <?php echo $name ?> bearbeiten</h3>
<!--MitarbeiterID-->
<label>
    <input type="hidden" name="mitarbeiterID" id="mitarbeiterID" value="<?php echo $mitarbeiterID; ?>">
</label><br>
E-Mail:
<br>
<label>
    <input type="text" name="email" id="email" value="<?php echo $email; ?>">
</label> 

<label>
    <input type="hidden" name="emailalt" id="emailalt" value="<?php echo $email; ?>">
</label><br>
<label>Name: <br>
    <input type="text" name="name" id="name" value="<?php echo $name; ?>">       
</label><br>
<!--<label>Passwort:<br>
    <input type="password" name="passwort" id="passwort" value="">
</label><br>
<label>Passwort wiederholen:<br>
    <input type="password" name="passwortwdh" id="passwortwdh" value="">
</label><br>--> 
Rolle:<br>
<select name = "rolle">
    <option value='<?php echo $rolle?>' selected='selected'><?php echo $rolle?></option>
    <option value ="Mitarbeiter">Mitarbeiter</option>
    <option value ="Vertrieb">Vertrieb</option>
    <option value ="Management">Management</option>
</select><br> <br>


<?php

    $geaendert = $_SESSION['geaendert'];

    if ($geaendert == true){
        echo "Benutzer geaendert.";
    }

    $check = $_SESSION['checkaendern'];
    echo "<font color='#FF0000'> $check</font>"?><br><br>


    <input type="hidden" name="id" value="'. $id_einlesen .'"> 
    <input type="submit" name="aktion" value="Übernehmen" class = "btn btn-success">'
    <!--<input type="submit" onclick="return confirm('Änderungen wirklich übernehmen?')" class="btn btn-success" value="Änderungen speichern">-->
    <a href = "?aktion=loeschen&mitarbeiterID=<?php echo $mitarbeiterID; ?>" onclick="return confirm('Soll der Mitarbeiter wirklich gelöscht werden?')"  class="btn btn-danger">Löschen</a></td>
    <?php
    if ($active == 1){?>
    <input type="submit" name = "aktion" class="btn btn-warning" value="Benutzer deaktivieren">
    <?php
    }
    if ($active == 0){?>
        <input type="submit"  name = "aktion" class="btn btn-warning" value="Benutzer reaktivieren">
        <?php
    }

    ?>
    <br><br>
    <a href = "benutzerverwaltungma.php" class="btn btn-dark">Zurück zur Benutzerverwaltung</a></td>
    </form>
<?php
function sicherheit($inhalt='') {
    $inhalt = trim($inhalt);
    $inhalt = htmlentities($inhalt, ENT_QUOTES, "UTF-8");
    return($inhalt);
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

function check_email($email) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
}

?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
