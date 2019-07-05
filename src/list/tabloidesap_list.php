<?php ?>
<main class="main" >
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Tabloide</li>        
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">           
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Lista</div>
                        <div class="card-body">
                            <table id="tab_areas" class="table table-responsive-sm table-striped table-bordered datatable dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>Geo</th>
                                        <th>Usuário</th>
                                        <th>Lamina</th>
                                        <th>Data Criação</th> 
                                        <th>Arte final</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dados as $key => $value) {
                                        if ($value->aprovado == 'A') {
                                            $statusAf = '<span class="badge badge-success">Aprovado</span>';
                                        } elseif ($value->aprovado == 'R') {
                                            $statusAf = ' <span class="badge badge-danger">Reprovado</span>';
                                        } elseif ($value->aprovado == 'P' && $value->imagem) {
                                            $statusAf = '<span class="badge badge-warning">Pendente</span>';                  
                                        } else {
                                            $statusAf = '';
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $core->gsi("geo",$core->db_prefix.'aux_estados','id='.$value->id_estado_geo); ?></td>
                                            <td><?= $core->gsi("nome",$core->db_prefix.'usuarios','id='.$value->id_usuario); ?></td>
                                            <td><?= $value->nome; ?></td>
                                            <td><label style="display: none;"><?= $value->data_criacao; ?></label><?= $core->exibedata($value->data_criacao); ?></td>                  
                                            <td><?= $statusAf; ?></td>
                                            <td>
                                                <a class="btn btn-info"  href="sistema.php?mod=<?=$mod;?>&ver=editar&lid=<?= $value->id; ?>"><i class="fa fa-edit"></i></a>                     
                                                <!--
                                                <button class="btn btn-danger" onclick="excluirConfirma('Deseja excluir esse Inscrito', 'aj_excluir.php?tipo=D&tab=reveillon_inscritos&valor=I&campo=status&id=<?= $value->id; ?>', 'noRet')">
                                                    <i class="fa fa-trash-o"></i>
                                                </button> 
                                                -->
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
        $('#tab_areas').DataTable({
            order: [[ 3, "desc" ]],
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