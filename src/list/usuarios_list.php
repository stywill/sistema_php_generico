<?php ?>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Usuários</li>        
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">           
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Lista</div>
                        <div class="card-body">
                            <table id="tab_inscritos" class="table table-responsive-sm table-striped table-bordered datatable dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Login</th>
                                        <th>Grupo</th>
                                        <th>Geo</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dados as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?= $value->nome; ?></td>
                                            <td><?= $value->email; ?></td>
                                            <td><?= $value->login; ?></td>
                                            <td><?= $core->gsi('grupo',$core->db_prefix.'grupos_acessos','id='.$value->id_grupo)?></td>
                                            <td><?= $core->gsi('geo',$core->db_prefix.'aux_estados','id='.$value->id_estado_geo); ?></td>
                                            <td>
                                                <!--<a class="btn btn-success" href="sistema.php?mod=inscritos&ver=editar&ac=inf&lid=<?= $value->id; ?><?php echo '&freg=' . $freg . '&fop=' . $fop . '&codpdv=' . $codpdv; ?>"><i class="fa fa-search-plus"></i></a>-->
                                                <a class="btn btn-info"  href="sistema.php?mod=usuarios&ver=editar&lid=<?= $value->id; ?>"><i class="fa fa-edit"></i></a>                     
                                                <button class="btn btn-danger" onclick="excluirConfirma('Deseja excluir esse Inscrito', 'aj_excluir.php?tipo=D&tab=reveillon_inscritos&valor=I&campo=status&id=<?= $value->id; ?>', 'noRet')">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>                        
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>                  
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>         
        </div>
    </div>
</main>
<script>
    $(document).ready(function () {
        $('#tab_inscritos').DataTable({
             pagingType: 'full',
            "language": {
                "search": "Buscar:",
                "info": "_START_ à _END_ de _TOTAL_",
                "lengthMenu":" Mostrar _MENU_",
                "infoEmpty":"0 à 0 de 0",
                "infoFiltered":"(filtrado de _MAX_ total)",
                "zeroRecords":"Nenhum registro encontrado",
                "thousands":".",
                "paginate": {
                    "first": '«',
                    "previous": '‹',
                    "next": '›',
                    "last": '»'
                },
                "aria": {
                    "paginate": {
                        "first": 'Prim.',
                        "previous": 'Ante.',
                        "next": 'Próx.',
                        "last": 'Ulti.'
                    }
                }
            }
        });
    });
</script>