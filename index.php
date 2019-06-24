<?php
session_cache_limiter('nocache');
session_start();

//se quiser carregar qualquer variável, é aqui, antes da chamada da classe!
include('processa/__core.php');
$core = new core();
?>
<html lang="en">
    <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
        <meta name="author" content="Łukasz Holeczek">
        <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
        <title><?= $core->_core_titulo; ?></title>
        <!-- Icons-->
        <link href="https://unpkg.com/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/flag-icon-css/3.2.0/css/flag-icon.min.css" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
        <!-- Main styles for this application-->
        <link href="src/css/style.css" rel="stylesheet">
        <link href="src/css/customizado.css" rel="stylesheet">
        <link href="src/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
        <!-- Global site tag (gtag.js) - Google Analytics-->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <!-- Global site tag (gtag.js) - Google Analytics-->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            // Shared ID
            gtag('config', 'UA-118965717-3');
            // Bootstrap ID
            gtag('config', 'UA-118965717-5');
        </script>
    </head>
    <body class="app flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-group">
                        <div class="card p-4">
                            <div class="card-body">
                                <form action="processa/login.php" name="clogin" id="clogin" method="post" enctype="multipart/form-data"> 
                                    <h1>Bem vindo.</h1>
                                    <p class="text-muted">Por favor, faça o login.</p>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="icon-user"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" type="text" placeholder="Usuario" name="login" id="login">                                     
                                    </div>
                                    <div class="error"> 
                                        <label id="login_validate"></label> 
                                    </div>
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="icon-lock"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" type="password" placeholder="Senha" name="senha" id="senha">
                                    </div>
                                    <div class="error"> 
                                        <label id="senha_validate"></label> 
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit">Entrar</button>
                                        </div>
                                    </div>
                                    <?php
                                    if ($ac) {
                                        echo '<br><div class="error">Usuario não encontrado</div>';
                                    }
                                    ?>

                                </form>
                            </div>
                        </div>
                        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:40%">
                            <div class="card-body text-center">
                                <div>                                    
                                    <img src="src/img/brand/BW2.png" alt="BW" width="250px" height="auto">                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CoreUI and necessary plugins-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.min.js"></script>
        <script src="src/js/coreui.min.js"></script>
        <script src="src/js/jquery.maskedinput.min.js"></script>
        <script src="src/js/jquery.validate.js"></script>
        <script src="src/js/validacoes.js"></script>
        <script src="src/js/mascara.js"></script>
        
    </body>
</html>
