<?php
include 'check_login.php';
include 'database.php';


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
	
	
<!DOCTYPE html> 
<html>
<head>
	<title> Logfiles </title>
	
	<!-- meta data -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/logfiles_modal.css">
	<!-- Javascript -->
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
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
 <div class="container h-100">
    <div class="row">
        <div class="col-12"></div>
    </div>
   <div class="row">
        <div class="col-12 pb-3">
            <div class="card mt-3">
                <div class="card-header text-light bg-success">Skillveränderungen</div>
				 <div class="card-body">
				 
				 <?php
						$sql = "SELECT person.name, skills.skillname, besitzt.auspraegung, besitzt.timestmp 
						FROM besitzt, person, skills
						WHERE person.mitarbeiterID = besitzt.mitarbeiterID 
						AND besitzt.skillID = skills.skillID
						AND besitzt.timestmp >= now() - INTERVAL 1 WEEK";

						echo '<table class="table table-hover">'; 
						echo 	"<thead>";
						echo		"<tr>";
						echo			"<th>Mitarbeitername</th>";
						echo			"<th>Skill</th>";
						echo	  		"<th>Ausprägung</th>";		
						echo	  		"<th>Änderungszeitpunkt</th>";
						echo		"</tr>";
						echo	  "</thead>";

						foreach ($conn->query($sql) as $row) {
						echo "<tr>";
						echo "<td>".$row['name'] . "</td>";
						echo "<td>".$row['skillname'] . "</td>";
						echo "<td>". $row['auspraegung'] . "</td>";
						echo "<td>".$row['timestmp']. "</td>";
						echo "</tr>";}

						echo "</table>";
					?> 		
				</div>
			</div>
		</div>
	</div>
			<br> <br> <br>


	<div class="row">
        <div class="col-12 pb-3">
            <div class="card mt-3">
                <div class="card-header text-light bg-success">Neu aufgenommene Dokumente</div>
				 <div class="card-body">
				 
						<?php
			
									$sql = "SELECT erstellungsdatum, projektname, kunde, dauer, budget  
									FROM projekt
									WHERE erstellungsdatum >= now() - INTERVAL 4 WEEK";
										
									echo '<table class="table">'; 
									echo 	"<thead>";
									echo		"<tr>";
									echo			"<th>Erstellungsdatum</th>";
									echo	  		"<th>Projektname</th>";		
									echo			"<th>Kunde</th>";
									echo	  		"<th>Dauer</th>";
									echo	  		"<th>Budget</th>";
									echo		"</tr>";
									echo	  "</thead>";
										
									foreach ($conn->query($sql) as $row) {
									echo "<tr>";
									echo "<td>".$row['erstellungsdatum'] . "</td>";
									echo "<td>". $row['projektname'] . "</td>";
									echo "<td>".$row['kunde'] . "</td>";
									echo "<td>".$row['dauer']. "</td>";
									echo "<td>".$row['budget']. "</td>";
									echo "</tr>";}
									
									echo "</table>";
						?> 		
                
					</div>
			</div>
		</div>
	</div>
</div>             
</body>
</html>