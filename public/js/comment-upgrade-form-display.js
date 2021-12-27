let commentEditBtns = document.getElementsByClassName('editComment');

for (let i = 0; i < commentEditBtns.length; i++) {
    let form = document.getElementById('CommentUpdate'+commentEditBtns[i].id.slice(-1));
    let content = document.getElementById('CommentContent'+commentEditBtns[i].id.slice(-1));
    let cancel = document.getElementById('CommentCancel'+commentEditBtns[i].id.slice(-1));

    commentEditBtns[i].addEventListener('click',function() {
        document.getElementById('testArea').innerHTML+= '+' + commentEditBtns[i].id.slice(-1);

        form.style.display = 'block';
        content.style.display = 'none';
    });

    cancel.addEventListener('click', function() {
        form.style.display = 'none';
        content.style.display = 'block';
    });
}
