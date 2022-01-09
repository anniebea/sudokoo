/**
 * Clears the grid of Pen and Pencil marks, resets timer.
 */
function clearBoard() {
    for (let i = 0; i < gridCells.length; i++) {
        gridCells[i].dataset.penMark = '';
        gridCells[i].dataset.pencilMarks = '';
    }
    markAllCorrect();
}
