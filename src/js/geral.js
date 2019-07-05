
function getXMLHTTP() {
    var xmlhttp = false;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xmlhttp;
}




function getAjContent(strURL, divtarget) {
    var divs = divtarget.split("-");
    var req = getXMLHTTP();
    console.log(req);
    if (divs.length > 1) {
        for (var j = 0; j < divs.length; j++) {
            document.getElementById(divs[j]).innerHTML = '<img src="src/img/ajax-loader.gif" width="16px" height="16px">';
        }
    } else {
        if (divtarget != 'noRet') {
            document.getElementById(divtarget).innerHTML = '<img src="src/img/ajax-loader.gif" width="16px" height="16px">';
        }
    }
    if (req) {
        req.onreadystatechange = function () {

            if (req.readyState == 4) {
                if (req.status == 200) {
                    if (divs.length > 1) {
                        var texto = req.responseText.split("|");
                        for (var i = 0; i < divs.length; i++) {
                            document.getElementById(divs[i]).innerHTML = texto[i];
                        }
                    } else {
                        if (divtarget != 'noRet') {
                            document.getElementById(divtarget).innerHTML = req.responseText;
                        }
                    }
                } else {
                    alert("XMLHTTP ERR:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        req.send(null);
    }
}


function input_num(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /[0-9,]/;
    if (key == 8 || key == 45) {
    } else {
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault)
                theEvent.preventDefault();
        }
    }
}



function jumpMenu(targ, selObj, restore) {
    eval(targ + ".location=\'" + selObj.options[selObj.selectedIndex].value + "\'");
    if (restore)
        selObj.selectedIndex = 0;
}

function getValoresSelect(idSelect, strURL, divtarget) {
    //console.log(divtarget);
    if (divtarget == 'lp_opsm') {
        for (var c = 1; c < 101; c++) {
            getAjContent(strURL + $("#" + idSelect).val() + '&c=' + c, 'lp_opsm' + c);
            //console.log(strURL + $("#" + idSelect).val()+'&c='+c);
        }
    } else {
        getAjContent(strURL + $("#" + idSelect).val(), divtarget);
    }
}

function setFormato(idInput) {
    getAjContent('aj_get_dimis.php?ma=' + $("#marca" + idInput).val() + '&em=' + $("#embalagem" + idInput).val() + '&pr=' + $("#preco" + idInput).val() + '&idf=' + idInput + '&ret=3', 'div_formato' + idInput)
}

function modal(janelaId, img, titulo, obsId, fase, faseValue) {
    //e.preventDefault();
    var id = "#dialog";
    var c;
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
    var imgHei = document.getElementById('foto' + obsId).naturalHeight;
    var imgWid = document.getElementById('foto' + obsId).naturalWidth;
    var telaHei = document.documentElement.clientHeight;
    var prop = (telaHei * 75) / 100
    var maxWidth = telaHei - (telaHei * 38) / 100;
  
    // adjust width and height according to determined maxWidth
    var width = imgWid > maxWidth ? maxWidth : imgWid;
    var height = imgHei * width / imgWid;

    // if height still too big, use maxHeight scale width & height
    if (height > imgHei) {
        height = imgHei;
        width = imgWid * height / imgHei;
    }
    //($newWidth*$height)/$width
    document.getElementById(janelaId).innerHTML = '<img src="' + img + '" width="'+width+'px" height="auto">';
    document.getElementById('titulo').innerHTML = titulo;
    if (faseValue == 'S') {
        c = 'checked';
    } else {
        c = '';
    }
    document.getElementById('favorita').innerHTML = 'Aprovar<input type="checkbox" name="semi' + obsId + '" value="S" onclick="getAjContent(\'_selFoto.php?obsId=' + obsId + '&fase=' + fase + '&aprov=S\', \'noRet\')" ' + c + '>';

    $('#mask').css({'width': maskWidth, 'height': maskHeight});

    $('#mask').fadeIn(1000);
    $('#mask').fadeTo("slow", 0.8);

    //Get the window height and width
    var winH = $(window).height();
    var winW = $(window).width();

    $(id).css('top', winH / 2 - $(id).height() / 2);
    $(id).css('left', winW / 2 - $(id).width() / 2);

    $(id).fadeIn(2000);

}
$(document).ready(function () {
    $('.window .close').click(function (e) {
        e.preventDefault();

        $('#mask').hide();
        $('.window').hide();
        window.location.reload();
    });

    $('#mask').click(function () {
        $(this).hide();
        $('.window').hide();
    });

});
function excluirConfirma(msg,msgr,dados, retorno) {
    console.log('processa/'+dados);
    if (confirm(msg)) {
        getAjContent('processa/'+dados, retorno);       
        //setTimeout(function () {
            location.reload();
        //}, 2000);  
        alert(msgr);
    } else {
        return false;
    }
}
function validaAf(msg,msgr,dados, retorno){
    console.log($('#obs').val())
    console.log($('#obsHist').val())
    if (confirm(msg)) {
        getAjContent('processa/'+dados+'&obs='+$('#obs').val()+'&obsHist='+$('#obsHist').val(), retorno);       
        //setTimeout(function () {
            location.reload();
        //}, 2000);  
        alert(msgr);
    } else {
        return false;
    }
}