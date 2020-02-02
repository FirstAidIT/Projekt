<?php
include 'check_login.php';
include 'database.php';

SESSION_START();
/*$_SESSION['userid'] = $mitarbeiterID;

    

    if(ISSET($_POST['erfassen'])){


            $zuordnung = $_POST['zuordnung'];
            $kunden_abfrage = $conn->prepare("SELECT kunde FROM projekt WHERE projektname ='$zuordnung'");
            $kunden_abfrage -> execute();

            $kunde = $kunden_abfrage->fetchColumn();

            
            
          
            $erfassungs_tag = $_POST['erfassungs_tag_zuordenbar'];
            $stunden_anzahl = calculateTime($_POST['stunden_anzahl_zuordenbar']);

            $create_allocate = "INSERT INTO zeitkonto SET zuordnung=?, kunde=?, erfassungs_tag=?, stunden_anzahl=?, mitarbeiterID=?";


            $stmt_update = $conn->prepare($create_allocate);
            $stmt_update->execute([$zuordnung, $kunde, $erfassungs_tag , $stunden_anzahl, $mitarbeiterID ]);
           header("location: zeitkontostart.php");
            }

    if(ISSET($_POST['erfassen2'])) {
        $erfassungs_tag = $_POST['erfassungs_tag'];
        $stunden_anzahl = calculateTime($_POST['stunden_anzahl']);
        $kommentar = $_POST['kommentar'];

        $create_no_allocate = "INSERT INTO zeitkonto SET erfassungs_tag=?, stunden_anzahl=?, kommentar=?, mitarbeiterID=?";

        $stmt_update = $conn->prepare($create_no_allocate);
        $stmt_update->execute([$erfassungs_tag , $stunden_anzahl, $kommentar, $mitarbeiterID ]);
        header("location: zeitkontostart.php");
    }

    

    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
      }
    
    function calculateTime( $stunden_anzahl ) {
        $zeit = strtotime($stunden_anzahl);
        console_log( "START" );
        console_log( $zeit );

        $minuten_gerundet = ceil(date('i', $zeit)/15)*15; 

        console_log( "Minutes" );
        console_log( $minuten_gerundet );

        if ($minuten_gerundet >= 60) {
            $stunden = $zeit + 60*60;
            console_log( "Stunden" );
            console_log( $stunden );
            $stunden_neu = date('H', $stunden);
            console_log( "Stunden neu" );
            console_log( $stunden_neu );
            $stunden_anzahl = date('H:i:s', $stunden_neu);  

            console_log( "Größer 60" );
            console_log( $stunden_anzahl );

        } else {
            $stunden = date('H', $zeit);
            console_log( "Stunden" );
            console_log( $stunden );
            $minuten = date('i', $minuten_gerundet * 60);
            console_log( $minuten );
            $stunden_anzahl = $stunden.":".$minuten.":0";

            console_log( "Kleiner 60" );
            console_log( $stunden_anzahl );
        }
        return $stunden_anzahl;
    }

  */

?>