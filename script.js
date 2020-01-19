
$(document).ready(function() {
  $(".clicker").click(function () {
    let start = new Date;
    setInterval(function() {
        const date = new Date(new Date() - start);
        const hours = date.getHours();
        const minutes = date.getMinutes();
        const seconds = date.getSeconds();
        console.log(date.getTime())
        const time = hours + ':' + minutes + ':' + seconds;
        $('.tracker').text(time);
        $('.clicker').text('Zeiterfassung stoppen');
        $('.clicker').css('background', 'red');
    }, 1000);
  });
});

