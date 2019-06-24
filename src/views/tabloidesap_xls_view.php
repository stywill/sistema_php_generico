<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Tabloide </li>          
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="row">              
                <!-- /.col-->
                <div class="col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Tabloide</strong>
                            <small>Exportar</small>
                        </div>
                        <div class="card-body"> 
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="fa fa-align-justify"></i> <strong>Filtros</strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-sm-2">
                                                        <label for="postal-code">Exportar</label>
                                                    </div>    
                                                    <div class="form-group col-sm-4"> 
                                                        <select class="form-control" name="export" id="export">
                                                            <option value="">--Selecione</option>
                                                            <option value="laminas" <?=($export=='laminas')?"selected":"";?>>Por Lamina</option>
                                                            <option value="operacoes" <?=($export=='operacoes')?"selected":"";?>>Por Cdd / Revendas</option>
                                                        </select>             
                                                    </div>                                            
                                                </div>                                                
                                                <div class="row">
                                                    <div class="form-group col-sm-2">
                                                        <label for="postal-code">Geo</label>
                                                    </div>    
                                                    <div class="form-group col-sm-4"> 
                                                        <?= $core->selectClass("geo", "geo", "form-control", "", "geo,geo", "", "aux_estados", "id<>0 GROUP BY geo", "geo", $geo, "--Selecione"); ?>                                         
                                                    </div>                                            
                                                </div>                                                
                                                <div class="row">
                                                    <div class="form-group col-sm-2">
                                                        <label for="postal-code">Lamina</label>
                                                    </div>    
                                                    <div class="form-group col-sm-4"> 
                                                        <input type="text" class="form-control" name="lamina" id="lamina" value="<?= $lamina; ?>">
                                                    </div>                                                                                            
                                                </div>                                                
                                                <div class="row">   
                                                    <div class="form-group col-sm-8"> 
                                                        <button class="btn btn-primary"  type="submit"><i class="fa fa-search fa-lg"></i> Buscar</button>
                                                        <button type="button" class="btn default" onclick="window.location = '<?= $core->buildModLink($core->_vars['page']['mod'], 'exp', ''); ?>';">Resetar Busca</button>
                                                    </div>                                                                                            
                                                </div>                                                
                                            </div>                                                                                    
                                        </div>
                                        <!-- /.col-->
                                    </div>                                  
                                </div>
                            </form>
                            <?php
                            if($exports){
                            ?>
                            <form class="form-horizontal" action="excel/tabloide_<?= $export; ?>.php?axn=<?= $ver; ?>&geo=<?=$geo?>&lamina=<?=$lamina;?>" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="fa fa-align-justify"></i> Laminas</div>
                                            <div class="card-body">
                                                <table class="table table-responsive-sm table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Lamina</th>
                                                            <th>Geo</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($exports as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><?=$value->nome;?></td>
                                                                <td><?=$core->gsi('geo',$core->db_prefix.'aux_estados','id='.$value->id_estado_geo);?></td>
                                                                <td> <a class="btn btn-success"  href="excel/tabloide_<?= $export; ?>.php?axn=<?= $ver; ?>&lid=<?= $value->id; ?>"><i class="fa fa-file-excel-o fa-lg"></i> Exportar</a></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-footer">
                                                <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-file-excel-o fa-lg"></i> Exportar Todas</button>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php
                            }
                            ?>
                        </div>
                    </div>    
                </div>
                <!-- /.col-->
            </div>  
            <div class="row">
                <br><br><br><br>
            </div>    
        </div>
    </div>
</main>
