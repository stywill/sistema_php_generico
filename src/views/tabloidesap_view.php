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
                                                <div class="row">
                                                    <div class="form-group col-sm-4">
                                                        <input disabled class="form-control" id="nome" name="nome" type="text" placeholder="Nome" value="<?= $cadastro->nome; ?>">
                                                        <input id="id_usuario" name="id_usuario" type="hidden" value="<?= $idUsuario; ?>">
                                                        <input id="id_estado_geo" name="id_estado_geo" type="hidden" value="<?= $idEstadoGeo; ?>">   
                                                    </div> 
                                                    <div class="form-group col-sm-6">
                                                        <label class="col-form-label" for="file-input">Enviar Arquivo<strong>(apenas pdf máximo 500KB)</strong></label>
                                                        <input id="arquivo" type="file" name="arquivo">
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
                                                <i class="fa fa-align-justify"></i> <strong>Produtos Capa</strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-sm-8">
                                                        <label for="produto">Produto</label>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <label for="de">De</label>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <label for="por">Por</label>
                                                    </div>
                                                </div>
                                                <?php
                                                foreach ($capas as $key => $capa) {
                                                    ?>
                                                    <div class="row" id="capalinha<?= $count; ?>">
                                                        <div class="form-group col-sm-8">
                                                            <input disabled="" class="form-control" type="text" value="<?= $core->gsi("nome", $core->db_prefix . "produtos", "id=" . $capa->id_produto); ?>">
                                                            <input id="prutoCapa<?= $count; ?>'" name="produtoCapa[]" type="hidden" value="<?= $capa->id_produto; ?>">
                                                            <input id="pci<?= $count; ?>'" name="pci[]" type="hidden" value="<?= $capa->id; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <input disabled class="form-control valores" id="deCapa<?= $count; ?>" name="deCapa[]" type="text" value="<?= $capa->de; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <input disabled class="form-control valores" id="porCapa<?= $count; ?>" name="porCapa[]" type="text" value="<?= $capa->por; ?>" onkeydown="limpa(<?= $count; ?>, 'Capa')">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>                                                       
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
                                                <div class="row" id="versolinha<?= $count; ?>">
                                                    <div class="form-group col-sm-8">
                                                        <label for="produto">Produto</label>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <label for="de">De</label>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <label for="por">Por</label>
                                                    </div>
                                                </div>
                                                <?php
                                                foreach ($versos as $key => $verso) {
                                                    ?>
                                                    <div class="row" id="versolinha<?= $count; ?>">
                                                        <div class="form-group col-sm-8">
                                                            <input disabled class="form-control" type="text" value="<?= $core->gsi("nome", $core->db_prefix . "produtos", "id=" . $capa->id_produto); ?>">
                                                            <input id="prutoVerso<?= $count; ?>" name="produtoVerso[]" type="hidden" value="<?= $verso->id_produto; ?>">
                                                            <input id="pvi<?= $count; ?>'" name="pvi[]" type="hidden" value="<?= $verso->id; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <input disabled class="form-control valores" id="deVerso<?= $count; ?>" name="deVerso[]" type="text" value="<?= $verso->de; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <input disabled class="form-control valores" id="porVerso<?= $count; ?>" name="porVerso[]" type="text" value="<?= $verso->por; ?>" onkeydown="limpa(<?= $count; ?>, 'Verso')">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>   
                                            </div>
                                        </div>
                                        <!-- /.col-->
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="fa fa-align-justify"></i> <strong>Operacões</strong>
                                            </div>
                                            <div class="card-body">  
                                                <div class="row" id="operacaolinha<?= $count; ?>">
                                                    <div class="form-group col-sm-10">
                                                        <label for="produto">Operação</label>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <label for="de">Quantidade</label>
                                                    </div>
                                                </div>
                                                <?php
                                                foreach ($operacoes as $key => $op) {
                                                    ?>
                                                    <div class="row" id="operacaolinha<?= $count; ?>">
                                                        <div class="form-group col-sm-10">
                                                            <input disabled class="form-control" type="text" value="<?= $core->gsi("operacao", $core->db_prefix . "operacoes", "id=" . $op->id_operacao); ?>">
                                                            <input id="operacao<?= $count; ?>" name="operacao[]" type="hidden" value="<?= $op->id_operacao; ?>">
                                                            <input id="opi<?= $count; ?>'" name="opi[]" type="hidden" value="<?= $op->id; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <input disabled class="form-control quantidade" id="quantidade<?= $count; ?>" name="quantidade[]" type="text" value="<?= $op->quantidade; ?>"  onkeydown="limpa(<?= $count; ?>, 'Op')">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>  
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
                                                        <label>Observações</label>
                                                    </div>
                                                    <div class="row col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-3">
                                                        <textarea class="form-control" name="obs" id="obs"><?=str_replace("|","\nl",$tabloide[0]->obs);?></textarea>
                                                    </div>
                                                    <div class="row">
                                                        <iframe  class="col-lg-12 col-md-12 col-sm-12" src="<?=$tabloide[0]->imagem;?>" style="width:600px; height:500px;" frameborder="0"> </iframe>                                                                                                       
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
