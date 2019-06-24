<?php
// -----------------------------------------------
session_cache_limiter('nocache');
session_start();

include('__core.php');
// configuração do e-mail
require_once('../email/email.php');
$core = new core();
$core->load();
// -----------------------------------------------
$dmsg = 'Dados processados com sucesso'; // mensagem que aparece ao finalizar processamento
$auto_rto = true; // retorna automaticamente para uma url 
$pag = 'tabloides';
$rto = '';

if ($axn == "editar") {

// -----------------------------------------------   
    $rto = $core->buildModLink($pag . 'ap', 'editar', '&lid=' . $cid); // URL de retorno após processamento    
    if ($core->_vars['user']['logado']) {
        if ($_FILES) { // Verificando se existe o envio de arquivos.
            if ($_FILES['arquivo']) {
                $arquivo = $core->arquivoUpload($_FILES, "90000", "artefinais");
            }
        }
        if ($arquivo[0] != 'Erro') {
            unlink("../" . $core->gsi("imagem", $core->db_prefix . $pag, "id=" . $cid)); //apaga o arquivo anterior

            $querytype = $core->query_type("U", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . $pag, $cid);
            $query = "UPDATE " . $core->db_prefix . $pag . " SET imagem='" . $arquivo[0] . "', alterado_por='" . $core->_vars['user']['id'] . "', "
                    . "data_alteracao='" . $core->now() . "'  WHERE (id = '$cid')";
            $run = $core->sql($querytype, $query);
            /* * *******************************************************************************************************
             * ******************************DISPARO DE E-MAIL********************************************************* 
             * *******************************************************************************************************
             * ******************************************************************************************************* */
            $dados_envio = $core->gsim("*", "views_usuario_tabloides", "id=".$cid);           
            $itens = file_get_contents('../email/tabloide_arte_final.html');
            $itens = str_replace('[TITULO]', "Arte final enviada para aprovação", $itens);
            $itens = str_replace('[GEO]', $dados_envio[0]->geo, $itens);
            $itens = str_replace('[LAMINA]', $dados_envio[0]->lamina, $itens);
            $itens = str_replace('[DT_ENVIO]', $core->exibedatah($core->now()), $itens);
            $itens = $itens;          
            $envio = email($dados_envio[0]->email,$dados_envio[0]->nome, 'Arte final enviada', $itens);
        }
        $dmsg = $arquivo[1];
    } else {
        $dmsg = 'Login nao permitido';
        $rto = $core->buildModLink($pag . 'ap', 'editar', '&cid=' . $cid);
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
                <input name="btn" id="btn" type="button" value="Prosseguir" onclick="window.location = '../<?php echo $rto; ?>';" />
            </div>
        <?php } ?>
    </body>
</html>
