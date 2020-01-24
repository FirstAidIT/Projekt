<?php
include 'datenbank/db_connection.php';
include 'get_entries.php';
?>

<div class="container h-100">
   <div class="row">

      <div class="col-12">
         <h2>Zeiterfassung</h2>
      </div>

   </div>

   <div class="row">

      <div class="col-3 offset-9 pb-3 text-right">
         <button class="btn btn-success bottom-settime" data-toggle="modal" data-target="#myModal">Zeit erfassen</button>
      </div>

   </div>

   <div class="row">
      <div class="col-3 offset-9 pb-3">
         <div class="card" style="width: 8rem;">
            <div class="card-body">
               <p class="card-text text-center" id="tracker">00:00:00</p>
               <button class="btn btn-success bottom-settime" data-toggle="modal" data-target="#myModal">Buchen</button>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-12 pb-3">
         <div class="card">
            <div class="card-header text-light bg-success">Projektübersicht</div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>Kunde</th>
                        <th>Projekt</th>
                        <th>Projektende</th>
                        <th>Gebuchte Stunden insgesamt</th>
                     </tr>
                  </thead>
                  <?php
                  if (!empty($result)) {
                     foreach ($result as $row) {
                        echo '<tr>';
                        echo '<td contenteditable="false">' . $row["Kunde"] . '</td>';
                        echo '<td contenteditable="false">' . $row["zuordnung"] . '</td>';
                        echo '<td contenteditable="false">' . $row["endzeit"] . '</td>';
                        echo '<td contenteditable="false">' . $row["stunden_gesamt"] . '</td>';
                        echo '</tr> ';
                     }
                  }
                  ?>
               </table>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-12 pb-3">
         <div class="card mt-3">
            <div class="card-header text-light bg-success">Zeiterfassung - Wochenübersicht</div>
            <div class="card-body">
               <table class="table table-hover" id="table-editable">
                  <thead>
                     <tr>
                        <th>Projekt</th>
                        <th>Datum</th>
                        <th>Gebuchte Stunden</th>
                        <th>Kommentar</th>
                        <th></th>
                     </tr>
                  </thead>
                  <?php
                  if (!empty($result2)) {
                     foreach ($result2 as $row => $value) {
                        echo '<tr>';
                        echo '<td contenteditable="false">' . $value["zuordnung"] . '</td>';
                        echo '<td contenteditable="false">' . $value["erfassungs_tag"] . '</td>';
                        echo '<td class="editable-td" id="hours-' . $row . '">' . $value["stunden_anzahl"] . '</td>';
                        echo '<td contenteditable="false">' . $value["kommentar"] . '</td>';
                        echo '<td contenteditable="false"><button type="button" class="btn btn-outline-success editbtn">Bearbeiten</button></td>';
                        echo '</tr> ';
                     }
                  }
                  ?>
               </table>
            </div>
         </div>
      </div>
   </div>

   <!-- Time Tracker -->
   <button class="btn active btn-success bottom-position btn-time clicker">
      <i class="material-icons">timer</i></button>


</div>



<!-- The Modal -->
<div class="modal" id="myModal">
   <div class="modal-dialog">
      <div class="modal-content">

         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Stunden erfassen</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>

         <!-- Modal Body -->
         <div class="modal-body">
            <nav>

               <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-projekt-tab" data-toggle="tab" href="#nav-projekt" role="tab" aria-controls="nav-projekt" aria-selected="true">Projekterfassung</a>
                  <a class="nav-item nav-link" id="nav-stunden-tab" data-toggle="tab" href="#nav-stunden" role="tab" aria-controls="nav-stunden" aria-selected="false">Nicht zurechenbare Stunden</a>
               </div>

            </nav>

            <div class="tab-content" id="nav-tabContent">
               <div class="tab-pane fade show active" id="nav-projekt" role="tabpanel" aria-labelledby="nav-projekt-tab">
                  <div class="form-group mt-3 mb-3">
                     <label for="sel1">Projekt:</label>
                     <select name="Projekts">

                        <?php
                        while ($row = $stmt->fetch()) {
                           echo "<option value='" . $row['zuordnung'] . "'>" . $row['zuordnung'] . "</option>";
                        }
                        ?>

                     </select>

                  </div>

                  <div class="form-group mb-3">
                     <label for="Date">Datum:</label>
                     <input type="date" name="Erfassungstag" class="form-control" required="true" value="<?php echo $today; ?>">
                  </div>

                  <div class="form-group mb-3">
                     <label for="Date">Stunden:</label>
                     <input name="Stunden" class="form-control" required="true" id="modal_timer">
                  </div>

               </div>

               <div class="tab-pane fade" id="nav-stunden" role="tabpanel" aria-labelledby="nav-stunden-tab">

                  <div class="form-group mb-3">
                     <label for="Date">Datum:</label>
                     <input type="date" name="Erfassungstag" class="form-control" required="true" value="<?php echo $today; ?>">
                  </div>

                  <div class="form-group mb-3">
                     <label for="Date">Stunden:</label>
                     <input name="Stunden" class="form-control" required="true">
                  </div>

                  <div class="form-group">
                     <label for="comment">Kommentar:</label>
                     <textarea class="form-control" rows="5" id="comment"></textarea>
                  </div>

               </div>

            </div>
         </div>

         <!-- Modal Footer -->
         <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="Erfassen">Erfassen</button>
         </div>

      </div>
   </div>
</div>