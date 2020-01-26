
$(document).ready(() => {
  let isStarted = false;
  let isPaused = false;
  let isResumed = false;
  let time;
  let interval = 0;

  $(".clicker").click(() => {
    if (!isStarted && !isPaused && !isResumed) {
      isStarted = true;
      [interval, time] = startTimer();
    } else if (isPaused) {
      isPaused = false;
      isResumed = true;
      [interval, time] = resumeTimer(time);
    } else {
      isPaused = true;
      isResumed = false;
      pauseTimer(interval);
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

  $('#table-editable').on('click', 'button.btn-edit-modal',function (ele) {
    //the <tr> variable is use to set the parentNode from "ele
    const tr = ele.target.parentNode.parentNode;

    //I get the value from the cells (td) using the parentNode (var tr)
    const id = tr.cells[0].textContent;
    const date = new Date(tr.cells[2].textContent);
    const day =  date.getDate() < 10 ? ("0" + date.getDate()).slice(-2) : date.getDate().toString().slice(-2);
    console.log(day)
    const month =  (date.getMonth() + 1) < 10 ?  ("0" + (date.getMonth() + 1)).slice(-2) : (date.getMonth() + 1).toString().slice(-2);
    console.log(month)
    const formattedDate = date.getFullYear()+"-"+(month)+"-"+(day) ;
    console.log(formattedDate)
    const hours = tr.cells[3].textContent;
    const comment = tr.cells[4].textContent;
    console.log(id);

    //Prefill the fields with the gathered information
    $('#zeit-id').val(id);
    $('#zeit-hours').val(hours);
    $('#zeit-comment').val(comment);
    $('#zeit-date').val(formattedDate);
  });

  $('.container-timer').on('click', 'button.save-time-btn',function (ele) {
    //the <tr> variable is use to set the parentNode from "ele
    const tr = ele.target.parentNode.parentNode;
    const id = $('#timer-text').text();
    //I get the value from the cells (td) using the parentNode (var tr)
    console.log(id);

    //Prefill the fields with the gathered information
    $('#booking-not-allocatable-hours').val(id);
    $('#booking-allocatable-hours').val(id);
  });



  
});

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
        const hours = time.getHours() - 1;
        const minutes = time.getMinutes();
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

      function saveTime () {
        active = false;
        document.getElementById("edit").contentEditable = false;
        $('.editbtn').removeClass('btn-outline-warning');
        $('.editbtn').addClass('btn-outline-success');
        $('.editbtn').text('Bearbeiten');
      }

      function edit(){ 
        var par = $(this).parent().parent(); //tr 
        var tdProjekt = par.children("td:nth-child(1)"); 
        var tdstunden_anzahl = par.children("td:nth-child(3)"); 
        
        tdProjekt.html("<input type='text' id='txProjekt' value='"+tdProjekt.html()+"'/>"); 
        tdstunden_anzahl.html("<input type='text' id='txtstunden_anzahl' value='"+tdstunden_anzahl.html()+"'/>"); 
        
 
        $(".btnEdit").bind("click", Edit); 
        $(".btnSave").bind("click", Save); 

      };

      function save(){ 
        var par = $(this).parent().parent(); //tr 
        var tdProjekt = par.children("td:nth-child(1)"); 
        var tdstunden_anzahl = par.children("td:nth-child(3)"); 
         
         tdProjekt.html(tdProjekt.children("input[type=text]").val()); 
         tdstunden_anzahl.html(tdstunden_anzahl.children("input[type=text]").val()); 



         $(".btnEdit").bind("click", Edit); 
        };





      $(function(){ 
        //A Edit and Save  functions code 
        $(".btnEdit").bind("click", edit); 
        $(".btnSave").bind("click", save); 
        });



     

   

 


