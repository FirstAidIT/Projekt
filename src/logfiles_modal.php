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
	<link rel="stylesheet" type="text/css" href="login.css">
	<!-- Javascript -->
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<script src="functions.js"></script>
	
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
	 <div class="container"><br> <br> <br>
		<div class="row">
			<div class="col d-flex justify-content-center">
				 <div class="form-input">
					<button type="button"  class="btn btn-dark custom-btn" data-toggle="modal" data-target=".bd-example-modal-lg1">Logfile Skillveränderung</button>
						<!--beginn Modal 1 -->
						<div class="modal fade bd-example-modal-lg1" id="skill" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modal-skill">Skillveränderungen</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
									</div>
									<div class="modal-body-skill">			   
									</div>
									<div class="modal-footer">
									</div>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
<br> <br> <br>
		<div class="row">
			<div class="col d-flex justify-content-center">
				<div class="form-input">
				<button type="button"  class="btn btn-dark custom-btn" data-toggle="modal" data-target=".bd-example-modal-lg2">Logfile Projektanläufe </button>
					<div class="modal fade bd-example-modal-lg2" id="project" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="modal-project">Neuaufgenommene Projekte</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
								</div>
								<div class="modal-body-project">			   
								</div>
							<div class="modal-footer">
							</div>
							</div>
						</div>
					</div>
				</div>  
		   </div>
		</div>
	</div>
</body>
</html>