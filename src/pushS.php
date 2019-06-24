<?php

// -----------------------------------------------
session_cache_limiter('nocache');
session_start();

//se quiser carregar qualquer variável, é aqui, antes da chamada da classe!
include('../processa/__core.php');
$core = new core();
$core->load();
$array = array();
$rows = array();

$list = $core->gsim('*', 'notif', "responsavel = " . $core->_vars['user']['id'] . " AND notif_status > 0");
foreach ($list as $key) {
    $nJob = $core->gsi('job', $core->db_prefix . 'jobs', 'id=' . $key->id_job);
    $area = $core->gsi('area', $core->db_prefix . 'areas', 'id=' . $key->id_area);
    $status = $core->gsi('status', $core->db_prefix . 'area_jobs', 'id_job = '.$key->id_job.' and id_area =' . $key->id_area);
    $statusNome = $core->gsi('status', $core->db_prefix . 'area_status', 'id = '.$status);
    $data['title'] = 'Alteração de status';
    $data['msg'] = $area." alterou o status do job numero " . $nJob . " para ".$statusNome;
    $data['icon'] = 'http://brandworks.com.br/gestaoPauta/src/img/brand/BW.png';
    $data['url'] = '';
    $rows[] = $data;
    // update notification database
    $nextime = $core->updateNotif($key->id, "notif_status");
}
$array['notif'] = $rows;
$array['count'] = 1;
$array['result'] = 1;
echo json_encode($array);
?>