document.getElementById('ChessKnightCheck').addEventListener('click', function () {
    if(document.getElementById('ChessKnightCheck').className === 'checkmark') {
        document.getElementById('ChessKnightCheck').className = 'uncheckmark';

        let ruleID = document.getElementById('ChessKnightCheck').parentNode.id;
        let rule = document.getElementById('ruleInput').value.toString();

        document.getElementById('ruleInput').value = rule.replace(ruleID.slice(4),'');
    }
    else {
        document.getElementById('ChessKnightCheck').className = 'checkmark';

        let ruleID = document.getElementById('ChessKnightCheck').parentNode.id;
        document.getElementById('ruleInput').value += ruleID.slice(4);
    }
    for (let x = 1; x <= 9; x++) {
        for (let y = 1; y <= 9; y++) {
            let cellID = 'cell0' + x + '0' + y;
            validator3x3(document.getElementById(cellID));
        }
    }
});

function getKnightBuddies(cellID) {
    let resultArray = [];
    let cellRow = getRow(cellID);
    let cellColumn = getColumn(cellID);

    let newCellRow = parseInt(cellRow) - 2;
    let newCellColumn = parseInt(cellColumn) - 1;
    if(newCellRow > 0 && newCellRow < 10 && newCellColumn > 0 && newCellColumn < 10 ) {
        resultArray.push('cell0' + newCellRow + '0' + newCellColumn);
    }

    newCellRow = parseInt(cellRow) - 2;
    newCellColumn = parseInt(cellColumn) + 1;
    if(newCellRow > 0 && newCellRow < 10 && newCellColumn > 0 && newCellColumn < 10 ) {
        resultArray.push('cell0' + newCellRow + '0' + newCellColumn);
    }

    newCellRow = parseInt(cellRow) - 1;
    newCellColumn = parseInt(cellColumn) - 2;
    if(newCellRow > 0 && newCellRow < 10 && newCellColumn > 0 && newCellColumn < 10 ) {
        resultArray.push('cell0' + newCellRow + '0' + newCellColumn);
    }

    newCellRow = parseInt(cellRow) - 1;
    newCellColumn = parseInt(cellColumn) + 2;
    if(newCellRow > 0 && newCellRow < 10 && newCellColumn > 0 && newCellColumn < 10 ) {
        resultArray.push('cell0' + newCellRow + '0' + newCellColumn);
    }

    newCellRow = parseInt(cellRow) + 2;
    newCellColumn = parseInt(cellColumn) - 1;
    if(newCellRow > 0 && newCellRow < 10 && newCellColumn > 0 && newCellColumn < 10 ) {
        resultArray.push('cell0' + newCellRow + '0' + newCellColumn);
    }

    newCellRow = parseInt(cellRow) + 2;
    newCellColumn = parseInt(cellColumn) + 1;
    if(newCellRow > 0 && newCellRow < 10 && newCellColumn > 0 && newCellColumn < 10 ) {
        resultArray.push('cell0' + newCellRow + '0' + newCellColumn);
    }

    newCellRow = parseInt(cellRow) + 1;
    newCellColumn = parseInt(cellColumn) - 2;
    if(newCellRow > 0 && newCellRow < 10 && newCellColumn > 0 && newCellColumn < 10 ) {
        resultArray.push('cell0' + newCellRow + '0' + newCellColumn);
    }

    newCellRow = parseInt(cellRow) + 1;
    newCellColumn = parseInt(cellColumn) + 2;
    if(newCellRow > 0 && newCellRow < 10 && newCellColumn > 0 && newCellColumn < 10 ) {
        resultArray.push('cell0' + newCellRow + '0' + newCellColumn);
    }

    return resultArray;
}

function knightValidation(cell) {
    let hasError = false;

    let buddyArray = getKnightBuddies(cell.id);
    let compareCell;

    for (let i in buddyArray) {
        compareCell = document.getElementById(buddyArray[i]);

        if (cell.dataset.given != '') {
            if (compareCell.dataset.given != '') {
                if(cell.dataset.given == compareCell.dataset.given) {
                    hasError = true;
                    cell.dataset.hasError = 'true';
                    compareCell.dataset.hasError = 'true'
                    document.getElementById(buddyArray[i]).dataset.hasError = 'true';
                }
            }
            else if (compareCell.dataset.penMark != '') {
                if(cell.dataset.given == compareCell.dataset.penMark) {
                    hasError = true;
                    cell.dataset.hasError = 'true';
                    compareCell.dataset.hasError = 'true'
                    document.getElementById(buddyArray[i]).dataset.hasError = 'true';
                }
            }
        }
        else if (cell.dataset.penMark != '') {
            if (compareCell.dataset.given != '') {
                if(cell.dataset.given == compareCell.dataset.given) {
                    hasError = true;
                    cell.dataset.hasError = 'true';
                    compareCell.dataset.hasError = 'true'
                    document.getElementById(buddyArray[i]).dataset.hasError = 'true';
                }
            }
            else if (compareCell.dataset.penMark != '') {
                if(cell.dataset.given == compareCell.dataset.penMark) {
                    hasError = true;
                    cell.dataset.hasError = 'true';
                    compareCell.dataset.hasError = 'true'
                    document.getElementById(buddyArray[i]).dataset.hasError = 'true';
                }
            }
        }
    }

    return hasError;
}
