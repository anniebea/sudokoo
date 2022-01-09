/**
 * Generate a cell in div "div" with id "id"
 *
 * @param div
 * @param id
 * @param given
 */
function generateCell(div, id, given) {
    let cell = document.createElement('div');
    cell.id = id;
    cell.className = 'gridCell';
    cell.dataset.selected = 'false';
    cell.dataset.hasError = 'false';
    cell.dataset.given = given;
    cell.dataset.penMark = '';
    cell.dataset.pencilMarks = '';
    cell.dataset.pencilCount = '0';
    div.appendChild(cell);
}

/*
* Generate event listeners for all cells, listens to clicks on cells
*/
function generateEventListeners() {
    let gridCells = document.getElementsByClassName('gridCell');

    //Generate event listeners for all cells, listens to clicks on cells
    for (let i = 0; i < gridCells.length; i++) {
        gridCells[i].addEventListener('click', function() {
            selectCell(gridCells[i]);
        }, false);
    }

    //Generate event listener that listens to key input
    window.addEventListener('keyup', function() {
        inputHandler(event.key)
    }, false);

    //Generate event listener that listens for when a user clicks outside the grid card
    window.addEventListener('click', function () {
        let clickedElement = event.target;
        if (!document.getElementById('gridCardBody').contains(clickedElement)) {
            deselectAll();
        }
    });

    loadWindoku();
}


/**
 * Generate a 3x3 grid of sudoku, with outline ring of cells for other SudokuGrid clues
 *
 * @param contentArray
 */
function generate3x3(contentArray = []) {
    let grid = document.getElementById("grid");
    let id;
    let row;
    let given;

    for (let i=0; i<11; i++) {
        row = document.createElement('div');
        row.className = 'row justify-content-center mx-auto';
        grid.appendChild(row);

        for (let j=0; j<11; j++) {
            id = 'cell';
            given = '';
            if (i<10) {
                if(j<10) {
                    id = id + '0' + i + '0' + j;
                }
                else {
                    id = id + '0' + i + j;
                }
            }
            else {
                if(j<10) {
                    id = id + i + '0' + j;
                }
                else {
                    id = id + i + j;
                }
            }

            if (contentArray.length > 0) {
                for (let i = 0; i < contentArray.length; i++) {
                    if (contentArray[i][0] == id) {
                        given = contentArray[i][1];
                    }
                }
            }
            generateCell(row,id,given);
        }
    }
    generateEventListeners();
}
