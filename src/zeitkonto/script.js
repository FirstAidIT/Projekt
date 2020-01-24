
$(document).ready(() => {
  let timerStatus = false;
  let haveTIme = false;
  let interval = 0;

  $(".clicker").click(() => {
    if (timerStatus === false) {
      timerStatus = true;
      interval = startTimer();
    } else {
      timerStatus = false;
      stopTimer(interval);
      interval = 0;
    }
  });

  let active = false;
  $(".editable").click(() => {
    if (active == false){
      insertTime();

    } else {

    }
  });



  $('#table-editable').on('click', 'tbody tr', (event) => {
    console.log($(this))
     $(event.currentTarget).addClass('selected').siblings().removeClass('selected');
     let value = $('#hours-0').attr('contenteditable');
    $('#hours-0').attr('contenteditable',true);
  });


  
});

    function startTimer() {
      let start = new Date();
      $('.clicker').removeClass('btn-success');
      $('.clicker').addClass('btn-danger');
      const interval = setInterval(() => {
        const date = new Date(new Date() - start);
        const hours = date.getHours() - 1;
        const minutes = date.getMinutes();
        const seconds = date.getSeconds();
        console.log(date.getHours())
        const time = hours + ':' + minutes + ':' + seconds;
        timerStatus = true;
        haveTime = true;
        $("#tracker").text(time);
      }, 1000);
      return interval;
    }

    function stopTimer(interval) {
     clearInterval(interval);
      $('.clicker').removeClass('btn-danger');
      $('.clicker').addClass('btn-success');
    }
    
    function insertTime() {
      active = true;
        document.getElementById("edit").contentEditable = true;
        $('.editbtn').removeClass('btn-outline-success');
        $('.editbtn').addClass('btn-outline-warning');
        $('.editbtn').text('Speichern');
      }

      function saveTime () {
        active = false;
        document.getElementById("edit").contentEditable = false;
        $('.editbtn').removeClass('btn-outline-warning');
        $('.editbtn').addClass('btn-outline-success');
        $('.editbtn').text('Bearbeiten');
      }

     

   

 


