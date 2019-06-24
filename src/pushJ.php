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

$list = $core->gsim('*', 'notif', "id_area = " . $core->_vars['user']['area'] . " AND id_usuario=" . $core->_vars['user']['id'] . " AND notif_j > 0");
foreach ($list as $key) {
    $nJob = $core->gsi('job', $core->db_prefix . 'jobs', 'id=' . $key->id_job);
    $cliente = $core->gsi('cliente', $core->db_prefix . 'jobs', 'id=' . $key->id_job);
    $responsavel = $core->gsi('nome', $core->db_prefix . 'usuarios', 'id=' . $key->responsavel);
    $data['title'] = 'Nova Pauta Criada';
    $data['msg'] = "Job: " . $nJob . " - Cliente: " . $cliente . " - Responsavel: " . $core->priNome($responsavel);
    $data['icon'] = 'http://brandworks.com.br/gestaoPauta/src/img/brand/BW.png';
    $data['url'] = '';
    $rows[] = $data;
    // update notification database
    $nextime = $core->updateNotif($key->id, "notif_j", $key->id_area, $key->id_usuario);
}
$array['notif'] = $rows;
$array['count'] = 1;
$array['result'] = 1;
echo json_encode($array);
?>