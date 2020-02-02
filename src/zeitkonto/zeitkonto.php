
<!DOCTYPE html>
<html lang="de">
  <head>
    <!-- Required Meta tags -->
     <meta charset = 'utf-8'>
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
     <link rel="stylesheet" href="css/zeitkonto.css">
     
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
      html {
        height: 100%;
      }
      body {
        height: 100%;
      }
    table, th, td {
      border: 1px solid white;
    }

    .bottom-position {
    position: fixed;
    bottom: 5%;
    right: 5%;
    }

    .bottom-settime {
      right: 5%;
    }

    .btn-time {
      border-radius: 100%;
      width: 60px;
      height: 60px;
      box-shadow: 0px 1px 1px 1px rgba(202, 202, 202, 0.3);
    }

    .btn-timer-clicked {
      border-radius: 40px;
      height: 60px;
      width: 140px;
      box-shadow: 0px 1px 1px 1px rgba(202, 202, 202, 0.3);
    }


    .btn-time, i {
      font-size: 30px;
    }

    .selected {
      background: #e0e0e0;
    }

    
    </style>
    <!-- JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js" integrity="sha384- EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1" crossorigin="anonymous"></script>
    <script src="script.js" type="text/javascript"></script>
    <script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
    <link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
</head>
<body>
  <?php 
    include 'check_login.php';
    include_once ('timescheduling.php') 
  ?>
</body>
</html>
