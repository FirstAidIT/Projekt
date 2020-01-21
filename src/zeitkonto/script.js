
$(document).ready(function() {
  let timerStatus = false;
  let interval = 0;

  $(".clicker").click(function () {
    if (timerStatus === false) {
        timerStatus = true;
        interval = startTimer();
      } else {
        timerStatus = false;
        stopTimer(interval);
        interval = 0;
      }
    });


});


function startTimer() { 
  let start = new Date();  
  const interval = setInterval(() => {
      const date = new Date(new Date() - start);
      const hours = date.getHours() - 1;
      const minutes = date.getMinutes();
      const seconds = date.getSeconds();
      console.log(date.getHours())
      const time = hours + ':' + minutes + ':' + seconds;
      timerStatus = true;
      $('.tracker').text(time);
      $('.clicker').text('Zeiterfassung stoppen');
      $('.clicker').removeClass('btn-success');
      $('.clicker').addClass('btn-danger');
  }, 1000);
  return interval;
}

   

function stopTimer(interval) {
    clearInterval(interval); 
    $('.clicker').text('Zeiterfassung starten');
    $('.clicker').removeClass('btn-danger');
    $('.clicker').addClass('btn-success');
  }



