const windokuCells = [
    'cell0202', 'cell0203', 'cell0204', 'cell0206', 'cell0207', 'cell0208',
    'cell0302', 'cell0303', 'cell0304', 'cell0306', 'cell0307', 'cell0308',
    'cell0402', 'cell0403', 'cell0404', 'cell0406', 'cell0407', 'cell0408',
    'cell0602', 'cell0603', 'cell0604', 'cell0606', 'cell0607', 'cell0608',
    'cell0702', 'cell0703', 'cell0704', 'cell0706', 'cell0707', 'cell0708',
    'cell0802', 'cell0803', 'cell0804', 'cell0806', 'cell0807', 'cell0808',
]
const box1 = ['cell0202','cell0203','cell0204','cell0302','cell0303','cell0304','cell0402','cell0403','cell0404'];
const box2 = ['cell0206','cell0207','cell0208','cell0306','cell0307','cell0308','cell0406','cell0407','cell0408'];
const box3 = ['cell0602','cell0603','cell0604','cell0702','cell0703','cell0704','cell0802','cell0803','cell0804'];
const box4 = ['cell0606','cell0607','cell0608','cell0706','cell0707','cell0708','cell0806','cell0807','cell0808'];

document.getElementById('WindokuCheck').addEventListener('click', function () {
    if(document.getElementById('WindokuCheck').className === 'checkmark') {
        document.getElementById('WindokuCheck').className = 'uncheckmark';

        let ruleID = document.getElementById('WindokuCheck').parentNode.id;
        let rule = document.getElementById('ruleInput').value.toString();

        document.getElementById('ruleInput').value = rule.replace(ruleID.slice(4),'');
        removeWindoku();
    }
    else {
        document.getElementById('WindokuCheck').className = 'checkmark';

        let ruleID = document.getElementById('WindokuCheck').parentNode.id;
        document.getElementById('ruleInput').value += ruleID.slice(4);
        addWindoku();
    }
});

function addWindoku() {
    for (let i in windokuCells) {
        document.getElementById(windokuCells[i]).style.backgroundColor = 'rgba(0,0,255,0.2)';
        windokuValidation(windokuCells[i]);
    }
}

function removeWindoku() {
    for (let i in windokuCells) {
        document.getElementById(windokuCells[i]).style.backgroundColor = '';
    }
    for (let i in windokuCells) {
        validator3x3(windokuCells[i]);
    }
}

function windokuValidation() {
    let hasError1 = checkBox(box1);
    let hasError2 = checkBox(box2);
    let hasError3 = checkBox(box3);
    let hasError4 = checkBox(box4);

    return hasError1 && hasError2 && hasError3 && hasError4;
}

function loadWindoku() {
    if(document.getElementById('WindokuCheckmark').className === 'checkmark') {
        addWindoku();
    }
}
