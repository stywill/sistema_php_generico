<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="BW - Tabloides">
        <meta name="author" content="Wilson Vicente">
        <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
        <title><?= $core->_core_titulo; ?></title>
        <!-- Icons-->
        <link href="https://unpkg.com/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/flag-icon-css/3.2.0/css/flag-icon.min.css" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">       
        <!-- Main styles for this application-->
        <link href="src/css/style.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <!-- Global site tag (gtag.js) - Google Analytics-->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="src/js/Chart.bundle.js"></script>
        <script src="src/js/utils.js"></script>

        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>    
    
        <script type="text/javascript" src="https://cdn.ckeditor.com/4.11.3/standard-all/ckeditor.js"></script>
        
    </head>
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <header class="app-header navbar">
            <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="sistema.php">
                <img class="navbar-brand-full" src="src/img/brand/BW.png" width="70" height="70" alt="<?= $core->_core_titulo; ?>">
                <img class="navbar-brand-minimized" src="src/img/brand/BW.png" width="70" height="70" alt="BW Logo">
                <!--
                <img class="navbar-brand-full" src="src/img/brand/logo.svg" width="89" height="25" alt="<?= $core->_core_titulo; ?>">
                <img class="navbar-brand-minimized" src="src/img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
                -->
            </a>
            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="nav navbar-nav d-md-down-none">
                <li class="nav-item px-3">
                    <?=($core->_database_use=='local')?'<div class="alert alert-danger mb-xl-0" role="alert">Usando Base Local</div>':'';?>
                   
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">       
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                      <!--<img class="img-avatar" src="src/img/avatars/6.jpg" alt="admin@bootstrapmaster.com">-->
                        <a class="nav-link" href="#"><h5>Olá <?= $core->priNome($core->_vars['user']['nome']); ?></h5></a>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>Account</strong>
                        </div>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-bell-o"></i> Updates
                            <span class="badge badge-info">42</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope-o"></i> Messages
                            <span class="badge badge-success">42</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-tasks"></i> Tasks
                            <span class="badge badge-danger">42</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-comments"></i> Comments
                            <span class="badge badge-warning">42</span>
                        </a>
                        <div class="dropdown-header text-center">
                            <strong>Settings</strong>
                        </div>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-user"></i> Profile</a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-wrench"></i> Settings</a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-usd"></i> Payments
                            <span class="badge badge-secondary">42</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-file"></i> Projects
                            <span class="badge badge-primary">42</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-shield"></i> Lock Account</a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-lock"></i> Logout</a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
                <span class="navbar-toggler-icon"></span>
            </button>
            <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
                <span class="navbar-toggler-icon"></span>
            </button>
        </header>
