/**
 * Adds event listener to SudokuGrid creation form to
 * 1) override form submission and
 * 2) ensure storing of data in data attributes (by creating hidden input fields)
 */
document.getElementById('sudokuForm').addEventListener('submit', transformDataAttributes);

function transformDataAttributes(event) {
    event.preventDefault(); //prevent form submission

    //create new inputs for data attribute values
    const form = document.getElementById('sudokuForm');
    for (let i=0; i < gridCells.length; i++) {
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = gridCells[i].id;
        input.value = gridCells[i].dataset.given;
        form.appendChild(input);
    }
    resubmitSudoku();
}

function resubmitSudoku() {
    document.getElementById('sudokuForm').removeEventListener('submit', transformDataAttributes);
    document.getElementById('sudokuForm').submit();
}
