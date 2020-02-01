<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/main.css">
<title>Benutzerverwaltung Manager</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php

session_start();

//require 'inc/db.php';

include 'check_login.php';
include 'database.php';


$id_einlesen = $_SESSION['id'];

$dseinlesen = $db->prepare("SELECT* FROM person where mitarbeiterID = ?");
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
    <input type="text" name="email" class= "form-control" id="email" value="<?php echo $email; ?>">
</label> 

<label>
    <input type="hidden" name="emailalt" id="emailalt" value="<?php echo $email; ?>">
</label><br>
<label>Name: <br>
    <input type="text" name="name" class= "form-control" id="name" value="<?php echo $name; ?>">       
</label><br>
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
    <input type="submit" name="aktion" value="Übernehmen" class = "btn btn-success">
    <input type="submit" name="aktion" value="Löschen" class = "btn btn-danger">
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
