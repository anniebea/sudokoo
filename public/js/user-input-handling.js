/**
 * Main function for handling key and number button presses by user.
 *
 * @param key
 */
function inputHandler(key) {
    let cell = getSelectedCell();

    if (cell != -1) { //if a cell has been selected
        let grid = document.getElementById('grid');
        if (key == ' ') {
            let penBtn = document.getElementById('penBtn').ariaPressed;
            if (penBtn == 'true') {
                modeSwitch('pencil');
            }
            else {
                modeSwitch('pen');
            }
        }
        else if (grid.dataset.mode == 'solving') {
            if (cell.dataset.given == '') {
                if (key === 'ArrowUp' || key === 'ArrowDown' || key === 'ArrowLeft' || key === 'ArrowRight') {
                    if(getBox3x3(cell.id) > 0) {
                        gridNavigate(cell, key);
                    }
                } else {
                    cellInput(cell, key, grid.dataset.mode);
                }
            }
            else {
                if (key === 'ArrowUp' || key === 'ArrowDown' || key === 'ArrowLeft' || key === 'ArrowRight') {
                    if(getBox3x3(cell.id) > 0) {
                        gridNavigate(cell, key);
                    }
                }
            }
        }
        else {
            if (key === 'ArrowUp' || key === 'ArrowDown' || key === 'ArrowLeft' || key === 'ArrowRight') {
                if(getBox3x3(cell.id) > 0) {
                    gridNavigate(cell, key);
                }
            } else {
                cellInput(cell, key, grid.dataset.mode);
            }
        }
    }
}

/**
* Main function for handling of clicks on cells.
*/
function selectCell(cell) {
    if(cell.dataset.selected === 'true') {
        cell.dataset.selected = 'false';
        coordinates.innerHTML = 'r0c0 / row: 0 column: 0 box: 0';
    }
    else {
        deselectAll();
        getBox3x3(cell.id);
        cell.dataset.selected = 'true';
        coordinates.innerHTML = 'r' + getRow(cell.id).slice(1,2) + 'c' + getColumn(cell.id).slice(1,2) + ' / row: ' +  getRow(cell.id).slice(1,2) + ' column: ' + getColumn(cell.id).slice(1,2) + ' box: ' + getBox3x3(cell.id);
    }
}

/**
 * Function for deselecting all cells
 *
 */
function deselectAll() {
    for (let i = 0; i < gridCells.length; i++) {
        gridCells[i].dataset.selected = 'false';
    }
}

/**
 * Function gets selected cell, returns -1 if no cell is selected
 *
 * @returns {number|Element}
 */
function getSelectedCell() {
    let gridCells = document.getElementsByClassName('gridCell');
    for (let i = 0; i < gridCells.length; i++) {
        if (gridCells[i].dataset.selected === 'true') {
            return gridCells[i];
        }
    }
    return -1;
}

/**
 * Input mode selection.
 */
function modeSwitch(mode) {
    let onBtn = mode + 'Btn'; //button to be turned on
    document.getElementById('penBtn').ariaPressed = 'false';
    document.getElementById('pencilBtn').ariaPressed = 'false';

    document.getElementById(onBtn).ariaPressed = 'true';

}
