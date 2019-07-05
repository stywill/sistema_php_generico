<?php
$mod = "tabloides";
//$paginacao->pagination($pag, $limitipp, $pagLink, $itens, $tabela, $qf);
if ($ver == 'novo') {
    include 'views/' . $mod . '_view.php';
} else {
    $qf = ($lid) ? "id=" . $lid : "id_estado_geo=".$core->_vars['user']['idgeo'];
    $dados = $core->gsim("*", $mod, $qf ." ORDER BY data_criacao DESC");

    if ($ver == 'editar') {
        $capas = $core->gsim("*", "tabloide_capas", "id_tabloide=" . $lid);
        $versos = $core->gsim("*", "tabloide_versos", "id_tabloide=" . $lid);
        $operacoes = $core->gsim("*", "tabloide_operacoes", "id_tabloide=" . $lid);
        $tabloide = $core->gsim("*", "tabloides", "id=" . $lid);
        if ($tabloide[0]->aprovado == 'A') {
            $statusAf = '<span class="badge badge-success">Aprovado</span>';
        } elseif ($tabloide[0]->aprovado == 'R') {
            $statusAf = ' <span class="badge badge-danger">Reprovado</span>';
        } elseif ($tabloide[0]->aprovado == 'P' && $tabloide[0]->imagem)  {
            $statusAf = '<span class="badge badge-warning">Pendente</span>';

        } else {
            $statusAf = '';
        }
        $obss = explode('|',$tabloide[0]->obs);
        $exibeObs = substr($obss[count($obss)-1], strripos($obss[count($obss)-1],'-')+1);
        include 'views/' . $mod . '_view.php';
    } else {
        include 'list/' . $mod . '_list.php';
    }
}

