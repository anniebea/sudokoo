const timerTimeout = setInterval(addSecond, 1000);
let totalTime = 0;

/**
 * Function to add a second to displayed timer, with logic to convert to minutes and hours.
 */
function addSecond() {
    totalTime++;
    let hours = Math.floor(totalTime/3600);
    let minutes = Math.floor(totalTime/60) - (hours*60);
    let seconds = totalTime - (hours*3600 + minutes*60);
    let timer = document.getElementById('timer');

    timer.innerHTML = hours + ':';
    if (minutes<10) timer.innerHTML += '0';
    timer.innerHTML += minutes + ':';
    if (seconds<10) timer.innerHTML += '0';
    timer.innerHTML += seconds;
}

function stopTimer() {
    document.getElementById('finalTime').innerHTML = document.getElementById('timer').innerHTML;
    clearTimeout(timerTimeout);
}
