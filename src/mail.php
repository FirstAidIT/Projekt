<?php

include 'database.php';


$sql_mail = "SELECT projekt.projektname, person.name, person.email, projekt.startzeit
FROM projekt, person, Arbeiten_an
WHERE Arbeiten_an.mitarbeiterID = person.mitarbeiterID
AND Arbeiten_an.projektID = projekt.projektID
AND projekt.ist_archiviert is null";

try {
    $stmt_mail = $db -> prepare($sql_mail);
    $stmt_mail->execute();
    
    while ($row = $stmt_mail->fetch()) {
        $projektname=$row['projektname'];
        $name=$row['name'];
        $email=$row['email'];
        $startzeit=$row['startzeit'];
        $cdate = new DateTime($startzeit);
        $today = new DateTime("now");
        $difference = $cdate ->diff($today);
        $days = $difference->d;
        $months = $difference->d;
        $years = $difference->y;

        if ($years == 0 &&  $months == 0 && $days == 14) {

            $betreff = "Projektstart für Projekt:" + $projektname;
            $from = "<absender@domain.de>\r\n";
            $from .= "Reply-To: antwort@domain.de\r\n";
            $from .= "Content-Type: text/html\r\n";
            $text = "Hallo" + $name + "Dein Projekt" + $projektname + "startet in 14 Tagen!";
             
            mail($email, $betreff, $text, $from);   


        }   
      } 
}

catch(PDOException $e) {
    print $e ->getMessage();
}



