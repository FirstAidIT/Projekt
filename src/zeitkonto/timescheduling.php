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
                        echo '<td style="display:none" contenteditable="false">' . $value["zeitkontoID"] . '</td>';
                        echo '<td class = "select" contenteditable="false">' . $value["zuordnung"] . '</td>';
                        echo '<td contenteditable="false">' . $value["erfassungs_tag"] . '</td>';
                        echo '<td contenteditable="false"" id="hours-' . $row . '">' . $value["stunden_anzahl"] . '</td>';
                        echo '<td contenteditable="false">' . $value["kommentar"] . '</td>';
                        echo '<td ><button type="button" class="btn btn-outline-success btn-edit-modal"  data-toggle="modal" data-target="#myEditModal">Bearbeiten</button></td>';
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
   <div class="container-timer bottom-position">
            <div style="white-space: nowrap;">
            <button style="display: none; margin: 10px;" class="btn btn-danger save-time-btn" data-toggle="modal" data-target="#myModal">
                  <span id="timer-text"> 0:0:0 </span>
                   <i style="display: none;" class="material-icons" id="save-icon">add</i>
            </button>
            <button class="btn bottom-position btn-success btn-time clicker">
                  <i class="material-icons" id="timer-icon">timer</i>
            </button>
            </div>
      </div>


</div>



<!-- The Booking Modal -->
<div class="modal" id="myModal">
   <div class="modal-dialog">
      <div class="modal-content">

         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Stunden erfassen</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
      <form method = "post" action="./src/zeitkonto/create_entry.php">
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
                     <label>Projekt:</label>
                     <select name="zuordnung">
                        <?php
                        if (!empty($projects)) {
                           foreach ($projects as $row) {
                              echo "<option value='" . $row['projektname'] . "'>" . $row['projektname'] . "</option>";
                           }
                        }
                        ?>

                     </select>
                  </div>
                  <div class="form-group mb-3">
                     <label for="Date">Datum:</label>
                     <input type="date" name="erfassungs_tag_zuordenbar" class="form-control" value="<?php echo $today; ?>">
                  </div>
                  <div class="form-group mb-3">
                     <label for="Date">Stunden:</label>
                     <input name="stunden_anzahl_zuordenbar" class="form-control"  id="booking-allocatable-hours">                   
                  </div>
               </div>

               <!-- Start nicht zuordenbar-->

               <div class="tab-pane fade" id="nav-stunden" role="tabpanel" aria-labelledby="nav-stunden-tab">

                  <div class="form-group mb-3">
                     <label for="Date">Datum:</label>
                     <input type="date" name="erfassungs_tag" class="form-control"  value="<?php echo $today; ?>">
                  </div>

                  <div class="form-group mb-3">
                     <label for="Date">Stunden:</label>
                     <input name="Stunden" class="form-control"  id="booking-not-allocatable-hours" >
                  </div>

                  <div class="form-group">
                     <label for="comment">Kommentar:</label>
                     <textarea class="form-control" rows="5" id="comment" ></textarea>
                  </div>

               </div>

            </div>
         </div>

         <!-- Modal Footer -->
         <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="erfassen">Erfassen</button>
         </div>
       </form>

      </div>
   </div>
</div>

         <!-- The Editing Modal -->

<div class="modal" id="myEditModal">
   <div class="modal-dialog">
      <div class="modal-content">

            <!-- Modal Header -->
         <div class="modal-header">
            <h5 class="modal-title">Zeit bearbeiten</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</span>
            </button>
         </div>

         <!-- Modal Body -->

         <div class="modal-body">
            
         <form method="POST" action="src/zeitkonto/update_entry.php">
         
         <input type="hidden" id="zeit-id" name="zeitkontoID" value="">
         
            <div class="form-group mt-3 mb-3">
               <label>Projekt:</label>
               <select name="zuordnung" id="editProjekt">
                  <?php
               if (!empty($projects)) {
                  foreach ($projects as $row) {
                     echo "<option value='" . $row['projektname'] . "'>" . $row['projektname'] . "</option>";
                  }
               }
                  ?>

               </select>
            </div>

            <div class = "form-group mt 3 mb-3">
               <label for="editDate">Datum</label>
               <input type="date" name="erfassungs_tag" class="form-control" ="true" id="zeit-date" value="<?php echo $today; ?>">
            </div>

            <div class="form-group mb-3">
            <label for="date">Stunden:</label>
            <input name="stunden_anzahl" class="form-control" id="zeit-hours" ="true">
         </div>

         <div class="form-group">
            <label for="comment">Kommentar:</label>
            <textarea name="kommentar" class="form-control" rows="5" id="kommentar" ></textarea>
         </div>
         </div>

            <!-- Modal Footer -->

         <div class="modal-footer">
            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
            <button type="submit" name="update" class="btn btn-primary">Änderungen speichern</button>
         </div>
         </form>
      </div>
   </div>
</div>