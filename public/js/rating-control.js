/**
 * Event listeners that ensure correct display of five star rating input.
 */

document.getElementById('star1').addEventListener('click', function() {
    document.getElementById('star1').dataset.selected = 'true';
    document.getElementById('star2').dataset.selected = 'false';
    document.getElementById('star3').dataset.selected = 'false';
    document.getElementById('star4').dataset.selected = 'false';
    document.getElementById('star5').dataset.selected = 'false';

    document.getElementById('starValue').value = '1';
}, false);

document.getElementById('star2').addEventListener('click', function() {
    document.getElementById('star1').dataset.selected = 'true';
    document.getElementById('star2').dataset.selected = 'true';
    document.getElementById('star3').dataset.selected = 'false';
    document.getElementById('star4').dataset.selected = 'false';
    document.getElementById('star5').dataset.selected = 'false';

    document.getElementById('starValue').value = '2';
}, false);

document.getElementById('star3').addEventListener('click', function() {
    document.getElementById('star1').dataset.selected = 'true';
    document.getElementById('star2').dataset.selected = 'true';
    document.getElementById('star3').dataset.selected = 'true';
    document.getElementById('star4').dataset.selected = 'false';
    document.getElementById('star5').dataset.selected = 'false';

    document.getElementById('starValue').value = '3';
}, false);

document.getElementById('star4').addEventListener('click', function() {
    document.getElementById('star1').dataset.selected = 'true';
    document.getElementById('star2').dataset.selected = 'true';
    document.getElementById('star3').dataset.selected = 'true';
    document.getElementById('star4').dataset.selected = 'true';
    document.getElementById('star5').dataset.selected = 'false';

    document.getElementById('starValue').value = '4';
}, false);

document.getElementById('star5').addEventListener('click', function() {
    document.getElementById('star1').dataset.selected = 'true';
    document.getElementById('star2').dataset.selected = 'true';
    document.getElementById('star3').dataset.selected = 'true';
    document.getElementById('star4').dataset.selected = 'true';
    document.getElementById('star5').dataset.selected = 'true';

    document.getElementById('starValue').value = '5';
}, false);

/**
 * Event listeners that ensure correct like/dislike display.
 */

document.getElementById('like').addEventListener('click', function() {
    document.getElementById('like').dataset.selected = 'true';
    document.getElementById('dislike').dataset.selected = 'false';

    document.getElementById('likeValue').value = '1';
}, false);

document.getElementById('dislike').addEventListener('click', function() {
    document.getElementById('like').dataset.selected = 'false';
    document.getElementById('dislike').dataset.selected = 'true';

    document.getElementById('likeValue').value = '0';
}, false);

