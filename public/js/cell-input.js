/**
 * Add character 'key' into cell 'cell', if possible.
 *
 * @param cell
 * @param key
 * @param mode
 */
function cellInput(cell, key, mode) {
    if (mode == 'editing') {
        if (key === 'Delete') {
            cell.dataset.given = '';
            if (getBox3x3(cell.id) > 0) {
                validator3x3(cell);
            }
        }
        else if (key === 'Backspace') {
            cell.dataset.given = cell.dataset.given.slice(0,cell.dataset.given.length-1);
            if (getBox3x3(cell.id) > 0) {
                validator3x3(cell);
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
                    validator3x3(cell);
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
                if (document.getElementById('penBtn').ariaPressed == 'true') {
                    if (key === 'Backspace' || key === 'Delete') {
                        cell.dataset.penMark = '';
                        validator3x3(cell);
                    }
                    else if (key.length == 1 && !isNaN(key) && key != 0) {
                        if (cell.dataset.penMark == key) {
                            cell.dataset.penMark = '';
                        }
                        else {
                            cell.dataset.penMark = key;
                        }
                        validator3x3(cell);
                    }
                }
                else if (document.getElementById('pencilBtn').ariaPressed == 'true') {
                    if (cell.dataset.penMark === '') {
                        if (key === 'Backspace' || key === 'Delete') {
                            cell.dataset.pencilMarks = '';
                        }
                        else if (key.length == 1 && !isNaN(key)) {
                            if (cell.dataset.pencilMarks.includes(key)) {
                                cell.dataset.pencilMarks = cell.dataset.pencilMarks.replace(key,''); //remove number from pencil mark string
                            }
                            else {
                                cell.dataset.pencilMarks += key;
                                let pencilMarkArray = cell.dataset.pencilMarks.split('');
                                pencilMarkArray.sort();
                                cell.dataset.pencilMarks = pencilMarkArray.join('');
                            }
                        }
                        cell.dataset.pencilCount = '' + cell.dataset.pencilMarks.length;
                    }
                }
            }
        }
    }
}
