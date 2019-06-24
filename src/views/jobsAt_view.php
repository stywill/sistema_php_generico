<?php
$cadastro = $dados[0];
if ($diasRest <= 0) {
    $alert = '';
} elseif ($diasRest <= 2) {
    $alert = 'alert alert-danger';
} elseif ($diasRest > 2 && $diasRest < 5) {
    $alert = 'alert alert-warning';
} else {
    $alert = 'alert alert-success';
}
?>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Jobs</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- /.col-->
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <strong>Jobs</strong>
                            <small>
                                <?= ($ac == 'inf') ? 'Visualizar' : 'Editar'; ?></small>
                        </div>
                        <form class="form-horizontal" action="processa/jobs.php?axn=<?= $ver; ?>" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="company">Dias Restantes <div class="<?= $alert; ?>" role="alert">
                                                <?= $diasRest; ?>
                                            </div></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-2">
                                        <label for="company">Job</label>
                                        <input class="form-control" id="job" name="job" type="text" placeholder="Job" value="<?= $cadastro->job; ?>">                                      
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="company">Data de Entrada</label>
                                        <input class="form-control" id="dt_briefing" name="dt_briefing" type="date" placeholder="Data do Briefing" value="<?= $cadastro->dt_briefing; ?>">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="company">Data de Apresentação</label>
                                        <input class="form-control" id="dt_entrega" name="dt_entrega" type="date" placeholder="Data de Entrega" value="<?= $cadastro->dt_entrega; ?>">
                                    </div>                                   
                                </div>
                                <div class="row">                                    
                                    <div class="form-group col-sm-4">
                                        <label for="postal-code">Responsável</label>
                                        <?= $core->selectClass("responsavel", "responsavel", "form-control", "", "id,nome", "", "usuarios", "status='A' and area = '1'", "nome", $cadastro->responsavel, "--Selecione"); ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="street">Ciente</label>
                                        <input class="form-control" id="cliente" name="cliente" type="text" placeholder="Cliente" value="<?= $cadastro->cliente; ?>">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="company">Nome do Job</label>
                                        <input class="form-control" id="nomejob" name="nomejob" type="text" placeholder="Nome do Job" value="<?= $cadastro->nomejob; ?>">
                                    </div>                                    
                                    <div class="form-group col-sm-6">
                                        <label for="company">Responsável Cliente</label>
                                        <input class="form-control" id="respcli" name="respcli" type="text" placeholder="Responsável Cliente" value="<?= $cadastro->respcli; ?>">
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="company">Serviço</label>
                                        <input class="form-control" id="servico" name="servico" type="text" placeholder="Serviço" value="<?= $cadastro->servico; ?>">
                                    </div>                                    
                                    <div class="form-group col-sm-4">
                                        <label for="company">Produto</label>
                                        <input class="form-control" id="produto" name="produto" type="text" placeholder="Produto" value="<?= $cadastro->produto; ?>">
                                    </div>                                    
                                    <div class="form-group col-sm-4" style="<?= $finalizar; ?>">
                                        <label for="company">Job Finalizado</label>
                                        <select class="form-control" name="finalizado" id="finalizado">
                                            <option value="N" <?= ($cadastro->finalizado == 'N') ? 'selected' : ''; ?>>Não Finalizado</option>
                                            <option value="S" <?= ($cadastro->finalizado == 'S') ? 'selected' : ''; ?>>Stand by</option>
                                            <?php
                                            if ($finalizar == 0) {
                                                ?>
                                                <option value="F" <?= ($cadastro->finalizado == 'F') ? 'selected' : ''; ?>>Finalizado</option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>                               
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="col-form-label"></label>
                                        <table class="table table-responsive-sm" cellspacing="1">
                                            <?php
                                            $ind = 1;
                                            $trabalhos = $core->gsim("*", "trabalhos", "status='A'");
                                            foreach ($trabalhos as $key => $trab) {
                                                echo ($ind == 1) ? '<tr>' : '';
                                                if ($trab->desc) {
                                                    $name = $trab->name;
                                                    ?>
                                                    <td>                                                 
                                                        <div class="form-check checkbox">                        
                                                            <label class="switch switch-label switch-outline-success">
                                                                <input class="switch-input" type="checkbox" id="<?= $trab->name; ?>" name="<?= $trab->name; ?>" type="checkbox" <?= ($cadastro->$name == 'S') ? 'checked' : ''; ?>>                                                   
                                                                <span class="switch-slider" data-checked="✓" data-unchecked="✕"></span>                                                   
                                                            </label> 
                                                        </div>                                                     
                                                    </td> 
                                                    <td>
                                                        <label class="col-form-label"><?= $trab->desc; ?></label>
                                                    </td>                                                                                                                                         
                                                    <?php
                                                    $name = '';
                                                } else {
                                                    echo "<td></td><td></td>";
                                                }
                                                echo ($ind % 4) ? ' ' : '</tr><tr>';
                                                $ind++;
                                            }
                                            ?>
                                        </table>                                       
                                    </div>   
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="fa fa-align-justify"></i> <strong>Descrição</strong>
                                                <div class="card-header-actions">
                                                    <a class="card-header-action" href="src/briefing.php" target="_blank">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                        <small class="text-muted">PDF</small>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" >
                                                    <textarea class="form-control" name="descricao" id="descricao" name="textarea-input" placeholder="Coment.."><?= html_entity_decode($cadastro->descricao); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="company"><strong>Áreas</strong></label>
                                    </div>
                                </div>
                                <?php
                                foreach ($ddareas as $key => $dareas) {
                                    $conn++;
                                    ${'participa' . $conn} = $core->gsim('*', 'area_jobs', 'id_job=' . $lid . ' AND id_area=' . $dareas->id);
                                    ${'status' . $conn} = (!${'participa' . $conn}->status) ? 1 : ${'participa' . $conn}->status;
                                    ?>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="form-check checkbox">
                                                        <input type="hidden" name="areaId<?= $conn; ?>" id="areaId<?= $conn; ?>" value="<?= $dareas->id; ?>">
                                                        <label class="form-check-label" for="check1">
                                                            <input class="form-check-input" name="participa<?= $conn; ?>" id="participa<?= $conn; ?>" type="checkbox" <?= (${'participa' . $conn}[0]->id) ? 'checked' : ''; ?>>
                                                            <strong>
                                                                <?= $dareas->area; ?></strong>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label" for="select1">Cronograma</label>
                                                        <div class="col-md-5">
                                                            De: <input class="form-control" id="crono_ini<?= $conn ?>" name="crono_ini<?= $conn ?>" type="date" placeholder="Data Inicio" value="<?= ${'participa' . $conn}[0]->crono_ini; ?>">
                                                            Até: <input class="form-control" id="crono_fim<?= $conn ?>" name="crono_fim<?= $conn ?>" type="date" placeholder="Data Final" value="<?= ${'participa' . $conn}[0]->crono_fim; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label" for="select1">Status</label>
                                                        <div class="col-md-9">
                                                            <?= $core->selectClass("status" . $conn, "status" . $conn, "form-control", "", "id,status", "", "area_status", "", "id", ${'participa' . $conn}[0]->status, " - "); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label" for="textarea-input">Observação</label>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" name="obs<?= $conn ?>" id="obs<?= $conn; ?>" name="textarea-input" rows="9" placeholder="Coment.."><?= html_entity_decode(${'participa' . $conn}[0]->obs); ?></textarea>
                                                            <input type="hidden" name="idArJ<?= $conn ?>" id="idArJ<?= $conn ?>" value="<?= ${'participa' . $conn}[0]->id; ?>">
                                                            <input type="hidden" name="conn" id="conn" value="<?= $conn; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.col-->
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
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
                                <button class="btn btn-sm btn-danger" type="reset" onclick="window.location = 'sistema.php?mod=jobs&st=<?= $st; ?>'"><i class="fa fa-ban"></i> Voltar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main> 
<script>
    $(document).ready(function () {
        editor('descricao');
<?php
for ($i = 1; $i <= $conn; $i++) {
    echo "editorBasico('obs" . $i . "');";
}
?>
    });
</script>