<?php
$cadastro = $dados[0];
$idUsuario = ($cadastro->id_usuario) ? $cadastro->id_usuario : $core->_vars['user']['id'];
$idEstadoGeo = ($cadastro->id_estado_geo) ? $cadastro->id_estado_geo : $core->_vars['user']['idgeo'];
?>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Tabloide</li>          
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">              
                <!-- /.col-->
                <div class="col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Tabloide</strong>
                            <small><?= ($ver == 'novo') ? 'Novo' : 'Editar'; ?></small>
                            <?=$statusAf;?>
                            
                        </div>
                        <form id="tabloide" class="form-horizontal" action="processa/<?= $mod; ?>.php?axn=<?= $ver; ?>" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="fa fa-align-justify"></i> <strong>Lamina</strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group col-sm-6">
                                                    <input class="form-control" id="nome" name="nome" type="text" placeholder="Nome" onkeydown="limpa('', 'Nome')" value="<?= $cadastro->nome; ?>">
                                                    <input id="id_usuario" name="id_usuario" type="hidden" value="<?= $idUsuario; ?>">
                                                    <input id="id_estado_geo" name="id_estado_geo" type="hidden" value="<?= $idEstadoGeo; ?>">   
                                                     <label id="erroNome"></label>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <!-- /.col-->
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="fa fa-align-justify"></i> <strong>Produtos Capa</strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-sm-2">
                                                        <label for="postal-code">Produtos</label>
                                                    </div>    
                                                    <div class="form-group col-sm-7"> 
                                                        <?= $core->selectClass("prod_capa", "prod_capa", "form-control", "limpa('', 'AddCapa')", "id,nome", "", "produtos", "", "nome", "", "--Selecione"); ?> 
                                                        <label id="erroAddCapa"></label>
                                                    </div>                                                
                                                    <div class="form-group col-sm-2">
                                                        <button class="btn btn-sm btn-success"  id="addCapa" type="button"><i class="fa fa-dot-circle-o"></i> Adicionar</button>   
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                    <div id="produto_capa"> 
                                                        <input id="countCapa" name="countCapa" type="hidden" value="<?= count($capas) + 1; ?>">
                                                        <?php
                                                        $count = 1;
                                                        foreach ($capas as $key => $capa) {
                                                            ?>
                                                            <div class="row" id="capalinha<?= $count; ?>">
                                                                <div class="form-group col-sm-3">
                                                                    <label for="produto">Produto</label>
                                                                    <input disabled="" class="form-control" type="text" value="<?= $core->gsi("nome", $core->db_prefix . "produtos", "id=" . $capa->id_produto); ?>">
                                                                    <input id="prutoCapa<?= $count; ?>'" name="produtoCapa[]" type="hidden" value="<?= $capa->id_produto; ?>">
                                                                    <input id="pci<?= $count; ?>'" name="pci[]" type="hidden" value="<?= $capa->id; ?>">
                                                                </div>
                                                                <div class="form-group col-sm-3">
                                                                    <label for="de">De</label><input class="form-control valores" id="deCapa<?= $count; ?>" name="deCapa[]" type="text" value="<?= $capa->de; ?>">
                                                                </div>
                                                                <div class="form-group col-sm-3">
                                                                    <label for="por">Por</label><input class="form-control valores" id="porCapa<?= $count; ?>" name="porCapa[]" type="text" value="<?= $capa->por; ?>" onkeydown="limpa(<?= $count; ?>, 'Capa')">
                                                                </div>
                                                                <div class="form-group col-sm-2">
                                                                    <br><button class="btn btn-danger" onclick="excluirConfirma('Deseja excluir está linha','Registro excluido com sucesso!', 'aj_excluir.php?tipo=D&tab=tabloide_capas&id=<?= $capa->id; ?>', 'noRet')" type="button"><i class="fa fa-trash-o"></i></button>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $count++;
                                                        }
                                                        ?>                                                       
                                                    </div>
                                                </div>
                                            </div>                                                                                    
                                        </div>
                                        <!-- /.col-->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="fa fa-align-justify"></i> <strong>Produtos Verso</strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-sm-2">
                                                        <label for="postal-code">Produtos</label>
                                                    </div>  
                                                    <div class="form-group col-sm-7"> 
                                                        <?= $core->selectClass("prod_verso", "prod_verso", "form-control", "limpa('', 'AddVerso')", "id,nome", "", "produtos", "", "nome", "", "--Selecione"); ?> 
                                                        <label id="erroAddVerso"></label>
                                                    </div>                                                
                                                    <div class="form-group col-sm-2">
                                                        <button class="btn btn-sm btn-success" id="addVerso" type="button"><i class="fa fa-dot-circle-o"></i> Adicionar</button>   
                                                    </div>                                                                                                  
                                                </div>
                                                <div class="row">
                                                    <div id="produto_verso">
                                                        <input id="countVerso" name="countVerso" type="hidden" value="<?= count($versos) + 1; ?>">
                                                        <?php
                                                        $count = 1;
                                                        foreach ($versos as $key => $verso) {
                                                            ?>
                                                            <div class="row" id="versolinha<?= $count; ?>">
                                                                <div class="form-group col-sm-3">
                                                                    <label for="produto">Produto</label>
                                                                    <input disabled="" class="form-control" type="text" value="<?= $core->gsi("nome", $core->db_prefix . "produtos", "id=" . $capa->id_produto); ?>">
                                                                    <input id="prutoVerso<?= $count; ?>" name="produtoVerso[]" type="hidden" value="<?= $verso->id_produto; ?>">
                                                                    <input id="pvi<?= $count; ?>'" name="pvi[]" type="hidden" value="<?= $verso->id; ?>">
                                                                </div>
                                                                <div class="form-group col-sm-3">
                                                                    <label for="de">De</label><input class="form-control valores" id="deVerso<?= $count; ?>" name="deVerso[]" type="text" value="<?= $verso->de; ?>">
                                                                </div>
                                                                <div class="form-group col-sm-3">
                                                                    <label for="por">Por</label><input class="form-control valores" id="porVerso<?= $count; ?>" name="porVerso[]" type="text" value="<?= $verso->por; ?>" onkeydown="limpa(<?= $count; ?>, 'Verso')">
                                                                </div>
                                                                <div class="form-group col-sm-2">
                                                                    <br><button class="btn btn-danger" onclick="excluirConfirma('Deseja excluir está linha','Registro excluido com sucesso!', 'aj_excluir.php?tipo=D&tab=tabloide_versos&id=<?= $verso->id; ?>', 'noRet')" type="button"><i class="fa fa-trash-o"></i></button>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $count++;
                                                        }
                                                        ?>   
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.col-->
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="fa fa-align-justify"></i> <strong>CDDs / Revendas</strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-sm-2">
                                                        <label for="postal-code">Operações</label>
                                                    </div>
                                                    <div class="form-group col-sm-7">
                                                        <?= $core->selectClass("operacao", "operacao", "form-control", "limpa('', 'AddOp')", "id,operacao,cidade", " / ", "operacoes", "id_estado_geo=".$core->_vars['user']['idgeo'], "operacao", $cadastro->id_operacao, "--Selecione"); ?>  
                                                        <label id="erroAddOp"></label>
                                                    </div>                                                
                                                    <div class="form-group col-sm-2">
                                                        <button class="btn btn-sm btn-success" id="addOp" type="button"><i class="fa fa-dot-circle-o"></i> Adicionar</button>   
                                                    </div>                                                   
                                                </div>
                                                <div class="row">
                                                    <div id="ops_qtd"> 
                                                        <input id="countOp" name="countOp" type="hidden" value="<?= count($operacoes) + 1; ?>">
                                                        <?php
                                                        $count = 1;
                                                        foreach ($operacoes as $key => $op) {
                                                            ?>
                                                            <div class="row" id="operacaolinha<?= $count; ?>">
                                                                <div class="form-group col-sm-6">
                                                                    <label for="produto">Operação</label>
                                                                    <input disabled="" class="form-control" type="text" value="<?= $core->gsi("operacao", $core->db_prefix . "operacoes", "id=" . $op->id_operacao); ?>">
                                                                    <input id="operacao<?= $count; ?>" name="operacao[]" type="hidden" value="<?= $op->id_operacao; ?>">
                                                                    <input id="opi<?= $count; ?>'" name="opi[]" type="hidden" value="<?= $op->id; ?>">
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label for="de">Quantidade</label>
                                                                    <input class="form-control quantidade" id="quantidade<?= $count; ?>" name="quantidade[]" type="text" value="<?= $op->quantidade; ?>"  onkeydown="limpa(<?= $count; ?>, 'Op')">
                                                                </div>
                                                                <div class="form-group col-sm-2">
                                                                    <br><button class="btn btn-danger" onclick="excluirConfirma('Deseja excluir está linha','Registro excluido com sucesso!', 'aj_excluir.php?tipo=D&tab=tabloide_operacoes&id=<?= $op->id; ?>', 'noRet')" type="button"><i class="fa fa-trash-o"></i></button>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $count++;
                                                        }
                                                        ?>  
                                                    </div>                                                    
                                                </div>

                                            </div>
                                        </div>
                                        <!-- /.col-->
                                    </div> 
                                    <?php
                                    if ($tabloide[0]->imagem) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <i class="fa fa-align-justify"></i> <strong>Arte Final</strong>                                                                                                  
                                                </div>
                                                <div class="card-body">  
                                                    <div class="row">
                                                        <label>Observação</label>
                                                    </div>
                                                    <div class="row col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-3">
                                                        <textarea class="form-control" name="obs" id="obs"><?=$tabloide[0]->obs;?></textarea>
                                                    </div>
                                                    <div class=" row align-items-center">
                                                        <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0 text-center">
                                                            <button class="btn btn-sm btn-pill btn-block btn-success active" type="button" aria-pressed="true" onclick="validaAf('Deseja aprovar está arte final','Arte aprovada com sucesso','aj_avaliar_tab.php?tipo=U&tab=tabloides&valor=A&campo=aprovado&id=<?= $lid; ?>','noRet')">Aprovar</button>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0 text-center">
                                                            <button class="btn btn-sm btn-pill btn-block btn-danger active" type="button" aria-pressed="true" onclick="validaAf('Deseja reprovar está arte final','Arte reprovada com sucesso','aj_avaliar_tab.php?tipo=U&tab=tabloides&valor=R&campo=aprovado&id=<?= $lid; ?>','noRet')">Reprovar</button>
                                                        </div>                                                 
                                                    </div>
                                                    <div class="row  mt-3">
                                                        <iframe  class="col-lg-12 col-md-12 col-sm-12" src="<?= $tabloide[0]->imagem; ?>" style="width:600px; height:500px;" frameborder="0"> </iframe>                                                                                                       
                                                    </div>                                                
                                                </div>
                                            </div>
                                            <!-- /.col-->
                                        </div> 
                                        <?php
                                    }
                                    ?>
                                </div>   
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="cid" id="cid" value="<?= $cadastro->id; ?>">
                                <button class="btn btn-sm btn-primary" id="salva" type="button"><i class="fa fa-dot-circle-o"></i> Salvar</button>
                                <button class="btn btn-sm btn-danger" type="reset" onclick="window.history.back()"><i class="fa fa-ban"></i> Voltar</button>
                            </div>
                        </form>    
                    </div>
                </div>

                <!-- /.col-->
            </div>  
        </div>
    </div>
</main>
