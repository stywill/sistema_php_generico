<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Usuários</li>          
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">              
                <!-- /.col-->
                <div class="col-md-6 col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <strong>Cadastro</strong>
                            <small><?= ($ac == 'inf') ? 'Visualizar' : 'Editar'; ?></small>
                        </div>
                        <form class="form-horizontal" action="processa/usuarios.php?axn=<?= $ver; ?>" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label for="company">Nome</label>
                                        <input class="form-control" id="nome" name="nome" type="text" placeholder="Nome" value="<?= $cadastro->nome; ?>">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="form-group col-sm-6">
                                        <label for="street">E-mail</label>
                                        <input class="form-control" id="email" name="email" type="text" placeholder="E-mail" value="<?= $cadastro->email; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="postal-code">Telefone</label>
                                        <input class="form-control" id="telefone" name="telefone" type="text" placeholder="Telefone" value="<?= $cadastro->telefone; ?>">
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label for="company">Login</label>
                                        <input class="form-control" id="login" name="login" type="text" placeholder="Login" value="<?= $cadastro->login; ?>">
                                    </div>  
                                </div>
                                <div class="row">    
                                    <div class="form-group col-sm-6">
                                        <label for="company">Senha</label>
                                        <input class="form-control" id="senha" name="senha" type="password" placeholder="Senha" value="<?= $cadastro->senha; ?>">
                                    </div>  
                                </div>                                
                                <div class="row">                                  
                                    <div class="form-group col-sm-6">
                                        <label for="postal-code">Estado - Geo</label>
                                        <?php
                                            echo $core->selectClass("estadoGeo", "estadoGeo", "form-control", "", "id,nome,geo", ": ", "aux_estados", "", "nome", $cadastro->id_estado_geo, "--Selecione");
                                       
                                        ?>
                                    </div> 
                                </div>
                                <div class="row">    
                                    <div class="form-group col-sm-6">
                                        <label for="city">Acesso</label>
                                        <select class="form-control" id="id_grupo" name="id_grupo">
                                            <option value="3" <?=($cadastro->id_grupo==3)?'selected':'';?>>Responsável Geo</option>
                                            <option value="2" <?=($cadastro->id_grupo==2)?'selected':'';?>>Responsável Brasil</option>                                           
                                            <option value="1" <?=($cadastro->id_grupo==1)?'selected':'';?>>Administrador</option>                     
                                        </select>    
                                    </div>
                                </div>
                                <div class="row">                                  
                                    <div class="form-group col-sm-6">
                                        <label for="postal-code">Receber E-mails dos novos Tebloides Criados</label>
                                        <select class="form-control" name="recebe_email" id="recebe_email">
                                            <option value="N" <?=($cadastro->recebe_email_tabloide=='N')?'selected':'';?>>Não</option>
                                            <option value="S" <?=($cadastro->recebe_email_tabloide=='S')?'selected':'';?>>Sim</option>
                                        </select>    
                                    </div> 
                                </div>
                                <div class="row">                                  
                                    <div class="form-group col-sm-6">
                                        <label for="postal-code">Status</label>
                                        <?= $core->selectClass("status", "status", "form-control", "", "", "", "", "", "", $cadastro->status, "--Selecione"); ?>
                                    </div> 
                                </div>
                                <div class="row">  
                                    <div class="form-group">
                                        <label for="company"></label>
                                    </div>   
                                </div>   
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="cid" id="cid" value="<?= $cadastro->id; ?>">
                                <?php
                                if ($ac != 'inf') {
                                    ?>
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Salvar</button>
                                    <?php
                                }
                                ?>
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