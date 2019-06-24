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
$rto = '';
if ($axn == "novo") {

//verifica se existe login duplicado
    if ($core->_vars['user']['logado']) {
        $rto = $core->buildModLink('usuarios', '', ''); // URL de retorno após processamento
        $querytype = $core->query_type("I", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "usuarios", NULL);
        $query = "INSERT INTO " . $core->db_prefix . "usuarios VALUES(NULL,'$nome','$email','$login','$senha',4,NULL,'N','$id_grupo','$estadoGeo','$telefone','$status','" . $core->_vars['user']['id'] . "','" . $core->now() . "','" . $core->now() . "',2)";

        $uid = $core->sql($querytype, $query);
    } else {
        $dmsg = 'Login nao permitido';
        $rto = $core->buildModLink('usuarios', 'novo', '');
//$rto = 'history.back();';
    }

// -----------------------------------------------
} elseif ($axn == "novo2") {
// -----------------------------------------------
// -----------------------------------------------
} elseif ($axn == "editar") {
// -----------------------------------------------   
    $rto = $core->buildModLink('usuarios', '', ''); // URL de retorno após processamento   
//verifica se existe login duplicado
    if ($core->_vars['user']['logado']) {
        $querytype = $core->query_type("U", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "usuarios", $cid);
        $query = "UPDATE " . $core->db_prefix . "usuarios SET nome='$nome', email = '$email',login='$login' , senha = '$senha',recebe_email_tabloide='$recebe_email', id_grupo = '$id_grupo' , "
                . "id_estado_geo = '$estadoGeo' , telefone = '$telefone' ,status = '$status' WHERE (id = '$cid')";
        $run = $core->sql($querytype, $query);
    } else {
        $dmsg = 'Login nao permitido';
        $rto = $core->buildModLink('usuarios', 'editar', '&cid=' . $cid);
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
<?php } ?>
            //-->
        </script>

        <?php if (!$auto_rto) { ?>
            <div align=center>
                <br />
                <strong><?php echo $dmsg; ?></strong>
                <input name="btn" id="btn" type="button" value="Prosseguir" onclick="window.location = '<?php echo $rto; ?>';" />
            </div>
        <?php } ?>
    </body>
</html>
