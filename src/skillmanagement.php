<?php
include 'check_login.php';
include 'database.php';
// foreach skill
// skill #1
if(isset($_POST['skill1'])) {
    if($_POST['skill1'] !== "0") {
        $conn->prepare(sprintf("REPLACE INTO besitzt (skillID, mitarbeiterID, auspraegung) VALUES ('1', '%d', '%s');", $_SESSION['userid'], $_POST['skill1']))->execute();
    } else {
        $conn->prepare(sprintf("DELETE FROM besitzt where skillID = 1 and mitarbeiterID = %d", $_SESSION['userid']))->execute();
    }
}
// skill #2 
if(isset($_POST['skill2'])) {
    if($_POST['skill2'] !== "0") {
        $conn->prepare(sprintf("REPLACE INTO besitzt (skillID, mitarbeiterID, auspraegung) VALUES ('2', '%d', '%s');", $_SESSION['userid'], $_POST['skill2']))->execute();
    } else {
        $conn->prepare(sprintf("DELETE FROM besitzt where skillID = 2 and mitarbeiterID = %d", $_SESSION['userid']))->execute();
    }
}
// skill #3
if(isset($_POST['skill3'])) {
    if($_POST['skill3'] !== "0") {
        $conn->prepare(sprintf("REPLACE INTO besitzt (skillID, mitarbeiterID, auspraegung) VALUES ('3', '%d', '%s');", $_SESSION['userid'], $_POST['skill3']))->execute();
    } else {
        $conn->prepare(sprintf("DELETE FROM besitzt where skillID = 3 and mitarbeiterID = %d", $_SESSION['userid']))->execute();
    }
}
// skill #4
if(isset($_POST['skill4'])) {
    if($_POST['skill4'] !== "0") {
        $conn->prepare(sprintf("REPLACE INTO besitzt (skillID, mitarbeiterID, auspraegung) VALUES ('4', '%d', '%s');", $_SESSION['userid'], $_POST['skill4']))->execute();
    } else {
        $conn->prepare(sprintf("DELETE FROM besitzt where skillID = 4 and mitarbeiterID = %d", $_SESSION['userid']))->execute();
    }
}
// skill #5
if(isset($_POST['skill5'])) {
    if($_POST['skill5'] !== "0") {
        $conn->prepare(sprintf("REPLACE INTO besitzt (skillID, mitarbeiterID, auspraegung) VALUES ('5', '%d', '%s');", $_SESSION['userid'], $_POST['skill5']))->execute();
    } else {
        $conn->prepare(sprintf("DELETE FROM besitzt where skillID = 5 and mitarbeiterID = %d", $_SESSION['userid']))->execute();
    }
}
// skill #6
if(isset($_POST['skill6'])) {
    if($_POST['skill6'] !== "0") {
        $conn->prepare(sprintf("REPLACE INTO besitzt (skillID, mitarbeiterID, auspraegung) VALUES ('6', '%d', '%s');", $_SESSION['userid'], $_POST['skill6']))->execute();
    } else {
        $conn->prepare(sprintf("DELETE FROM besitzt where skillID = 6 and mitarbeiterID = %d", $_SESSION['userid']))->execute();
    }
}
// skill #7
if(isset($_POST['skill7'])) {
    if($_POST['skill7'] !== "0") {
        $conn->prepare(sprintf("REPLACE INTO besitzt (skillID, mitarbeiterID, auspraegung) VALUES ('7', '%d', '%s');", $_SESSION['userid'], $_POST['skill7']))->execute();
    } else {
        $conn->prepare(sprintf("DELETE FROM besitzt where skillID = 7 and mitarbeiterID = %d", $_SESSION['userid']))->execute();
    }
}
// skill #8
if(isset($_POST['skill8'])) {
    if($_POST['skill8'] !== "0") {
        $conn->prepare(sprintf("REPLACE INTO besitzt (skillID, mitarbeiterID, auspraegung) VALUES ('8', '%d', '%s');", $_SESSION['userid'], $_POST['skill8']))->execute();
    } else {
        $conn->prepare(sprintf("DELETE FROM besitzt where skillID = 8 and mitarbeiterID = %d", $_SESSION['userid']))->execute();
    }
}
// skill #9
if(isset($_POST['skill9'])) {
    if($_POST['skill9'] !== "0") {
        $conn->prepare(sprintf("REPLACE INTO besitzt (skillID, mitarbeiterID, auspraegung) VALUES ('9', '%d', '%s');", $_SESSION['userid'], $_POST['skill9']))->execute();
    } else {
        $conn->prepare(sprintf("DELETE FROM besitzt where skillID = 9 and mitarbeiterID = %d", $_SESSION['userid']))->execute();
    }
}
// skill #10
if(isset($_POST['skill10'])) {
    if($_POST['skill10'] !== "0") {
        $conn->prepare(sprintf("REPLACE INTO besitzt (skillID, mitarbeiterID, auspraegung) VALUES ('10', '%d', '%s');", $_SESSION['userid'], $_POST['skill10']))->execute();
    } else {
        $conn->prepare(sprintf("DELETE FROM besitzt where skillID = 10 and mitarbeiterID = %d", $_SESSION['userid']))->execute();
    }
}
?>

<!DOCTYPE html> 
<html> 
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Skillmanagement</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/skillmanagement.css">
    </head>

<body>

    <!-- navbar mit custom-link je nach Recht -->
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
        
    <div class="container">
            <h2><br>Verwaltung der Skills</h2>       
                <table class="table table-striped">
                <thead>
                <tr>
                    <th>Skills</th>
                    <th>Aktuelle Ausprägung</th>
                    <th>Neue Ausprägung setzen</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td>
                    <?php // skill #1
                    $stmt1 = $conn->prepare("SELECT skillname FROM skills where skillID = 1");
                    $stmt1->execute();

                    $stmt2 = $conn->prepare(sprintf("SELECT auspraegung FROM besitzt where skillID = 1 and mitarbeiterID = %d", $_SESSION['userid']));
                    $stmt2->execute();

                    echo "<p style='font-size:16pt; font-family:arial;'>" . $stmt1->fetch()['skillname'] . "</p>";
                    $sskill = ($stmt2->fetch()['auspraegung'] ?? 0);
                    ?>
                    </td>

                    <td>
                    <?php $sql = sprintf("SELECT auspraegung FROM besitzt where skillID = 1 and mitarbeiterID = %d", $_SESSION['userid']);
                    foreach ($conn->query($sql) as $level) {
                        echo "<p style='font-size:16pt; font-family:arial;'>" . $level['auspraegung'] . "</p>";
                    }?>
                    </td>

                    <td>
                        <form action="" method="post">
                        <select name="skill1" class="custom-select mb-3">
                        <option <?php if($sskill == 0) echo "selected"?> value="0">Nicht gesetzt</option>
                        <option <?php if($sskill == 1) echo "selected"?> value="1">1</option>
                        <option <?php if($sskill == 2) echo "selected"?> value="2">2</option>
                        <option <?php if($sskill == 3) echo "selected"?> value="3">3</option>
                        <option <?php if($sskill == 4) echo "selected"?> value="4">4</option>
                        <option <?php if($sskill == 5) echo "selected"?> value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-light custom-btn">Speichern</button>
                        </form>
                    </td>
                </tr>
                
                <tr>
                    <td>
                    <?php // skill #2
                    $stmt1 = $conn->prepare("SELECT skillname FROM skills where skillID = 2");
                    $stmt1->execute();

                    $stmt2 = $conn->prepare(sprintf("SELECT auspraegung FROM besitzt where skillID = 2 and mitarbeiterID = %d", $_SESSION['userid']));
                    $stmt2->execute();

                    echo "<p style='font-size:16pt; font-family:arial;'>" . $stmt1->fetch()['skillname'] . "</p>";
                    $sskill = ($stmt2->fetch()['auspraegung'] ?? 0);
                    ?>
                    </td>

                    <td>
                    <?php $sql = sprintf("SELECT auspraegung FROM besitzt where skillID = 2 and mitarbeiterID = %d", $_SESSION['userid']);
                    foreach ($conn->query($sql) as $level) {
                        echo "<p style='font-size:16pt; font-family:arial;'>" . $level['auspraegung'] . "</p>";
                    }?>
                    </td>

                    <td>
                        <form action="" method="post">
                        <select name="skill2" class="custom-select mb-3">
                        <option <?php if($sskill == 0) echo "selected"?> value="0">Nicht gesetzt</option>
                        <option <?php if($sskill == 1) echo "selected"?> value="1">1</option>
                        <option <?php if($sskill == 2) echo "selected"?> value="2">2</option>
                        <option <?php if($sskill == 3) echo "selected"?> value="3">3</option>
                        <option <?php if($sskill == 4) echo "selected"?> value="4">4</option>
                        <option <?php if($sskill == 5) echo "selected"?> value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-light custom-btn">Speichern</button>
                        </form>
                    </td>
                </tr>

                <tr>
                    <td>
                    <?php // skill #3
                    $stmt1 = $conn->prepare("SELECT skillname FROM skills where skillID = 3");
                    $stmt1->execute();

                    $stmt2 = $conn->prepare(sprintf("SELECT auspraegung FROM besitzt where skillID = 3 and mitarbeiterID = %d", $_SESSION['userid']));
                    $stmt2->execute();

                    echo "<p style='font-size:16pt; font-family:arial;'>" . $stmt1->fetch()['skillname'] . "</p>";
                    $sskill = ($stmt2->fetch()['auspraegung'] ?? 0);
                    ?>
                    </td>

                    <td>
                    <?php $sql = sprintf("SELECT auspraegung FROM besitzt where skillID = 3 and mitarbeiterID = %d", $_SESSION['userid']);
                    foreach ($conn->query($sql) as $level) {
                        echo "<p style='font-size:16pt; font-family:arial;'>" . $level['auspraegung'] . "</p>";
                    }?>
                    </td>

                    <td>
                        <form action="" method="post">
                        <select name="skill3" class="custom-select mb-3">
                        <option <?php if($sskill == 0) echo "selected"?> value="0">Nicht gesetzt</option>
                        <option <?php if($sskill == 1) echo "selected"?> value="1">1</option>
                        <option <?php if($sskill == 2) echo "selected"?> value="2">2</option>
                        <option <?php if($sskill == 3) echo "selected"?> value="3">3</option>
                        <option <?php if($sskill == 4) echo "selected"?> value="4">4</option>
                        <option <?php if($sskill == 5) echo "selected"?> value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-light custom-btn">Speichern</button>
                        </form>
                    </td>
                </tr>

                <tr>
                    <td>
                    <?php // skill #4
                    $stmt1 = $conn->prepare("SELECT skillname FROM skills where skillID = 4");
                    $stmt1->execute();

                    $stmt2 = $conn->prepare(sprintf("SELECT auspraegung FROM besitzt where skillID = 4 and mitarbeiterID = %d", $_SESSION['userid']));
                    $stmt2->execute();

                    echo "<p style='font-size:16pt; font-family:arial;'>" . $stmt1->fetch()['skillname'] . "</p>";
                    $sskill = ($stmt2->fetch()['auspraegung'] ?? 0);
                    ?>
                    </td>

                    <td>
                    <?php $sql = sprintf("SELECT auspraegung FROM besitzt where skillID = 4 and mitarbeiterID = %d", $_SESSION['userid']);
                    foreach ($conn->query($sql) as $level) {
                        echo "<p style='font-size:16pt; font-family:arial;'>" . $level['auspraegung'] . "</p>";
                    }?>
                    </td>

                    <td>
                        <form action="" method="post">
                        <select name="skill4" class="custom-select mb-3">
                        <option <?php if($sskill == 0) echo "selected"?> value="0">Nicht gesetzt</option>
                        <option <?php if($sskill == 1) echo "selected"?> value="1">1</option>
                        <option <?php if($sskill == 2) echo "selected"?> value="2">2</option>
                        <option <?php if($sskill == 3) echo "selected"?> value="3">3</option>
                        <option <?php if($sskill == 4) echo "selected"?> value="4">4</option>
                        <option <?php if($sskill == 5) echo "selected"?> value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-light custom-btn">Speichern</button>
                        </form>
                    </td>
                </tr>

                <tr>
                    <td>
                    <?php // skill #5
                    $stmt1 = $conn->prepare("SELECT skillname FROM skills where skillID = 5");
                    $stmt1->execute();

                    $stmt2 = $conn->prepare(sprintf("SELECT auspraegung FROM besitzt where skillID = 5 and mitarbeiterID = %d", $_SESSION['userid']));
                    $stmt2->execute();

                    echo "<p style='font-size:16pt; font-family:arial;'>" . $stmt1->fetch()['skillname'] . "</p>";
                    $sskill = ($stmt2->fetch()['auspraegung'] ?? 0);
                    ?>
                    </td>

                    <td>
                    <?php $sql = sprintf("SELECT auspraegung FROM besitzt where skillID = 5 and mitarbeiterID = %d", $_SESSION['userid']);
                    foreach ($conn->query($sql) as $level) {
                        echo "<p style='font-size:16pt; font-family:arial;'>" . $level['auspraegung'] . "</p>";
                    }?>
                    </td>

                    <td>
                        <form action="" method="post">
                        <select name="skill5" class="custom-select mb-3">
                        <option <?php if($sskill == 0) echo "selected"?> value="0">Nicht gesetzt</option>
                        <option <?php if($sskill == 1) echo "selected"?> value="1">1</option>
                        <option <?php if($sskill == 2) echo "selected"?> value="2">2</option>
                        <option <?php if($sskill == 3) echo "selected"?> value="3">3</option>
                        <option <?php if($sskill == 4) echo "selected"?> value="4">4</option>
                        <option <?php if($sskill == 5) echo "selected"?> value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-light custom-btn">Speichern</button>
                        </form>
                    </td>
                </tr>

                <tr>
                    <td>
                    <?php // skill #6
                    $stmt1 = $conn->prepare("SELECT skillname FROM skills where skillID = 6");
                    $stmt1->execute();

                    $stmt2 = $conn->prepare(sprintf("SELECT auspraegung FROM besitzt where skillID = 6 and mitarbeiterID = %d", $_SESSION['userid']));
                    $stmt2->execute();

                    echo "<p style='font-size:16pt; font-family:arial;'>" . $stmt1->fetch()['skillname'] . "</p>";
                    $sskill = ($stmt2->fetch()['auspraegung'] ?? 0);
                    ?>
                    </td>

                    <td>
                    <?php $sql = sprintf("SELECT auspraegung FROM besitzt where skillID = 6 and mitarbeiterID = %d", $_SESSION['userid']);
                    foreach ($conn->query($sql) as $level) {
                        echo "<p style='font-size:16pt; font-family:arial;'>" . $level['auspraegung'] . "</p>";
                    }?>
                    </td>

                    <td>
                        <form action="" method="post">
                        <select name="skill6" class="custom-select mb-3">
                        <option <?php if($sskill == 0) echo "selected"?> value="0">Nicht gesetzt</option>
                        <option <?php if($sskill == 1) echo "selected"?> value="1">1</option>
                        <option <?php if($sskill == 2) echo "selected"?> value="2">2</option>
                        <option <?php if($sskill == 3) echo "selected"?> value="3">3</option>
                        <option <?php if($sskill == 4) echo "selected"?> value="4">4</option>
                        <option <?php if($sskill == 5) echo "selected"?> value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-light custom-btn">Speichern</button>
                        </form>
                    </td>
                </tr>

                <tr>
                    <td>
                    <?php // skill #7
                    $stmt1 = $conn->prepare("SELECT skillname FROM skills where skillID = 7");
                    $stmt1->execute();

                    $stmt2 = $conn->prepare(sprintf("SELECT auspraegung FROM besitzt where skillID = 7 and mitarbeiterID = %d", $_SESSION['userid']));
                    $stmt2->execute();

                    echo "<p style='font-size:16pt; font-family:arial;'>" . $stmt1->fetch()['skillname'] . "</p>";
                    $sskill = ($stmt2->fetch()['auspraegung'] ?? 0);
                    ?>
                    </td>

                    <td>
                    <?php $sql = sprintf("SELECT auspraegung FROM besitzt where skillID = 7 and mitarbeiterID = %d", $_SESSION['userid']);
                    foreach ($conn->query($sql) as $level) {
                        echo "<p style='font-size:16pt; font-family:arial;'>" . $level['auspraegung'] . "</p>";
                    }?>
                    </td>

                    <td>
                        <form action="" method="post">
                        <select name="skill7" class="custom-select mb-3">
                        <option <?php if($sskill == 0) echo "selected"?> value="0">Nicht gesetzt</option>
                        <option <?php if($sskill == 1) echo "selected"?> value="1">1</option>
                        <option <?php if($sskill == 2) echo "selected"?> value="2">2</option>
                        <option <?php if($sskill == 3) echo "selected"?> value="3">3</option>
                        <option <?php if($sskill == 4) echo "selected"?> value="4">4</option>
                        <option <?php if($sskill == 5) echo "selected"?> value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-light custom-btn">Speichern</button>
                        </form>
                    </td>
                </tr>

                <tr>
                    <td>
                    <?php // skill #8
                    $stmt1 = $conn->prepare("SELECT skillname FROM skills where skillID = 8");
                    $stmt1->execute();

                    $stmt2 = $conn->prepare(sprintf("SELECT auspraegung FROM besitzt where skillID = 8 and mitarbeiterID = %d", $_SESSION['userid']));
                    $stmt2->execute();

                    echo "<p style='font-size:16pt; font-family:arial;'>" . $stmt1->fetch()['skillname'] . "</p>";
                    $sskill = ($stmt2->fetch()['auspraegung'] ?? 0);
                    ?>
                    </td>

                    <td>
                    <?php $sql = sprintf("SELECT auspraegung FROM besitzt where skillID = 8 and mitarbeiterID = %d", $_SESSION['userid']);
                    foreach ($conn->query($sql) as $level) {
                        echo "<p style='font-size:16pt; font-family:arial;'>" . $level['auspraegung'] . "</p>";
                    }?>
                    </td>

                    <td>
                        <form action="" method="post">
                        <select name="skill8" class="custom-select mb-3">
                        <option <?php if($sskill == 0) echo "selected"?> value="0">Nicht gesetzt</option>
                        <option <?php if($sskill == 1) echo "selected"?> value="1">1</option>
                        <option <?php if($sskill == 2) echo "selected"?> value="2">2</option>
                        <option <?php if($sskill == 3) echo "selected"?> value="3">3</option>
                        <option <?php if($sskill == 4) echo "selected"?> value="4">4</option>
                        <option <?php if($sskill == 5) echo "selected"?> value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-light custom-btn">Speichern</button>
                        </form>
                    </td>
                </tr>

                <tr>
                    <td>
                    <?php // skill #9
                    $stmt1 = $conn->prepare("SELECT skillname FROM skills where skillID = 9");
                    $stmt1->execute();

                    $stmt2 = $conn->prepare(sprintf("SELECT auspraegung FROM besitzt where skillID = 9 and mitarbeiterID = %d", $_SESSION['userid']));
                    $stmt2->execute();

                    echo "<p style='font-size:16pt; font-family:arial;'>" . $stmt1->fetch()['skillname'] . "</p>";
                    $sskill = ($stmt2->fetch()['auspraegung'] ?? 0);
                    ?>
                    </td>

                    <td>
                    <?php $sql = sprintf("SELECT auspraegung FROM besitzt where skillID = 9 and mitarbeiterID = %d", $_SESSION['userid']);
                    foreach ($conn->query($sql) as $level) {
                        echo "<p style='font-size:16pt; font-family:arial;'>" . $level['auspraegung'] . "</p>";
                    }?>
                    </td>

                    <td>
                        <form action="" method="post">
                        <select name="skill9" class="custom-select mb-3">
                        <option <?php if($sskill == 0) echo "selected"?> value="0">Nicht gesetzt</option>
                        <option <?php if($sskill == 1) echo "selected"?> value="1">1</option>
                        <option <?php if($sskill == 2) echo "selected"?> value="2">2</option>
                        <option <?php if($sskill == 3) echo "selected"?> value="3">3</option>
                        <option <?php if($sskill == 4) echo "selected"?> value="4">4</option>
                        <option <?php if($sskill == 5) echo "selected"?> value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-light custom-btn">Speichern</button>
                        </form>
                    </td>
                </tr>

                <tr>
                    <td>
                    <?php // skill #10
                    $stmt1 = $conn->prepare("SELECT skillname FROM skills where skillID = 10");
                    $stmt1->execute();

                    $stmt2 = $conn->prepare(sprintf("SELECT auspraegung FROM besitzt where skillID = 10 and mitarbeiterID = %d", $_SESSION['userid']));
                    $stmt2->execute();

                    echo "<p style='font-size:16pt; font-family:arial;'>" . $stmt1->fetch()['skillname'] . "</p>";
                    $sskill = ($stmt2->fetch()['auspraegung'] ?? 0);
                    ?>
                    </td>

                    <td>
                    <?php $sql = sprintf("SELECT auspraegung FROM besitzt where skillID = 10 and mitarbeiterID = %d", $_SESSION['userid']);
                    foreach ($conn->query($sql) as $level) {
                        echo "<p style='font-size:16pt; font-family:arial;'>" . $level['auspraegung'] . "</p>";
                    }?>
                    </td>

                    <td>
                        <form action="" method="post">
                        <select name="skill10" class="custom-select mb-3">
                        <option <?php if($sskill == 0) echo "selected"?> value="0">Nicht gesetzt</option>
                        <option <?php if($sskill == 1) echo "selected"?> value="1">1</option>
                        <option <?php if($sskill == 2) echo "selected"?> value="2">2</option>
                        <option <?php if($sskill == 3) echo "selected"?> value="3">3</option>
                        <option <?php if($sskill == 4) echo "selected"?> value="4">4</option>
                        <option <?php if($sskill == 5) echo "selected"?> value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-light custom-btn">Speichern</button>
                        </form>
                    </td>
                </tr>

                </tbody>
                </table>
    </div>
    
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>        
</body>
</html>

