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

$msgRetorno = $_REQUEST["msgRetorno"];
/*
  echo '<div class="col-md-4 col-sm-4">';
  echo '<div class="portlet light bordered">';
  echo '<div class="portlet-title">';
  echo '<div class="caption font-dark">';
  echo '<i class="icon-trash font-dark"></i>';
  echo '<label style="color:#ec0b0b">';
 */
/*
$querytype = $core->query_type("U", $core->_vars['user']['id'], $tab, $core->db_prefix . $tab, $id);
if ($tipo == 'U') {
    $query = "UPDATE " . $core->db_prefix . $tab . " SET $campo = '$valor' WHERE (id = '$id')";
    $core->sql($querytype, $query);
} else {
    $query = "DELETE FROM " . $core->db_prefix . $tab . " WHERE id = " . $id;
    $core->sql($querytype, $query);
}
 * 
 */
echo '!!!!' . $_REQUEST["tab"].' = '.$_REQUEST["geo"] . "<br>";
//echo '!!!!'.$query . "<br>";
//echo $tab;
/*
  echo "Registro excluido com sucesso!";
  echo '</label>';
  echo '</div>';
  echo '</div>';
  echo '</div>';
  echo '</div>';
 */
?>