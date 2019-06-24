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

if ($axn == "novo") {
    if ($core->_vars['user']['logado']) {
        $rto = $core->buildModLink($pag, '', ''); // URL de retorno após processamento
        $querytype = $core->query_type("I", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . $pag, NULL);
        $query = "INSERT INTO " . $core->db_prefix . $pag . " VALUES(NULL,'$id_usuario','$id_estado_geo','$nome',NULL,NULL,'P',"
                . "'" . $core->_vars['user']['id'] . "','" . $core->now() . "',NULL,NULL,NULL,'A')";

        $id = $core->sql($querytype, $query);
        $tid = $core->gsi("id", $core->db_prefix . 'tabloides', "id_usuario=$id_usuario AND id_estado_geo=$id_estado_geo AND nome='$nome' AND criado_por =" . $core->_vars['user']['id'] . " AND data_criacao='" . $core->now() . "'");

        if ($produtoCapa) {
            for ($i = 0; $i < count($produtoCapa); $i++) {
                $querytypeCapa = $core->query_type("I", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "tabloide_capas", NULL);
                $queryCapa = "INSERT INTO " . $core->db_prefix . "tabloide_capas VALUES(NULL,'$tid','$produtoCapa[$i]','$deCapa[$i]',"
                        . "'$porCapa[$i]','" . $core->_vars['user']['id'] . "','" . $core->now() . "',NULL,NULL)";
                $cid = $core->sql($querytypeCapa, $queryCapa);
            }
        }
        if ($produtoVerso) {
            for ($i = 0; $i < count($produtoVerso); $i++) {
                $querytypeVerso = $core->query_type("I", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "tabloide_versos", NULL);
                $queryVerso = "INSERT INTO " . $core->db_prefix . "tabloide_versos VALUES(NULL,'$tid','$produtoVerso[$i]','$deVerso[$i]',"
                        . "'$porVerso[$i]','" . $core->_vars['user']['id'] . "','" . $core->now() . "',NULL,NULL)";
                $vid = $core->sql($querytypeVerso, $queryVerso);
            }
        }
        if ($operacao) {
            for ($i = 0; $i < count($operacao); $i++) {
                $querytypeOp = $core->query_type("I", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "tabloide_versos", NULL);
                $queryOp = "INSERT INTO " . $core->db_prefix . "tabloide_operacoes VALUES(NULL,'$tid','$operacao[$i]','$quantidade[$i]',"
                        . "'" . $core->_vars['user']['id'] . "','" . $core->now() . "',NULL,NULL)";
                $oid = $core->sql($querytypeOp, $queryOp);
            }
        }
        /** *******************************************************************************************************
         * ******************************DISPARO DE E-MAIL********************************************************* 
         * *******************************************************************************************************
         * ******************************************************************************************************* */
        $itens = file_get_contents('../email/tabloide.html');
        $itens = str_replace('[TITULO]', "Novo Tabloide Criado", $itens);
        $itens = str_replace('[USUARIO]', $core->_vars['user']['nome'], $itens);
        $itens = str_replace('[GEO]', $core->_vars['user']['usgeo'], $itens);
        $itens = str_replace('[LAMINA]', $nome, $itens);
        $itens = str_replace('[DT_ENVIO]', $core->exibedatah($core->now()), $itens);
        $itens = $itens;

        $dados_envio = $core->gsim("nome,email", "usuarios", "id_grupo=1 AND email!='' AND recebe_email_tabloide='S'");
        foreach ($dados_envio as $key => $disparos) {
            $envio = email($disparos->email, $disparos->nome, 'Novo tabloide criado', $itens);
        }
        
    } else {
        $dmsg = 'Login nao permitido';
        $rto = $core->buildModLink($pag, 'novo', '');
    }

// -----------------------------------------------
// -----------------------------------------------
} elseif ($axn == "editar") {
// -----------------------------------------------   
    $rto = $core->buildModLink($pag, 'editar', '&lid=' . $cid); // URL de retorno após processamento    
    if ($core->_vars['user']['logado']) {
        $querytype = $core->query_type("U", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . $pag, $cid);
        $query = "UPDATE " . $core->db_prefix . $pag . " SET nome='$nome', status = 'A', alterado_por='" . $core->_vars['user']['id'] . "', "
                . "data_alteracao='" . $core->now() . "'  WHERE (id = '$cid')";
        $run = $core->sql($querytype, $query);
//echo "Lamina<br>";
//echo $query."<br>";
//echo "Produto Capa<br>";   
        if ($produtoCapa) {
            for ($i = 0; $i < count($produtoCapa); $i++) {
                // echo $pci[$i] . "<br>";
                if ($pci[$i]) {
                    $querytypeCapa = $core->query_type("U", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "tabloide_capas", $pci[$i]);
                    $queryCapa = "UPDATE " . $core->db_prefix . "tabloide_capas SET de='$deCapa[$i]', por = '$porCapa[$i]', "
                            . "alterado_por='" . $core->_vars['user']['id'] . "', data_alteracao='" . $core->now() . "' WHERE (id = '$pci[$i]')";
                    $runCapa = $core->sql($querytypeCapa, $queryCapa);
                } else {
                    $querytypeCapa = $core->query_type("I", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "tabloide_capas", NULL);
                    $queryCapa = "INSERT INTO " . $core->db_prefix . "tabloide_capas VALUES(NULL,'$cid','$produtoCapa[$i]','$deCapa[$i]','$porCapa[$i]',"
                            . "'" . $core->_vars['user']['id'] . "','" . $core->now() . "',NULL,NULL)";
                    $runCapa = $core->sql($querytypeCapa, $queryCapa);
                }

//echo $queryCapa."<br>";              
            }
        }
//echo "Produto Verso<br>";           
        if ($produtoVerso) {
            for ($i = 0; $i < count($produtoVerso); $i++) {
                if ($pvi[$i]) {
                    $querytypeVerso = $core->query_type("U", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "tabloide_versos", $pvi[$i]);
                    $queryVerso = "UPDATE " . $core->db_prefix . "tabloide_versos SET de='$deVerso[$i]', por = '$porVerso[$i]' , "
                            . "alterado_por='" . $core->_vars['user']['id'] . "', data_alteracao='" . $core->now() . "' WHERE (id = '$pvi[$i]')";
                    $runVerso = $core->sql($querytypeVerso, $queryVerso);
                } else {
                    $querytypeVerso = $core->query_type("I", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "tabloide_versos", NULL);
                    $queryVerso = "INSERT INTO " . $core->db_prefix . "tabloide_versos VALUES(NULL,'$cid','$produtoVerso[$i]','$deVerso[$i]','$porVerso[$i]',"
                            . "'" . $core->_vars['user']['id'] . "','" . $core->now() . "',NULL,NULL)";
                    $runVerso = $core->sql($querytypeVerso, $queryVerso);
                }

//echo $queryVerso."<br>";      
            }
        }
//echo "Operações<br>";        
        if ($operacao) {
            for ($i = 0; $i < count($operacao); $i++) {
                if ($opi[$i]) {
                    $querytypeOp = $core->query_type("U", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "tabloide_operacoes", $opi[$i]);
                    $queryOp = "UPDATE " . $core->db_prefix . "tabloide_operacoes SET quantidade='$quantidade[$i]', "
                            . "alterado_por='" . $core->_vars['user']['id'] . "', data_alteracao='" . $core->now() . "' WHERE (id = '$opi[$i]')";
                    $runOp = $core->sql($querytypeOp, $queryOp);
                } else {
                    $querytypeOp = $core->query_type("I", $core->_vars['user']['id'], $core->_vars['page']['mod'], $db_prefix . "tabloide_versos", NULL);
                    $queryOp = "INSERT INTO " . $core->db_prefix . "tabloide_operacoes VALUES(NULL,'$cid','$operacao[$i]','$quantidade[$i]',"
                            . "'" . $core->_vars['user']['id'] . "','" . $core->now() . "',NULL,NULL)";
                    $runOp = $core->sql($querytypeOp, $queryOp);
                }
//echo $queryOp."<br>";                
            }
        }
        /* ********************************************************************************************************
         * ******************************DISPARO DE E-MAIL********************************************************* 
         * *******************************************************************************************************
         * ******************************************************************************************************* */
        $itens = file_get_contents('../email/tabloide.html');
        $itens = str_replace('[TITULO]', "Tabloide Editado", $itens);
        $itens = str_replace('[USUARIO]', $core->_vars['user']['nome'], $itens);
        $itens = str_replace('[GEO]', $core->_vars['user']['usgeo'], $itens);
        $itens = str_replace('[LAMINA]', $nome, $itens);
        $itens = str_replace('[DT_ENVIO]', $core->exibedatah($core->now()), $itens);
        $itens = $itens;

        $dados_envio = $core->gsim("nome,email", "usuarios", "id_grupo=1 AND email!=''");
        $envio = email($dados_envio[0]->email, $dados_envio[0]->nome, 'Tabloide Editado', $itens);
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
