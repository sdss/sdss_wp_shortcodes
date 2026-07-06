// JavaScript source code
function show_hide_tutorial(divname) {
    var cbdivname = "cb-" + divname;
    var cbdiv = document.getElementById(cbdivname);

    var thisdivlist = document.getElementsByClassName(divname);
    /*alert(divname);
    alert(cbdivname);*/
    
    if (cbdiv.checked) {
        for (let i = 0; i < thisdivlist.length; i++) {
            thisdivlist[i].style.display = 'inline';
        }
    } else {
        for (let i = 0; i < thisdivlist.length; i++) {
            thisdivlist[i].style.display = 'none';
        }
    }
    count_tutorials_visible();
    return;
}



function count_tutorials_all() {  // called on page load
    allvaclist = document.getElementsByClassName('tutorial');
    visiblediv = document.getElementById('tutorial-count-visible');
    visiblediv.innerHTML = allvaclist.length;

    alldiv = document.getElementById('tutorial-count-all');
    alldiv.innerHTML = allvaclist.length;

    return;
}

function count_tutorials_visible() {
    allvaclist = document.getElementsByClassName('tutorial');
    hiddencount = 0;
        for (let i = 0; i < allvaclist.length; i++) {
            if (allvaclist[i].style.display == 'none') {
                hiddencount = hiddencount + 1;
            }
    }
    visiblecount = allvaclist.length - hiddencount;
    visiblediv = document.getElementById('tutorial-count-visible');
    
    visiblediv.innerHTML = visiblecount;
    
    return visiblecount;
}

function clear_all_tags() {
    allcbdivs = document.getElementsByClassName('tutorial-filter-checkbox');
    for (let i = 0; i < allcbdivs.length; i++) {
        allcbdivs[i].checked = false;
    }
    checkAllTutorials();
    // count_tutorials_visible();
    return;
}

function select_all_tags() {
    allcbdivs = document.getElementsByClassName('tutorial-filter-checkbox');
    for (let i = 0; i < allcbdivs.length; i++) {
        allcbdivs[i].checked = true;
    }
    // count_tutorials_visible();
    checkAllTutorials();
}


function checkSuvey(surveyTag) {
    var cbdivname = "cb-" + surveyTag;
    var cbdiv = document.getElementById(cbdivname);
    if (cbdiv.checked) {
        return true;
    }
    return false;
}

function checkTag(tutorialTag) {
    var cbdivname = "cb-" + tutorialTag;
    var cbdiv = document.getElementById(cbdivname);
    if (cbdiv.checked) {
        return true;
    }
    return false;
}

function noSurveys(){
    var divlist = document.getElementsByClassName('cb-tutorial-survey');
    var none = true;
    for (let i = 0; i < divlist.length; i++) {
        if (divlist[i].checked){
            none = false;
        }
    }
    return none;
}

function checkAllTutorials(override=false) {
    var divlist = document.getElementsByClassName('tutorial');
    for (let i = 0; i < divlist.length; i++) {
        var survey = false;
        var any = false;
        var clist = divlist[i].classList;
        for (let j = 0; j < clist.length; j++) {
            if (clist[j].includes("survey")) {
                if (checkSuvey(clist[j])) {
                    survey = true;
                }
            } else if (clist[j].includes("tutorial-tag")) {
                if (checkTag(clist[j])) {
                    any = true;
                }
            }
        }
        if (override){
            any = true;
        }
        if (noSurveys()) {
            if (any){
            divlist[i].style.display = 'inline';
            } else {
              divlist[i].style.display = 'none';
            }
        }
        else if (survey && any) {
            divlist[i].style.display = 'inline';
        } else {
            divlist[i].style.display = 'none';
        }
    }
    var visible = count_tutorials_visible();
    if (visible < 1){
        checkAllTutorials(override=true);
    }
}