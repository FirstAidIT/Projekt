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
SESSION_START();

//require 'inc/db.php';


include 'check_login.php';
include 'database.php';



/* Updates nach Termin mit Auftraggeber

- Fehlermeldungen auf der gleichen Seite
- Alles auf Buttons!!

User löschen*/

$nochfalsch = false;
$modus_aenderung;
$modus_mail = false;
if (isset($_GET['aktion']) and $_GET['aktion']=='loeschen') {
    if (isset($_GET['mitarbeiterID'])) {
        $mitarbeiterID =$_GET['mitarbeiterID'];
        if ($mitarbeiterID > 0)
        {
            $loeschen = $db->prepare("DELETE FROM person WHERE mitarbeiterID=(?) LIMIT 1");
            $loeschen->bindParam(1, $mitarbeiterID, PDO::PARAM_STR);
            if ($loeschen->execute()) {
                ?>
                <meta http-equiv="refresh" content="5; URL=benutzerverwaltungma.php"> 
                <?php
                echo "<p>Datensatz wurde gelöscht</p>";
            }
        }       
    }
}

//Benutzer deaktivieren
if (isset($_POST['aktion']) and $_POST['aktion']=='Benutzer deaktivieren') {
    $modus_aendern = true;

    $mitarbeiterdeaktivieren = $_POST['mitarbeiterID'];

    $update = $db->prepare("UPDATE person SET active = 0 WHERE mitarbeiterID=?");
    $update->execute([$mitarbeiterdeaktivieren]); 
}

//Benutzer reaktivieren
if (isset($_POST['aktion']) and $_POST['aktion']=='Benutzer reaktivieren') {
    $modus_aendern = true;

    $mitarbeiterreaktivieren = $_POST['mitarbeiterID'];

    $update = $db->prepare("UPDATE person SET active = 1 WHERE mitarbeiterID=?");
    $update->execute([$mitarbeiterreaktivieren]);
 
}


//Bestehenden User ändern
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


    $statement = $db->prepare("SELECT* FROM person WHERE email = '$upd_email'");
    $statement->execute(array('Max')); 
    $anzahl_user = $statement->rowCount();




    if(check_email($upd_email) == false){
        echo "Bitte eine gültige E-Mail angeben";
    }

    else {
        if ($anzahl_user > 0 && $upd_email != $emailalt){
            $modus_mail == true;
            echo ("E-Mail bereits vergeben");
        }

        else{
    $hashed_password = password_hash($upd_passwort, PASSWORD_DEFAULT);

    
    if ($upd_email != '' or $upd_passwort != '' or $upd_name != '' or $upd_rolle != '')
    {
        // speichern
        $update = $db->prepare("UPDATE person SET email =?, passwort=?, name=?, rolle=? WHERE mitarbeiterID=?");
        $update->execute([$upd_email, $hashed_password, $upd_name, $upd_rolle, $upd_id]);
        if ($update->execute()) {   
            ?>
            <meta http-equiv="refresh" content="5; URL=benutzerverwaltungma.php"> 
            <?php
            echo '<p class="feedbackerfolg">Datensatz wurde geändert</p>';
            $modus_aendern = false;
            $nochfalsch=false;
        }
    }
    }
    }
}


//Anlegen eines neuen Users

if (isset($_POST['aktion']) and $_POST['aktion']=='speichern') {
    $email = "";
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
    }
    $passwort = "";
    if (isset($_POST['passwort'])) {
        $passwort = trim($_POST['passwort']);
    }
    $name = "";
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
    }
    $rolle = "";
    if (isset($_POST['rolle'])) {
        $rolle = trim($_POST['rolle']);
    }

    $mail = $_POST['email'];
    $passwortwdh = $_POST['passwortwdh'];



    $hashed_password = password_hash($passwort, PASSWORD_DEFAULT);
    

    $statement = $db->prepare("SELECT* FROM person WHERE email = '$email'");
    $statement->execute(array('Max')); 
    $anzahl_user = $statement->rowCount();

    if ( $email == '' OR $passwort == '' OR $name == '' )
        {
        ?>
        <meta http-equiv="refresh" content="5; URL=mitarbeiterverwaltungma.php"> 
        <?php
        echo "Bitte alle nötigen Informationen angeben";
        }
    else{
        if(check_email($email) == false){
            ?>
            <meta http-equiv="refresh" content="5; URL=mitarbeiterverwaltungma.php"> 
            <?php
            echo "Bitte eine gültige E-Mail angeben";
        }
    
        else {
            if ($anzahl_user > 0){
                ?>
                <meta http-equiv="refresh" content="5; URL=mitarbeiterverwaltungma.php"> 
                <?php
                echo ("E-Mail bereits vergeben");
            }
            
            else {
                
                if (PassStrength($passwort) < 30){
                    ?>
                    <meta http-equiv="refresh" content="5; URL=mitarbeiterverwaltungma.php"> 
                    <?php
                    echo "Bitte ein sicheres Passwort angeben";  
                }
                else {
                    if ($passwort!=$passwortwdh){
                        ?>
                        <meta http-equiv="refresh" content="5; URL=mitarbeiterverwaltungma.php"> 
                        <?php
                        echo "Passwörter stimmen nicht überein";
                    }
                    else{
                
                        // speichern
                        $einfuegen = $db->prepare("INSERT INTO person(email, passwort, name, rolle) VALUES (?,?,?,?)");
                        $einfuegen->bindParam(1, $email, PDO::PARAM_STR);
                        $einfuegen->bindParam(2, $hashed_password, PDO::PARAM_STR);
                        $einfuegen->bindParam(3, $name, PDO::PARAM_STR);
                        $einfuegen->bindParam(4, $rolle, PDO::PARAM_STR);
                
                        if ($einfuegen->execute()) {
                        header('Location: benutzerverwaltungma.php?aktion=feedbackgespeichert');
                        die();
                        }
                    }

                }
            }
        }
    }
if (isset($_POST['aktion']) and $_POST['aktion']=='feedbackgespeichert') {
    ?>
    <meta http-equiv="refresh" content="5; URL=benutzerverwaltungma.php"> 
    <?php
    echo '<p class="feedbackerfolg">Datensatz wurde gespeichert</p>';
}
}
$modus_aendern = false;

if (isset($_GET['aktion']) and $_GET['aktion']=='bearbeiten') {
    $modus_aendern = true;
    $modus_aenderung = true;
}

if ($modus_aendern != true) 
{

$daten = array();
if ($erg = $db->query("SELECT * FROM person")) {
	if ($erg->rowCount()) {
		while($datensatz = $erg->fetchObject()) {
			$daten[] = $datensatz;
		}
	}	
}
if (!count($daten)) {
    echo "<p>Es liegen keine Daten vor :(</p>";
} else {
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="benutzerverwaltungma.php">Benutzerverwaltung <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="einzelprojekt.php">Projekt bearbeiten</a>
    </ul>

    <ul class="navbar-nav ml-auto">
    </li>
    <li class="nav-item ">
        <a class="fas fa-user fa-2x" href="mitarbeiterverwaltung.php" ></a>
    </li>
    </ul>
  </div>
</nav>
<br>
<form class = "form-inline" action="" method="get">
    <div class="form-group mb-2">
        <label>Mitarbeiter suchen:</label>
    </div>    
    <div class="form-group mx-sm-3 mb-2">
        <input  type="hidden" name="aktion" value="suchen">
        <input  type="text" class = "form-control" name="suchbegriff" id="suchbegriff" value ="Name" onfocus="if(this.value=='Name')   this.value='';" onblur="if(this.value==''){this.value='Name';}" >
        <input  type="hidden" value="suchen" class="w3-btn w3-black">
    </div>
        <button class="btn btn-secondary mb-2"><i class="fas fa-search"></i> Suchen</button>
</form>


 <?php

$modus_aendern = false;
 if ($modus_aendern == false ) {

    $limit = 6;
    $query = "SELECT count(*) FROM person";


    if (!isset($_GET['page'])) {
        $page = 1;
    } else{
        $page = $_GET['page'];
    }

    $starting_limit = ($page-1)*$limit;


    $daten = array();
    /*if ( isset($_GET['suchbegriff']) and trim ($_GET['suchbegriff']) != '' )
    {
        $suchbegriff = trim ($_GET['suchbegriff']);
        //echo "<p>Gesucht wird nach: <b>$suchbegriff</b></p>"; 
        $suche_nach = "%{$suchbegriff}%";
        $suche = $db->prepare("SELECT mitarbeiterID, email, passwort, name, rolle, active 
                     FROM person
                     WHERE name LIKE ?");
        $suche->bindParam(1, $suche_nach, PDO::PARAM_STR);
        //$suche->bindParam(2, $suche_nach, PDO::PARAM_STR);
        $suche->execute();

        while ($datensatzsuche = $suche->fetchObject()) {
            $daten[] = $datensatzsuche;
        }
        $suche = null;
        //$mitarbeiterID       = '';
        $email   = '';
        $name  = '';
        $rolle = ''; 
        $active = '';    
    }*/

    if ( isset($_GET['suchbegriff']) and trim ($_GET['suchbegriff']) != '' )
    {
        $suchbegriff = trim ($_GET['suchbegriff']);
        //echo "<p>Gesucht wird nach: <b>$suchbegriff</b></p>"; 
        $suche_nach = "%{$suchbegriff}%";
        $abc = $db->prepare("SELECT mitarbeiterID, email, passwort, name, rolle, active 
        FROM person
        WHERE name LIKE ?");
        $abc->bindParam(1, $suche_nach, PDO::PARAM_STR);
        $abc->execute();
        $anzahl_ergebnisse = $abc->rowCount();
        echo $anzahl_ergebnisse;
        $total_pages = ceil($anzahl_ergebnisse/$limit);
    }
    else

    {
        $s = $db->query($query);
        $total_results = $s->fetchColumn();
        $total_pages = ceil($total_results/$limit);
        $abc = $db->prepare("SELECT *  FROM person ORDER BY name ASC LIMIT $starting_limit, $limit");
        $abc->execute();
        $ergebnisse = $abc->fetchColumn();
    }

        ?>

 
                <table class = "table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <!--<th scope="col">ID</th>-->
                            <th scope="col">E-Mail</th>
                            <th scope="col">Rolle </th>
                            <th scope="col">Status</th>
                            <th scope="col">Bearbeiten</th>
                        </tr>
                    </thead>                  
                    <tbody>
                    <?php while($res = $abc->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo sicherheit($res['name']); ?></td>
                                <!--<td><?php echo $inhalt->mitarbeiterID; ?></td>-->
                                <td><?php echo $res['email']; ?></td>
                                <td><?php echo sicherheit($res['rolle']); ?></td>
                                <?php if ($res['active'] ==true){?><td><?php echo "aktiv"; ?></td><?php }?>
                                <?php if ($res['active'] ==false){?><td><?php echo "inaktiv"; ?></td><?php }?>
                                <!--<td><a href = "?aktion=anzeigen&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" class="w3-btn w3-black">Anzeigen</a></td>-->
                                <!--<td><a href = "?aktion=loeschen&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" onclick="return confirm('Soll der Mitarbeiter wirklich gelöscht werden?')"  class="w3-btn w3-red">Löschen</a></td>-->
                                <td><a href = "?aktion=bearbeiten&mitarbeiterID=<?php echo $res['mitarbeiterID']; ?>" class="btn btn-secondary">Bearbeiten</a></td>
                                <!--<td><a href = "aenderungma.php" name = "aktion" value = "wirdgeaendert" method ="post" class="btn btn-secondary">Aenderung</a></td>-->
                                <!--<td><input type = "submit" name = "aktion" value = "bearbeiten" class ="btn btn-primary">-->

                            </tr><br>		
                        <?php  endwhile;?>	
                    </tbody>
                </table>

                <form>
                Seite: 
                    <?php
                    for ($page=1; $page <= $total_pages ; $page++):?>

                    <a href='<?php echo "?page=$page"; ?>' class="links"><?php  echo  $page; ?>
                    </a>

                    <?php endfor;?>

                <br><br>

            <?php
        
    }
    /*{
        if ($erg = $db->query("SELECT *  FROM person ORDER BY name ASC LIMIT ?,?")) {
            if ($erg->rowCount()) {
                while ($datensatz = $erg->fetchObject()) {
                    $daten[] = $datensatz;
                }
            }
        }
    }



?>

    <br>
    <table class = "table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">TEST</th>
                <th scope="col">Name</th>
                <!--<th scope="col">ID</th>-->
                <th scope="col">E-Mail</th>
                <th scope="col">Rolle</th>
                <th scope="col">Status</th>
                <th scope="col">Bearbeiten</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($daten as $inhalt) {
                $_SESSION["mitarbeiterID2"] = $inhalt->mitarbeiterID;
            ?>			
                <tr>
                    <td><?php echo $_SESSION["mitarbeiterID"] = $inhalt->name; ?></td>
                    <td><?php echo sicherheit($inhalt->name); ?></td>
                    <!--<td><?php echo $inhalt->mitarbeiterID; ?></td>-->
                    <td><?php echo sicherheit($inhalt->email); ?></td>
                    <td><?php echo sicherheit($inhalt->rolle); ?></td>
                    <?php if ($inhalt->active ==true){?><td><?php echo "aktiv"; ?></td><?php }?>
                    <?php if ($inhalt->active ==false){?><td><?php echo "inaktiv"; ?></td><?php }?>
                    <!--<td><a href = "?aktion=anzeigen&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" class="w3-btn w3-black">Anzeigen</a></td>-->
                    <!--<td><a href = "?aktion=loeschen&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" onclick="return confirm('Soll der Mitarbeiter wirklich gelöscht werden?')"  class="w3-btn w3-red">Löschen</a></td>-->
                    <td><a href = "?aktion=bearbeiten&mitarbeiterID=<?php echo $inhalt->mitarbeiterID; ?>" class="btn btn-secondary">Bearbeiten</a></td>
                    <td><a href = "aenderungma.php" name = "aktion" value = "wirdgeaendert" method ="post" class="btn btn-secondary">Aenderung</a></td>
                    <!--<td><input type = "submit" name = "aktion" value = "bearbeiten" class ="btn btn-primary">-->
                </tr>
            <?php
            }
            ?>			
        </tbody>
    </table>

    <br><br>

    <form method="get" action="mitarbeiterverwaltungma.php"> 
         <input type="submit" value="Neuen Benutzer anlegen" class="btn btn-primary">
    </form>
<?php
   */     	

}
}


//Einlesen der Daten 

if ( $modus_aendern == true and isset($_GET['mitarbeiterID']) ) {
    
    $id_einlesen = (INT) $_GET['mitarbeiterID'];
    if ($id_einlesen > 0)
    {   
        $dseinlesen = $db->prepare("SELECT mitarbeiterID, email, passwort, name, rolle, active FROM person WHERE mitarbeiterID=? ORDER BY name ASC");
        $dseinlesen->execute([$id_einlesen]);
        $dseinlesen->execute();
        while ($row = $dseinlesen->fetch()) {
            $mitarbeiterID = $row['mitarbeiterID'];
            $email = $row['email'];
            $passwort = $row['passwort'];
            $name = $row['name'];
            $rolle = $row['rolle'];
            $active =$row['active'];
        }
    }
}

function sicherheit($inhalt='') {
    $inhalt = trim($inhalt);
    $inhalt = htmlentities($inhalt, ENT_QUOTES, "UTF-8");
    return($inhalt);
}

function check_email($email) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
}

//Vorgefertigte PHP-Passwortfunktion

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


if ($modus_aendern == true){
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
<form style= "width:400;  margin:auto;" class = "form-horizontal" action="benutzerverwaltungma.php" method="post">


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
        <option value ="Mitarbeiter">Mitarbeiter</option>
        <option value ="Vertrieb">Vertrieb</option>
        <option value ="Management">Management</option>
        value="<?php echo $rolle; ?>"
    </select><br> <br>
    <input type="hidden" name="aktion" value="speichern">


<?php

}
//Hier muss noch geupdated werden
/*if ($modus_aendern != true) {
    echo '<input type="hidden" name="aktion" value="speichern">';
    echo '<input type="submit" value="Benutzer anlegen">';
    echo '</form>';
}*/
if ($modus_aendern == true)
{
    echo '<input type="hidden" name="id" value="'. $id_einlesen .'">';   
    echo '<input type="submit" name="aktion" value="Übernehmen" class = "btn btn-success">';?>
    <!--<input type="submit" onclick="return confirm('Änderungen wirklich übernehmen?')" class="btn btn-success" value="Änderungen speichern">-->
    <a href = "?aktion=loeschen&mitarbeiterID=<?php echo $mitarbeiterID; ?>" onclick="return confirm('Soll der Mitarbeiter wirklich gelöscht werden?')"  class="btn btn-danger">Löschen</a></td>
    <?php
    if ($active == 1){?>
    <input type="submit" onclick="return confirm('Mitarbeiter wirklich deaktivieren?')" name = "aktion" class="btn btn-warning" value="Benutzer deaktivieren">
    <?php
    }
    if ($active == 0){?>
        <input type="submit" onclick="return confirm('Mitarbeiter wirklich reaktivieren?')" name = "aktion" class="btn btn-warning" value="Benutzer reaktivieren">
        <?php
    }
    echo '</form>';
}
?>


 
</form>
</div>

<form method="get" action="mitarbeiterverwaltungma.php"> 
    <a href = "mitarbeiterverwaltungma.php"><input type="submit" value="Neuen Benutzer anlegen" class="btn btn-primary"></a>
</form>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
