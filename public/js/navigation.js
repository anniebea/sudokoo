/**
 * Function deselects 'cell', selects the cell one over in the direction 'key'.
 *
 * @param cell
 * @param key
 */
function gridNavigate(cell, key) {
    let direction = key.slice(5);
    let newCell;        //cell that will be selected
    let newCoordinate;  //the x or y coordinate value that will be changed to

    switch(direction) {
        case 'Left':
            if (getColumn(cell.id).slice(1) == 1) {
                newCell = document.getElementById('cell' + getRow(cell.id) + '09');
                selectCell(newCell);
            }
            else {
                newCoordinate = getColumn(cell.id).slice(1) - 1;
                newCell = document.getElementById('cell' + getRow(cell.id) + '0' + newCoordinate);
                selectCell(newCell);
            }
            break;
        case 'Right':
            if (getColumn(cell.id).slice(1) == 9) {
                newCell = document.getElementById('cell' + getRow(cell.id) + '01');
                selectCell(newCell);
            }
            else {
                newCoordinate = getColumn(cell.id).slice(1);
                newCoordinate++;
                newCell = document.getElementById('cell' + getRow(cell.id) + '0' + newCoordinate);
                selectCell(newCell);
            }
            break;
        case 'Up':
            if (getRow(cell.id).slice(1) == 1) {
                newCell = document.getElementById('cell09' + getColumn(cell.id));
                selectCell(newCell);
            }
            else {
                newCoordinate = getRow(cell.id).slice(1) - 1;
                newCell = document.getElementById('cell0' + newCoordinate + getColumn(cell.id));
                selectCell(newCell);
            }
            break;
        case 'Down':
            if (getRow(cell.id).slice(1) == 9) {
                newCell = document.getElementById('cell01' + getColumn(cell.id));
                selectCell(newCell);
            }
            else {
                newCoordinate = getRow(cell.id).slice(1);
                newCoordinate++;
                newCell = document.getElementById('cell0' + newCoordinate + getColumn(cell.id));
                selectCell(newCell);
            }
            break;
        default:
            return -1;
    }
}
