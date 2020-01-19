<?php
include '../datenbank/db_connection.php'; 
include 'get_entries.php'; 
?> 

<div class = "container">
<h2>Zeiterfassung</h2>
<p>Hier können Sie Ihre persönlichen Zeiten erfassen und ändern</p>
<table class = "table table-striped">
<tr>
    <th>Kunde</th>
    <th>Projekt</th>
  <!--  <th>Projektdauer</th> -->
    <th>Gebuchte Stunden insgesamt</th>
    <th contenteditable='true'>aktuelle Stunden</th>
    <th>Zeit erfassen</th>
</tr>
<?php 
if (!empty($result)){ 
   foreach ($result as $row) {
         echo '<tr>';
         echo '<td>'.$row["zuordnung"].'</td>';
         echo '<td>'.$row["zuordnung"].'</td>';
        // echo '<td>'.$row["Projektdauer"].'</td>';
         echo '<td>'.$row["stunden_anzahl"].'</td>';
         echo '<td class="tracker"> 00:00 </td>';
         echo '<td><button class ="btn btn-success clicker">Zeiterfassung starten</button></td>';
         echo '</tr> ';
   } 
}
?>
</table>

   <button class= "btn btn-success"  data-toggle = "modal" data-target="#myModal">Nicht zuordenbare Stunden</button>

   <!-- The Modal -->
   <div class ="modal" id ="myModal">
      <div class ="modal-dialog">

         <div class = "modal-content">
               <!-- Modal Header -->
               <div class = "modal-header">
                  <h4 class = "modal-title">Stunden erfassen</h4>
                  <button type ="button" class = "close" data-dismiss="modal">&times;</button>
               </div>
               <form method = "post" action="create_entry.php">
             <!-- Modal Body -->
               <div class = "modal-body">
               <div class = "input-group mb-3 input-group-sm" >
                     <div class = "input-group-prepend">
                        <span class= "input-group-text">Datum</span>
                     </div>
                     <input type ="date" name = "Erfassungstag" class = "form-control" required = "true">
                  <div class = "input-group mb-3 input-group-sm" >
                     <div class = "input-group-prepend">
                        <span class= "input-group-text">Arbeitszeit</span>
                     </div>
                     <input type ="time" name="Stunden" class="form-control" required = "true">
                  </div>
                  <div class = "input-group mb-3 input-group-lg">
                     <div class = "input-group-prepend">
                        <span class = "input-group-text">Kommentar</span>
                     </div>
                     <input type ="text" name="Kommentar" id="Kommentar" class="form-control" required = "true">
                  </div>
         </div>
           
         <!-- Modal Footer -->
         <div class = "modal-footer">
            <button type ="submit" class="btn btn-success"  name="Erfassen">Erfassen</button>
         </div>
         </form>
   </div>  
</div>