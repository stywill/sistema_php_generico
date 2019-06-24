<?php

// -----------------------------------------------
session_cache_limiter('nocache');
session_start();

//se quiser carregar qualquer variável, é aqui, antes da chamada da classe!

include('__core.php');
$core = new core();
$core->load();
// -------
$tab = $_REQUEST["tab"];
$valor = $_REQUEST["valor"];
$id = $_REQUEST["id"];
$tipo = $_REQUEST["tipo"];
$obs = $_REQUEST["obs"];
$msgRetorno = $_REQUEST["msgRetorno"];

$querytype = $core->query_type("U", $core->_vars['user']['id'], $tab, $core->db_prefix . $tab, $id);
if ($tipo == 'U') {
    $obs= ($obs)?" ,obs='$obs'":"";
    $query = "UPDATE " . $core->db_prefix . $tab . " SET $campo = '$valor' ".$obs." WHERE (id = '$id')";
    $core->sql($querytype, $query);
} else {
    $query = "DELETE FROM " . $core->db_prefix . $tab . " WHERE id = " . $id;
    $core->sql($querytype, $query);
}

?>