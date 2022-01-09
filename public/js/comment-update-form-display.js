let commentEditBtns = document.getElementsByClassName('edit');

/**
 * Handle displaying of comment edit form.
 */
for (let i = 0; i < commentEditBtns.length; i++) {
    if(commentEditBtns[i].id != 'editBtn') {
        let form = document.getElementById('CommentUpdate'+commentEditBtns[i].id.slice(11));
        let content = document.getElementById('CommentContent'+commentEditBtns[i].id.slice(11));
        let cancel = document.getElementById('CommentCancel'+commentEditBtns[i].id.slice(11));

        commentEditBtns[i].addEventListener('click',function() {
            form.style.display = 'block';
            content.style.display = 'none';
        });

        cancel.addEventListener('click', function() {
            form.style.display = 'none';
            content.style.display = 'block';
        });
    }
}
