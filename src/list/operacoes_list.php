<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Operação</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Lista
                        </div>
                        <div class="card-body">
                            <table id="tab_jobs" class="table table-responsive-sm table-striped table-bordered datatable dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th class="sorting">Geo</th>
                                        <th class="sorting">Operação</th>
                                        <th class="sorting">CNPJ</th>
                                        <th class="sorting">IE</th>
                                        <th class="sorting">Responsavel</th>
                                        <th class="sorting">Contato</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dados as $key => $value) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $value->geo; ?>
                                            </td>
                                            <td>
                                                <?= $value->operacao; ?>
                                            </td>
                                            <td>
                                                <?= $value->cnpj; ?>
                                            </td>
                                            <td>
                                                <?= $value->ie; ?>
                                            </td>
                                            <td>
                                                <?= $value->responsavel; ?>
                                            </td>
                                            <td class="<?= $alert; ?>">
                                                <?= $value->contato_resp; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($core->_vars['user']['ga']==3) {
                                                    ?>
                                                    <a class="btn btn-success" href="sistema.php?mod=<?= $mod; ?>&ver=editar&axn=view&lid=<?= $value->id; ?>"><i class="fa fa-search-plus"></i></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a class="btn btn-info" href="sistema.php?mod=<?= $mod; ?>&ver=editar&st=<?= $st; ?>&lid=<?= $value->id; ?>"><i class="fa fa-edit"></i></a>
                                                        <?php
                                                    }
                                                    ?>
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
    /*
     para ordernar datas de forma correta
     <span style="display:none;">YYYY-MM-dd</span> dd/MM/YYYY
     */
    $(document).ready(function () {
        $('#tab_jobs').DataTable({

            pagingType: 'full',
            "language": {
                "search": "Buscar:",
                "info": "_START_ à _END_ de _TOTAL_",
                "lengthMenu": " Mostrar _MENU_",
                "infoEmpty": "0 à 0 de 0",
                "infoFiltered": "(filtrado de _MAX_ total)",
                "zeroRecords": "Nenhum registro encontrado",
                "thousands": ".",
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