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
        
        include 'views/' . $mod . '_view.php';
    } else {
        include 'list/' . $mod . '_list.php';
    }
}

