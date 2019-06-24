<?php
// -----------------------------------------------
session_cache_limiter('nocache');
session_start();

//se quiser carregar qualquer variável, é aqui, antes da chamada da classe!

include('__core.php');
//error_reporting(E_ALL);
$core = new core();
$ac = $core->auth();
//die ($ac);
// -----------------------------------------------
if ($ac < 0) { 
header("Location: ../index.php?ac=1");
} elseif ($ac == 0) {
//header("Location: primeiro-acesso.php");
} else { 
header("Location: ../sistema.php");
}
?>