<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  
    <link rel="stylesheet" href="/main.css">
<title>Mitarbeiterverwaltung</title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php



require 'inc/db.php';

$dseinlesen = $db->prepare("SELECT mitarbeiterID, email, passwort, name, rolle FROM person WHERE email = 'a' ");
        $dseinlesen->execute();
        while ($row = $dseinlesen->fetch()) {
            $mitarbeiterID = $row['mitarbeiterID'];
            $email = $row['email'];
            $passwort = $row['passwort'];
            $name = $row['name'];
            $rolle = $row['rolle'];
        }

?>
<form class = "form-horizontal" action="mitarbeiterverwaltung.php" method="post">


    <h3>Eigene Informationen bearbeiten</h3><br>
    
    <label>
        <input type="hidden" name="mitarbeiterID" id="mitarbeiterID" value="<?php echo $mitarbeiterID; ?>">
    </label>
    <label>
        <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
    </label><br>
    <label>Passwort:<br>
        <input type="text" name="passwort" id="passwort" value="">
    </label><br>
    <label>Name: <br>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>">       
    </label><br>
    Rolle:<br>
    <select name = "rolle">
        <option value ="Mitarbeiter">Mitarbeiter</option>
        <option value ="Vertrieb">Vertrieb</option>
        <option value ="Management">Management</option>
        value="<?php echo $rolle; ?>"
    </select><br> <br>



</form>
<input type="submit" onclick="return confirm('Änderungen wirklich übernehmen?')" name = "action" value="updaten">
<input type="submit" name = "aktion" value="info">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>