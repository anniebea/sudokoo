/* ---------------------------
*  Constant global variables
*  -------------------------*/
const regEx = /^[0-9a-z]+$/i;
const gridCard = document.getElementById('gridCard');
const grid = document.getElementById('grid');
const coordinates = document.getElementById('coordinates');
const gridCells = document.getElementsByClassName('gridCell');

/**
 *
 * @param event
 */

function preventZoom(event) {
    event.preventDefault();
}

//function for deselecting all cells
function deselectAll() {
    for (let i = 0; i < gridCells.length; i++) {
        gridCells[i].dataset.selected = 'false';
    }
}

function markAllCorrect() {
    for (let i = 0; i < gridCells.length; i++) {
        gridCells[i].dataset.hasError = 'false';
    }
}
