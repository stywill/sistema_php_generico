<?php

//$paginacao->pagination($pag, $limitipp, $pagLink, $itens, $tabela, $qf);
$perArea = array(0, 1);
if (!in_array($core->_vars['user']['area'], $perArea)) {
    $qfb .= " AND id in (select id_area from " . $core->db_prefix . "area_jobs where id_job = " . $lid . ")";
    $qf .= (!$lid) ? " id in (select id_job from " . $core->db_prefix . "area_jobs where id_area = " . $core->_vars['user']['area'] . ") AND " : "";
    $nper = true;
}
$ddareas = $core->gsim("*", "areas", 'status="A" ' . $qfb);

if ($ver == 'novo') {
    include 'views/jobsAt_view.php';
} else {
    $qf .= ($lid) ? " id=" . $lid : "finalizado='$st'";
    $dados = $core->gsim("*", "jobs", $qf);
    //print_r($dados);
    if ($ver == 'editar') {
        $diasRest = $core->diffDate($dados[0]->dt_entrega);        
        $finalizar = ($core->gsi('id', $core->db_prefix . 'area_jobs', 'status != 4 and id_job =' . $lid))?1:0;
        $jobsView = ($nper) ? 'jobs_view.php' : 'jobsAt_view.php';
        include 'views/' . $jobsView;
    } else {
        include 'list/jobs_list.php';
    }
}

