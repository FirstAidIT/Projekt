
$(document).ready(() => {
  let isStarted = false;
  let isPaused = false;
  let isResumed = false;
  let time;
  let interval = 0;
  let hours = 0;

//Timer auslöser 
  $(".clicker").click(() => {
    if (!isStarted && !isPaused && !isResumed && hours < 1) {
      isStarted = true;
      [interval, time] = startTimer();
    }
     else if (isPaused) {
      isPaused = false;
      isResumed = true;
      [interval, time] = resumeTimer(time);
    } 
    else {
      isPaused = true;
      isResumed = false;
      pauseTimer(interval);
      interval = 0;
    }
  });

  //Tabelle bearbeiten 
  $('#table-editable').on('click', 'button.btn-edit-modal',function (ele) {
    //the <tr> variable is use to set the parentNode from "ele
    const tr = ele.target.parentNode.parentNode;

    // Zelleninhalt holen
    const id = tr.cells[0].textContent;
    const projekt = tr.cells[1].textContent;
    const bookedHours = tr.cells[3].textContent;
    const comment = tr.cells[4].textContent;
    console.log(id);

    var date = new Date(tr.cells[2].textContent);
     var day = date.getDate(),
    month = date.getMonth() + 1,
    year = date.getFullYear(),
    month = (month < 10 ? "0" : "") + month;
    day = (day < 10 ? "0" : "") + day;
    var formattedDate = year + "-" + month + "-" + day;
    

    //Modal mit Inhalt füllen
    $('#zeit-id').val(id);
    $('#editProjekt').val(projekt);
    $('#zeit-hours').val(bookedHours);
    document.getElementById('zeit-date').value = formattedDate; 
    $('#comment2').val(comment);
    
  }); 


  $('.container-timer').on('click', 'button.save-time-btn',function (ele) {
    const tr = ele.target.parentNode.parentNode;
    const id = $('#timer-text').text();
    console.log(id);

    //Zeit im Zeit buchen Modal anzeigen
    $('#booking-not-allocatable-hours').val(id);
    $('#booking-allocatable-hours').val(id);
  });


  
});
//Timerfunktionen 
    function startTimer() {
      const start = new Date();
      let time = start;
      $('.clicker').removeClass('btn-success');
      $('.clicker').addClass('btn-danger');
      $('#timer-icon').text('pause');
      $('.container-timer').addClass('btn-danger btn-timer-clicked');
      $('.save-time-btn').show();
      const interval = setInterval(() => {
        time = new Date(new Date() - start);
        hours = time.getHours() - 1;
        const minutes = time.getMinutes();
        if (hours >= 1) {
          alert("Du hast deine maximale Arbeitszeit von 10h überschritten");
          pauseTimer(interval);
        }
        const seconds = time.getSeconds();
        const timeAsString = hours + ':' + minutes + ':' + seconds;
        $("#timer-text").text(timeAsString);
        return [interval, time];
      }, 1000);
      return [interval, time];
    }

    function stopTimer(interval) {
     clearInterval(interval);
      $('.clicker').removeClass('btn-danger');
      $('.clicker').addClass('btn-success');
      $('#timer-icon').text('play_arrow');
      $('.container-timer').removeClass('btn-danger btn-timer-clicked');
      $('.save-time-btn').hide();
    }

    function pauseTimer(interval) {
       clearInterval(interval);
       $('#timer-icon').text('play_arrow');
       $('#timer-text').hide();
       $('#save-icon').show();
     }

     function resumeTimer(oldTime) {
       console.log(oldTime);
      const start = new Date();
      const difference = new Date(start - oldTime);
      console.log(start);
      console.log(difference);
      $('#timer-icon').text('pause');
      $('#timer-text').show();
      $('#save-icon').hide();
      const interval = setInterval(() => {
        const now = new Date(new Date() - start);
        console.log(now);
        const newDate = new Date(now.getTime() + difference.getTime());
        console.log(newDate);
        const hours = newDate.getHours() - 1;
        const minutes = newDate.getMinutes();
        const seconds = newDate.getSeconds();
        const time = hours + ':' + minutes + ':' + seconds;
        isStarted = true;
        haveTime = true;
        $("#timer-text").text(time);
        
        return [interval, newDate];
      }, 1000);
      return [interval, start];
    }
    
    function insertTime() {
      active = true;
        document.getElementById("edit").contentEditable = true;
        $('.editbtn').removeClass('btn-outline-success');
        $('.editbtn').addClass('btn-outline-warning');
        $('.editbtn').text('Speichern');
      }

    





        



     

   

 


