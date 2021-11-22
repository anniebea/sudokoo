/**
 * Add character 'key' into cell 'cell', if possible.
 *
 * @param cell
 * @param key
 */

function cellInput(cell, key, mode) {
    let testArea = document.getElementById('testArea');
    if (mode == 'editing') {
        if (key === 'Delete') {
            cell.dataset.given = '';
            if (getBox3x3(cell.id) > 0) {
                classicValidator3x3(cell);
            }
        }
        else if (key === 'Backspace') {
            cell.dataset.given = cell.dataset.given.slice(0,cell.dataset.given.length-1);
            if (getBox3x3(cell.id) > 0) {
                classicValidator3x3(cell);
            }
        }
        else if (key.length == 1){
            if (getBox3x3(cell.id) > 0) {
                if (!isNaN(key) && key != 0) {
                    if (cell.dataset.given == key) {
                        cell.dataset.given = '';
                    }
                    else {
                        cell.dataset.given = key;
                    }
                    classicValidator3x3(cell);
                }
            }
            else {
                if (cell.dataset.given.length < 2) {
                    cell.dataset.given = cell.dataset.given + key;
                }
            }
        }
    }
    else { //mode = 'solving'
        if (getBox3x3(cell.id) > 0) {
            if (cell.dataset.given === '') {
                if (key === 'Backspace' || key === 'Delete') {
                    cell.dataset.penMark = '';
                    classicValidator3x3(cell);
                }
                else if (key.length == 1 && !isNaN(key) && key != 0) {
                    if (cell.dataset.penMark == key) {
                        cell.dataset.penMark = '';
                    }
                    else {
                        cell.dataset.penMark = key;
                    }
                    classicValidator3x3(cell);
                }
            }
        }
    }
}
