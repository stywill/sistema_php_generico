<?php
// -----------------------------------------------
session_cache_limiter('nocache');
session_start();

include('__core.php');
$core = new core();
$core->load();
// -----------------------------------------------
$dmsg = 'Dados processados com sucesso'; // mensagem que aparece ao finalizar processamento
$auto_rto = true; // retorna automaticamente para uma url 
$pag = 'operacoes';
$elink = '/bw_tabloides/';
$rto = '';

if ($axn == "novo") {
    //verifica se existe login duplicado
    if ($core->_vars['user']['logado']) {
        $rto = $core->buildModLink($pag, '', ''); // URL de retorno após processamento
        $querytype = $core->query_type("I", $core->_vars['user']['id'], $core->_vars['page']['mod'], $core->db_prefix . $pag, null);
        $query = "INSERT INTO " . $core->db_prefix . $pag . " VALUES(NULL,'$estadoGeo','$operacao','" . $core->fix_mysql_str($cidade) . "',"
                . "'" . $core->fix_mysql_str($endereco) . "','$cep','$cnpj','$ie','$responsavel','$contato_resp','" . $core->_vars['user']['id'] . "',"
                . "'" . $core->now() . "',NULL,NULL,'$status')";
        $uid = $core->sql($querytype, $query);
    } else {
        $dmsg = 'Login nao permitido';
        $rto = $core->buildModLink($pag, 'novo', '');
        //$rto = 'history.back();';
    }
    // -----------------------------------------------
} elseif ($axn == "editar") {
    // -----------------------------------------------   
    $rto = $core->buildModLink($pag, 'editar', '&lid=' . $cid); // URL de retorno após processamento   
    //verifica se existe login duplicado
    if ($core->_vars['user']['logado']) {
        $querytype = $core->query_type("U", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . $pag, $cid);
        $query = "UPDATE " . $core->db_prefix . $pag . " SET id_estado_geo='$estadoGeo', operacao = '$operacao',"
                . "cidade='" . $core->fix_mysql_str($cidade) . "',endereco='" . $core->fix_mysql_str($endereco) . "',"
                . "cep='$cep',cnpj='$cnpj',ie='$ie',responsavel='$responsavel', contato_resp='$contato_resp',status = '$status',"
                . "alterado_por='" . $core->_vars['user']['id'] . "',data_alteracao = '" . $core->now() . "' WHERE (id = '$cid')";
        $run = $core->sql($querytype, $query);
    } else {
        $dmsg = 'Login nao permitido';
        $rto = $core->buildModLink($pag, 'editar', '&cid=' . $cid);
    }
    // -----------------------------------------------
}

// -----------------------------------------------// -----------------------------------------------
// -----------------------------------------------// -----------------------------------------------
// -----------------------------------------------// -----------------------------------------------
// -----------------------------------------------// -----------------------------------------------
// -----------------------------------------------// -----------------------------------------------
// -----------------------------------------------// -----------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>---</title>
    </head>

    <body>
        <script>
            <!--
                var dmsg = '<?= $dmsg; ?>';
            if (dmsg) {
                alert(dmsg);
            }
<?php if ($auto_rto) { ?>
                window.location = '../<?= $rto; ?>';
<?php }
?>
            //-->
        </script>

        <?php if (!$auto_rto) { ?>
            <div align=center>
                <br />
                <strong>
                    <?php echo $dmsg; ?></strong>
                <input name="btn" id="btn" type="button" value="Prosseguir" onclick="window.location = '../<?php echo $rto; ?>';" />
            </div>
        <?php }
        ?>
    </body>

</html> 