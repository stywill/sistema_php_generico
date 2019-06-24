function limpa(indice, campo) {
    $("#erro" + campo + indice).html("");
}
function remove(count, nome) {
    $("#" + nome + count).remove();
    return count--;
}
$('#addCapa').click(function () {
    var count = $("#countCapa").val();
    var voltar = $("#prod_capa");
    var primeiro = $("#prod_capa option:first-child");
    var e = $("#prod_capa option:selected");
    var value = e.val();
    var texto = e.text();
    voltar.val(primeiro.val());
    if (value != "") {
        var p = $('<div class="row" id="capalinha' + count + '">\n\
                    <div class="form-group col-sm-3">\n\
                        <label for="produto">Produto</label>\n\
                        <input disabled="" class="form-control" type="text" value="' + texto + '">\n\
                        <input id="prutoCapa' + count + '" name="produtoCapa[]" type="hidden" value="' + value + '">\n\
                    </div>\n\
                    <div class="form-group col-sm-3">\n\
                        <label for="de">De</label><input class="form-control valores" id="deCapa" name="deCapa[]" type="text" value="">\n\
                    </div>\n\
                    <div class="form-group col-sm-3">\n\
                        <label for="por">Por</label><input class="form-control valores" id="porCapa' + count + '" name="porCapa[]" type="text" value=""  onkeydown="limpa(' + count + ',\'Capa\')">\n\
                        <label id="erroCapa' + count + '"></label>\n\
                    </div>\n\
                    <div class="form-group col-sm-2">\n\
                         <br><button class="btn btn-danger" onclick="remove(' + count + ',\'capalinha\')" type="button"><i class="fa fa-trash-o"></i></button>\n\
                    </div>\n\
                </div>'); // criar o elemento 
        p.hide(); // escondê-lo
        $('#produto_capa').append(p); // "appendê-lo" ou "appendar" o <p>
        p.fadeIn(); // fazer fade in com ele já na página
        count++;
        $("#countCapa").val(count);
    }
});
$('#addVerso').click(function () {
    var count = $("#countVerso").val();
    var voltar = $("#prod_verso");
    var primeiro = $("#prod_verso option:first-child");
    var e = $("#prod_verso option:selected");
    var value = e.val();
    var texto = e.text();
    voltar.val(primeiro.val());
    if (value != "") {
        var p = $('<div class="row" id="versolinha' + count + '">\n\
                    <div class="form-group col-sm-3">\n\
                        <label for="produto">Produto</label>\n\
                        <input disabled="" class="form-control" type="text" value="' + texto + '">\n\
                        <input id="prutoVerso' + count + '" name="produtoVerso[]" type="hidden" value="' + value + '">\n\
                    </div>\n\
                    <div class="form-group col-sm-3">\n\
                        <label for="de">De</label><input class="form-control valores" id="deVerso' + count + '" name="deVerso[]" type="text" value="">\n\
                    </div>\n\
                    <div class="form-group col-sm-3">\n\
                        <label for="por">Por</label><input class="form-control valores" id="porVerso' + count + '" name="porVerso[]" type="text" value=""  onkeydown="limpa(' + count + ',\'Verso\')">\n\
                        <label id="erroVerso' + count + '"></label>\n\
                    </div>\n\
                    <div class="form-group col-sm-2">\n\
                         <br><button class="btn btn-danger" onclick="remove(' + count + ',\'versolinha\')" type="button"><i class="fa fa-trash-o"></i></button>\n\
                    </div>\n\
               </div>'); // criar o elemento 
        p.hide(); // escondê-lo    
        $('#produto_verso').append(p); // "appendê-lo" ou "appendar" o <p>
        p.fadeIn(); // fazer fade in com ele já na página
        count++;
        $("#countVerso").val(count);
    }
});
$('#addOp').click(function () {
    var count = $("#countOp").val();
    var voltar = $("#operacao");
    var primeiro = $("#operacao option:first-child");
    var e = $("#operacao option:selected");
    var value = e.val();
    var texto = e.text();
    voltar.val(primeiro.val());
    if (value != "") {
        var p = $('<div class="row" id="operacaolinha' + count + '">\n\
                    <div class="form-group col-sm-6">\n\
                        <label for="produto">Operação</label>\n\
                        <input disabled="" class="form-control" type="text" value="' + texto + '">\n\
                        <input id="operacao' + count + '" name="operacao[]" type="hidden" value="' + value + '">\n\
                    </div>\n\
                    <div class="form-group col-sm-4">\n\
                        <label for="de">Quantidade</label>\n\
                        <input class="form-control quantidade" id="quantidade' + count + '" name="quantidade[]" type="text" value=""  onkeydown="limpa(' + count + ',\'Op\')">\n\
                        <label id="erroOp' + count + '"></label>\n\
                    </div>\n\
                    <div class="form-group col-sm-2">\n\
                         <br><button class="btn btn-danger" onclick="remove(' + count + ',\'operacaolinha\')" type="button"><i class="fa fa-trash-o"></i></button>\n\
                    </div>\n\
                </div>'); // criar o elemento 
        p.hide(); // escondê-lo
        $('#ops_qtd').append(p); // "appendê-lo" ou "appendar" o <p>
        p.fadeIn(); // fazer fade in com ele já na página
        count++;
        $("#countOp").val(count);
    }
});
$('#salva').click(function () {
    var countCapa = parseInt($("#countCapa").val());
    var countVerso = parseInt($("#countVerso").val());
    var countOp = parseInt($("#countOp").val());
    var passou = true;
    if ($("#nome").val().length == 0) {
        $("#nome").focus()
        $("#erroNome").html("<font color=red>De um nome para lâmina</font>");
    }
    if (countCapa == 1) {
        $("#prod_capa").focus()
        $("#erroAddCapa").html("<font color=red>Informe um item para capa</font>");
        passou = false;
    }
    for (var i = 1; i < countCapa; i++) {
        if ($("#porCapa" + i).val().length == 0) {
            $("#porCapa" + i).focus()
            $("#erroCapa" + i).html("<font color=red>Informe o Por:</font>");
            passou = false;
        }
    }
    if (countVerso == 1) {
        $("#prod_verso").focus()
        $("#erroAddVerso").html("<font color=red>Informe um item para verso</font>");
        passou = false;
    }
    for (var i = 1; i < countVerso; i++) {
        if ($("#porVerso" + i).val().length == 0) {
            $("#porVerso" + i).focus()
            $("#erroVerso" + i).html("<font color=red>Informe o Por:</font>");
            passou = false;
        }
    }
    if (countOp == 1) {
        $("#operacao").focus()
        $("#erroAddOp").html("<font color=red>Informe um item para operação</font>");
        passou = false;
    }
    for (var i = 1; i < countOp; i++) {
        if ($("#quantidade" + i).val().length == 0) {
            $("#quantidade" + i).focus()
            $("#erroOp" + i).html("<font color=red>Digite a Quantidade:</font>");
            passou = false;
        }
    }
    console.log('Capa: ' + countCapa + ' Verso: ' + countVerso + ' Operacoes: ' + countOp)
    if (passou == true) {
        $("#tabloide").submit();
    }
});

