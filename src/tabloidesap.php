<?php

$tab = "tabloides";
$mod = "tabloidesap";
//$paginacao->pagination($pag, $limitipp, $pagLink, $itens, $tabela, $qf);

$qf = ($lid) ? "id=" . $lid : "status is not NULL";
$dados = $core->gsim("*", $tab, $qf . " ORDER BY data_criacao DESC");
//echo "<pre>" . var_dump($dados) . "</pre>";
if ($ver == 'editar') {
    $capas = $core->gsim("*", "tabloide_capas", "id_tabloide=" . $lid);
    $versos = $core->gsim("*", "tabloide_versos", "id_tabloide=" . $lid);
    $operacoes = $core->gsim("*", "tabloide_operacoes", "id_tabloide=" . $lid);
    $tabloide = $core->gsim("*", "tabloides", "id=" . $lid);
    $cadastro = $dados[0];
    $idUsuario = ($cadastro->id_usuario) ? $cadastro->id_usuario : $core->_vars['user']['id'];
    $idEstadoGeo = ($cadastro->id_estado_geo) ? $cadastro->id_estado_geo : $core->_vars['user']['ga'];
    include 'views/' . $mod . '_view.php';
} else if ($ver == 'exp') {
    if ($geo || $lamina) {
        $busca = ($geo) ? " id_estado_geo IN (select id from bwt_aux_estados where geo = '" . $geo . "')" : "";
        if ($geo && $lamina) {
            $busca .= " AND nome like '%" . $lamina . "%'";
        } elseif ($lamina) {
            $busca .= " nome like '%" . $lamina . "%'";
        } else {
            $busca .= "";
        }
        $exports = $core->gsim("*", "tabloides", "aprovado='P' AND " . $busca);
    }
    include 'views/' . $mod . '_xls_view.php';
} else {
    include 'list/' . $mod . '_list.php';
}


