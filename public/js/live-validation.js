/**
 * Return which box a cell with ID "cellID" belongs to.
 *
 * @param cellID
 * @returns {number}
 */
function getBox3x3(cellID) {
    let id = getID(cellID);
    let row = getRow(cellID);
    let column = getColumn(cellID);
    let box;

    switch(row) {
        case '01':
        case '02':
        case '03':
            switch(column) {
                case '01':
                case '02':
                case '03':
                    box = 1;
                    break;
                case '04':
                case '05':
                case '06':
                    box = 2;
                    break;
                case '07':
                case '08':
                case '09':
                    box = 3;
                    break;
                default:
                    box = -1;
            }
            break;
        case '04':
        case '05':
        case '06':
            switch(column) {
                case '01':
                case '02':
                case '03':
                    box = 4;
                    break;
                case '04':
                case '05':
                case '06':
                    box = 5;
                    break;
                case '07':
                case '08':
                case '09':
                    box = 6;
                    break;
                default:
                    box = -1;
            }
            break;
        case '07':
        case '08':
        case '09':
            switch(column) {
                case '01':
                case '02':
                case '03':
                    box = 7;
                    break;
                case '04':
                case '05':
                case '06':
                    box = 8;
                    break;
                case '07':
                case '08':
                case '09':
                    box = 9;
                    break;
                default:
                    box = -1;
            }
            break;
        default:
            box = -1;
    }

    return box;
}

/**
 * Return all cells that belong to a box.
 *
 * @param box
 * @returns {string[]|*[]}
 */
function getBoxCells3x3(box) {
    switch(box) {
        case 1:
            return ['cell0101', 'cell0102', 'cell0103', 'cell0201', 'cell0202', 'cell0203', 'cell0301', 'cell0302', 'cell0303'];
        case 2:
            return ['cell0104', 'cell0105', 'cell0106', 'cell0204', 'cell0205', 'cell0206', 'cell0304', 'cell0305', 'cell0306'];
        case 3:
            return ['cell0107', 'cell0108', 'cell0109', 'cell0207', 'cell0208', 'cell0209', 'cell0307', 'cell0308', 'cell0309'];
        case 4:
            return ['cell0401', 'cell0402', 'cell0403', 'cell0501', 'cell0502', 'cell0503', 'cell0601', 'cell0602', 'cell0603'];
        case 5:
            return ['cell0404', 'cell0405', 'cell0406', 'cell0504', 'cell0505', 'cell0506', 'cell0604', 'cell0605', 'cell0606'];
        case 6:
            return ['cell0407', 'cell0408', 'cell0409', 'cell0507', 'cell0508', 'cell0509', 'cell0607', 'cell0608', 'cell0609'];
        case 7:
            return ['cell0701', 'cell0702', 'cell0703', 'cell0801', 'cell0802', 'cell0803', 'cell0901', 'cell0902', 'cell0903'];
        case 8:
            return ['cell0704', 'cell0705', 'cell0706', 'cell0804', 'cell0805', 'cell0806', 'cell0904', 'cell0905', 'cell0906'];
        case 9:
            return ['cell0707', 'cell0708', 'cell0709', 'cell0807', 'cell0808', 'cell0809', 'cell0907', 'cell0908', 'cell0909'];
        default:
            return [];
    }
}


/**
 * Return the number part of a cell's ID.
 *
 * @param cellID
 * @returns {*}
 */
function getID(cellID) {
    return cellID.slice(4);
}

/**
 * Return the row number of a cell.
 *
 * @param cellID
 * @returns {*}
 */
function getRow(cellID) {
    return getID(cellID).slice(0,2);
}

/**
 * Return the column number of a cell.
 *
 * @param cellID
 * @returns {*}
 */
function getColumn(cellID) {
    return getID(cellID).slice(2,4);
}

/**
 * Check a grid's rows and columns for duplicates (returns true if duplicates are found).
 *
 * @returns {boolean}
 */
function checkRowsAndColumns() {
    let currentCellID = '';
    let compareCellID = '';
    let currentCell, compareCell;
    let hasError = false;

    for (let x = 1; x <= 9; x++ ) {
        for (let y = 1; y <= 9; y++) {                      //for every cell in the grid
            currentCellID = 'cell0' + x + '0' + y;
            currentCell = document.getElementById(currentCellID);

            if (currentCell.dataset.given !== '') {          //if the cell has a 'given'
                for (let i = x+1; i <= 9; i++) {
                    compareCellID = 'cell0' + i + '0' + y;  //check every cell below in the same column
                    compareCell = document.getElementById(compareCellID);

                    if (compareCell.dataset.given !== '') {
                        if (currentCell.dataset.given === compareCell.dataset.given) {
                            currentCell.dataset.hasError = 'true';
                            compareCell.dataset.hasError = 'true';
                            hasError = true;
                        }
                    }
                    else if (compareCell.dataset.penMark !== '') {
                        if (currentCell.dataset.given === compareCell.dataset.penMark) {
                            currentCell.dataset.hasError = 'true';
                            compareCell.dataset.hasError = 'true';
                            hasError = true;
                        }
                    }
                }

                for (let i = y+1; i <= 9; i++) {
                    compareCellID = 'cell0' + x + '0' + i;    //and to the right in the same row
                    compareCell = document.getElementById(compareCellID);

                    if (compareCell.dataset.given !== '') {
                        if (currentCell.dataset.given === compareCell.dataset.given) {
                            currentCell.dataset.hasError = 'true';
                            compareCell.dataset.hasError = 'true';
                            hasError = true;
                        }
                    }
                    else if (compareCell.dataset.penMark !== '') {
                        if (currentCell.dataset.given === compareCell.dataset.penMark) {
                            currentCell.dataset.hasError = 'true';
                            compareCell.dataset.hasError = 'true';
                            hasError = true;
                        }
                    }
                }
            }
            else if (currentCell.dataset.penMark !== '') {  //same check for pen marks
                for (let i = x+1; i <= 9; i++) {
                    compareCellID = 'cell0' + i + '0' + y;  //check every cell below in the same column
                    compareCell = document.getElementById(compareCellID);

                    if (compareCell.dataset.given !== '') {
                        if (currentCell.dataset.penMark === compareCell.dataset.given) {
                            currentCell.dataset.hasError = 'true';
                            compareCell.dataset.hasError = 'true';
                            hasError = true;
                        }
                    }
                    else if (compareCell.dataset.penMark !== '') {
                        if (currentCell.dataset.penMark === compareCell.dataset.penMark) {
                            currentCell.dataset.hasError = 'true';
                            compareCell.dataset.hasError = 'true';
                            hasError = true;
                        }
                    }
                }

                for (let i = y+1; i <= 9; i++) {
                    compareCellID = 'cell0' + x + '0' + i;    //and to the right in the same row
                    compareCell = document.getElementById(compareCellID);

                    if (compareCell.dataset.given !== '') {
                        if (currentCell.dataset.penMark === compareCell.dataset.given) {
                            currentCell.dataset.hasError = 'true';
                            compareCell.dataset.hasError = 'true';
                            hasError = true;
                        }
                    }
                    else if (compareCell.dataset.penMark !== '') {
                        if (currentCell.dataset.penMark === compareCell.dataset.penMark) {
                            currentCell.dataset.hasError = 'true';
                            compareCell.dataset.hasError = 'true';
                            hasError = true;
                        }
                    }
                }
            }
        }
    }
    return hasError;
}

/**
 * Check the box of a cell 'cell' for duplicates (returns true if duplicates are found).
 *
 * @param cell
 * @param boxCells
 */
function checkBox(boxCells) {
    let currentCellID = '';
    let compareCellID = '';
    let currentCell, compareCell;
    let hasError = false;

    for (let i = 0; i < 9; i++) {
        currentCellID = boxCells[i];
        currentCell = document.getElementById(currentCellID);

        if (currentCell.dataset.given !== '') {
            for (let j = i+1; j < 9; j++) {
                compareCellID = boxCells[j];
                compareCell = document.getElementById(compareCellID);

                if (compareCell.dataset.given !== '') {
                    if (currentCell.dataset.given === compareCell.dataset.given) {
                        currentCell.dataset.hasError = 'true';
                        compareCell.dataset.hasError = 'true';
                        hasError = true;
                    }
                }
                else if (compareCell.dataset.penMark !== '') {
                    if (currentCell.dataset.given === compareCell.dataset.penMark) {
                        currentCell.dataset.hasError = 'true';
                        compareCell.dataset.hasError = 'true';
                        hasError = true;
                    }
                }
            }
        }
        else if (currentCell.dataset.penMark !== '') {
            for (let j = i+1; j < 9; j++) {
                compareCellID = boxCells[j];
                compareCell = document.getElementById(compareCellID);

                if (compareCell.dataset.given !== '') {
                    if (currentCell.dataset.penMark === compareCell.dataset.given) {
                        currentCell.dataset.hasError = 'true';
                        compareCell.dataset.hasError = 'true';
                        hasError = true;
                    }
                }
                else if (compareCell.dataset.penMark !== '') {
                    if (currentCell.dataset.penMark === compareCell.dataset.penMark) {
                        currentCell.dataset.hasError = 'true';
                        compareCell.dataset.hasError = 'true';
                        hasError = true;
                    }
                }
            }
        }
    }
    return hasError;
}

/**
 * Mar all cells as correct in preparation for re-marking of incorrect cells.
 */
function markAllCorrect() {
    for (let i = 0; i < gridCells.length; i++) {
        gridCells[i].dataset.hasError = 'false';
    }
}

/**
 * Run all necessary checks for all Sudoku rules implemented in the system.
 *
 * @param cell
 */
function validator3x3(cell) {
    markAllCorrect();
    for(let i=1; i<=9; i++) {
        checkBox(getBoxCells3x3(i));
    }

    let ruleCheckmarks = document.getElementsByClassName('checkmark'); //all rules that are enabled in grid

    for (let i in ruleCheckmarks) {
        switch(ruleCheckmarks[i].id) {
            case 'WindokuCheck':
                windokuValidation(cell.id);
                break;
            case 'ChessKnightCheck':
                for (let x = 1; x <= 9; x++) {
                    for (let y = 1; y <= 9; y++) {
                        let cellID = 'cell0' + x + '0' + y;
                        knightValidation(document.getElementById(cellID));
                    }
                }
                break;
        }
    }

    return checkRowsAndColumns() && checkBox(cell);
}
