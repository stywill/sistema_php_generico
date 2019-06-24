<?php

// -----------------------------------------------
session_cache_limiter('nocache');
session_start();

//se quiser carregar qualquer variável, é aqui, antes da chamada da classe!
include('processa/__core.php');
$core = new core();
$paginacao = new paginacao();
$views = new dicionario_views();

$core->load();
$core->loadContent();

$js_pospt = "";


include 'src/topo.php';
include 'src/inc_menu.php';


if ($core->_vars['sys']['msg']) {
    echo $core->showSysMsg();
} else {
    include 'src/' . $core->_vars['core']['include'];
}
include 'src/rodape.php';
