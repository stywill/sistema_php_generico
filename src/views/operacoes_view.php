<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Operacao</li>  
<?php //var_dump($cadastro);?>        
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">              
                <!-- /.col-->
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <strong>CDD/Revenda</strong>
                            <small><?= ($ac == 'inf') ? 'Visualizar' : 'Editar'; ?></small>
                        </div>
                        <form class="form-horizontal" action="processa/<?= $mod; ?>.php?axn=<?= $ver; ?>" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="company">Geo / Estado</label>
                                        <?= $geoestado; ?>                                      
                                    </div>
                                </div>
                                <div class="row">   
                                    <div class="form-group col-sm-8">
                                        <label for="company">Operação</label>
                                        <input class="form-control" id="operacao" name="operacao" type="text" placeholder="Operação" value="<?= $cadastro->operacao; ?>">
                                    </div>                                   
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-11">
                                        <label for="company">Endereço</label>
                                        <input class="form-control" id="endereco" name="endereco" type="text" placeholder="Endereço" value="<?= $cadastro->endereco; ?>">
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="company">CEP</label>
                                        <input class="form-control" id="cep" name="cep" type="text" placeholder="CEP" value="<?= $cadastro->cep; ?>">
                                    </div> 
                                    <div class="form-group col-sm-6">
                                        <label for="company">Cidade</label>
                                        <input class="form-control" id="cidade" name="cidade" type="text" placeholder="Cidade" value="<?= $cadastro->cidade; ?>">
                                    </div> 
                                </div>
                                <div class="row">

                                    <div class="form-group col-sm-4">
                                        <label for="company">CNPJ</label>
                                        <input class="form-control" id="cnpj" name="cnpj" type="text" placeholder="CNPJ" value="<?= $cadastro->cnpj; ?>">
                                    </div>                                                                        
                                    <div class="form-group col-sm-4">
                                        <label for="company">IE</label>
                                        <input class="form-control" id="ie" name="ie" type="text" placeholder="IE" value="<?= $cadastro->ie; ?>">
                                    </div>                                                                        
                                </div>   
                                <div class="row">                                    
                                    <div class="form-group col-sm-4">
                                        <label for="postal-code">Responsável</label>
                                        <input class="form-control" id="responsavel" name="responsavel" placeholder="responsavel" type="text" value="<?= $cadastro->responsavel; ?>">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="street">Contato</label>
                                        <input class="form-control" id="celular" name="contato_resp" type="text" placeholder="Contato" value="<?= $cadastro->contato_resp; ?>">
                                    </div>

                                </div>
                                <div class="row">                                    
                                    <div class="form-group col-sm-4">
                                        <label for="postal-code">Status</label>
                                        <?= $core->selectClass("status", "status", "form-control", "", "status", ": ", "", "", "", $cadastro->status, ""); ?>                            
                                    </div>
                                </div>                                                                                                                         
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="cid" id="cid" value="<?= $cadastro->id; ?>">
                                <?php
                                if ($axn != 'view') {
                                    ?>
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Salvar</button>
                                    <?php
                                }
                                ?>
                                <button class="btn btn-sm btn-danger" type="reset" onclick="window.location = 'sistema.php?mod=<?= $mod; ?>&st=<?= $st; ?>'"><i class="fa fa-ban"></i> Voltar</button>
                            </div>
                        </form>    
                    </div>
                </div>
                <!-- /.col-->
            </div>           
        </div>
    </div>
</main>