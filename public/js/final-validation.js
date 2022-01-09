/**
 * Validate grid one last time to
 */
function validatePostFinish() {
    let isCorrect = true;
    let cellID;

    for (let x = 1; x <= 9; x++) {
        for (let y = 1; y <= 9; y++) {
            cellID = 'cell0' + x + '0' + y;
            if (document.getElementById(cellID).dataset.hasError == 'true') {
                isCorrect = false;
            }
            if (document.getElementById(cellID).dataset.given == '') {
                if (document.getElementById(cellID).dataset.penMark == '') {
                    isCorrect = false;
                }
            }
        }
    }

    if (isCorrect) {
        document.getElementById('finishBtn').disabled = true;
        stopTimer();
        $('#successModal').modal('show');
    }
    else {
        $('#failureModal').modal('show');
        document.getElementById('finishBtn').ariapressed = false;
    }
}
