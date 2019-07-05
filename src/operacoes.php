<?php

$view = "views_";
$mod = "operacoes";
//$paginacao->pagination($pag, $limitipp, $pagLink, $itens, $tabela, $qf);
if ($ver == 'novo') {
    include 'views/' . $mod . '_view.php';
} else {
    if ($core->_vars['user']['ga'] == 3) {
        $qf = ($lid) ? "id=" . $lid : "geo='" . $core->_vars['user']['usgeo'] . "'";
    } else {
        $qf = ($lid) ? "id=" . $lid : "id<>0";
    }
    $dados = $core->gsim("*", $view . $mod, $qf);

    if ($ver == 'editar') {
        $cadastro = $dados[0];
        if ($core->_vars['user']['ga'] == 3) {
            $geoestado = '<input disabled="" class="form-control" type="text" value="' . $core->_vars['user']['usgeo'] . '">';
            $geoestado .= '<input type="hidden" name="estadoGeo" id="estadoGeo" value="' . $core->_vars['user']['idgeo'] . '">';
        } else {
            $geoestado = $core->selectClass("estadoGeo", "estadoGeo", "form-control", "", "id,nome,geo", ": ", "aux_estados", "", "nome", $cadastro->id_estado_geo, "--Selecione");
        }
        include 'views/' . $mod . '_view.php';
    } else {
        include 'list/' . $mod . '_list.php';
    }
}

