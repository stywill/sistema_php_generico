<?php

//$paginacao->pagination($pag, $limitipp, $pagLink, $itens, $tabela, $qf);
$perArea = array(0, 1);
$qf = "id!=1";
if (!in_array($core->_vars['user']['area'], $perArea)) {
    $qf .= " AND area =" . $core->_vars['user']['area'];
    $nper = true;
}
if ($ver == 'novo') {
    include 'views/usuarios_view.php';
} else {
    $qf.= ($lid) ? " AND id=" . $lid : " AND status is not NULL";
   $dados = $core->gsim("*", "usuarios", $qf);
    //echo "<pre>" . var_dump($dados) . "</pre>";
    if ($ver == 'editar') {
        $cadastro = $dados[0];
        include 'views/usuarios_view.php';
    } else {
        include 'list/usuarios_list.php';
    }
}

