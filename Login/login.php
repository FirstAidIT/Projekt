<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
 
if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
        die(header("location: start.php"));
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br><br>";
    }
    
}
?>
<!DOCTYPE html> 
<html> 
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>LOGIN</title>
        <link rel="stylesheet" type="text/css" href="page_login.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

    <body>
 
<?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
    <div class="jumbotron text-center">
            Login
    </div>
    <div class="container">
            <div class="row d-flex justify-content-center">
                <label class="header">Bitte loggen Sie sich mit Ihren Zugangsdaten ein</label>
            </div>

            <div class="row">
                <div class="col d-flex justify-content-center">
                    <form action="?login=1" method="post">
                        <div class="form-label">
                            <label>E-Mailadresse</label>
                        </div>
                        <div class="form-input">
                            <input type="email" size="60" maxlength="250" name="email">
                        </div>
                        <div class="form-label">
                            <label>Passwort</label>
                        </div>
                        <div class="form-input">
                            <input type="password" size="60"  maxlength="250" name="passwort">
                        </div>
                        <button type="submit" value="Abschicken" class="btn btn-dark">Anmelden</button><br>
                    </form>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="reset">
                        <label>Haben Sie Ihre Anmeldedaten vergessen?</label>
                        <label>Fordern Sie jetzt Hilfe von Ihrem Vorgesetzten an</label><br>
                        <form action="">
                        <button type="submit" class="btn btn-dark">Hilfe anfordern</button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
   
    

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>        
    </body>
</html>