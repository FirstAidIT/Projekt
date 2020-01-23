<html>
<head>
<title>My Website</title>

</head>
<body> 

<?php

require_once("config.php");
require_once("script.php");

$link = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname, $dbport);

if (!$link) {
    echo "Fehler: konnte nicht mit MySQL verbinden." . PHP_EOL;
    echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debug-Fehlermeldung: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Erfolg: es wurde ordnungsgemäß mit MySQL verbunden! Die Datenbank \"datenbank\" ist toll." . PHP_EOL;
echo "Host-Informationen: " . mysqli_get_host_info($link) . PHP_EOL;

//mysqli_close($link);

?>

<form method="post" action="">
	<input type="submit" name="sent">
</form>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      ...
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>