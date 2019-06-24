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
/* * *******************************************************************************************************
 * ******************************DISPARO DE E-MAIL********************************************************* 
 * *******************************************************************************************************
 * ******************************************************************************************************* */
if ($tab == "tabloides") {
    require_once('../email/email.php');
    $tabloide = $core->gsim("*", "views_usuario_tabloides", "id=" . $id);
    $itens = file_get_contents('../email/tabloide_avaliacao.html');
    $itens = str_replace('[TITULO]', "Arte final avaliada", $itens);
    $itens = str_replace('[GEO]', $tabloide[0]->geo, $itens);
    $itens = str_replace('[LAMINA]', $tabloide[0]->lamina, $itens);
    $itens = str_replace('[DT_ENVIO]', $core->exibedatah($core->now()), $itens);
    if ($valor == "A") {
        $itens = str_replace('[STATUS]', "<p style='font-size:17px;color:#3a9d5d;'><strong>Arte Final APROVADA pelo Usúario</strong></p>", $itens);
    } else {
        $itens = str_replace('[STATUS]', "<p style='font-size:17px;color:#f63c3a;'><strong>Arte Final REPROVADA pelo Usúario</strong></p>", $itens);
    }
    $itens = $itens;
    $dados_envio = $core->gsim("nome,email", "usuarios", "id_grupo=1 AND email!='' AND recebe_email_tabloide='S'");
        foreach ($dados_envio as $key => $disparos) {
            $envio = email($disparos->email, $disparos->nome, 'Arte final avaliada', $itens);
        }
    
}
?>