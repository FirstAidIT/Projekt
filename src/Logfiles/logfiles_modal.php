<?php
	require_once('db.php');
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
	<!-- Javascript -->
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<script src="functions.js"></script>
	
</head>

<body> 

	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".bd-example-modal-lg1">Logfile Skillveränderung</button>
	<br>

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
	<br>

<button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".bd-example-modal-lg2">Logfile Projektanläufe </button>
	<br><br><br>

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
	<br><br><br>

</body>
</html>