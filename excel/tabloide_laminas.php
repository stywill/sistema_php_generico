<?php

// -----------------------------------------------
session_cache_limiter('nocache');
session_start();

include('../processa/__core.php');
$core = new core();
//$core->load();
// -----------------------------------------------
/*
 * Criando e exportando planilhas do Excel
 * /
 */
$db_prefix = $core->db_prefix;

if ($geo || $lamina) {
    $busca = ($geo) ? " id_estado_geo IN (select id from " . $db_prefix . "aux_estados where geo = '" . $geo . "')" : "";
    if ($geo && $lamina) {
        $busca .= " AND nome like '%" . $lamina . "%'";
    } elseif ($lamina) {
        $busca .= " nome like '%" . $lamina . "%'";
    } else {
        $busca .= "";
    }
}
$qf = (!$lid) ? $busca : " id=" . $lid;
$dados = $core->gsim("*", "tabloides", "aprovado='P' AND " . $qf);

// Definimos o nome do arquivo que será exportado
$arquivo =(!$lid)?'tabloides_' . date('d-m-Y') . '.xls':'tabloide_'.$core->sanitizeString($dados[0]->nome).'_' . date('d-m-Y') . '.xls';
// Criamos uma tabela HTML com o formato da planilha
$html = '';
$html .= '      
<style>
    body, table {
       font-family: Arial;
       font-size:12px;
   }

   table th {
       background-color:#999999;
       color:white;
       font-family: Arial;
       font-weight: bold;
       font-size:20px;
   }

   table td {
       font-family: Arial;
       font-size:12px;
       color:black;
   }
</style> ';
$html .= '<table  width="100%">';
$html .= '<tr><td></td></tr>';
foreach ($dados as $key => $tabloide) {
    $html .= '<tr>';
    $html .= '<td>';
    $html .= '<table width="70%" height="28"  border="1" cellspacing="0" cellpadding="0">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th colspan="6" rospan="2"><center>' . utf8_decode($tabloide->nome) . '</center></th>';
    $html .= '</tr>';
    $html .= '<tr>';
    $html .= '<td><b>' . utf8_decode("GEO") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("Tipo de Lâmina") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("Produto") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("Posição") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("De") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("Por") . '</b></td>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';   
    $capas = $core->gsim("*", "tabloide_capas", "id_tabloide=" . $tabloide->id);
    foreach ($capas as $key => $capa) {
        $html .= '<tr>';
        $html .= '<td>' . utf8_decode($core->gsi('geo',$db_prefix.'aux_estados','id='.$tabloide->id_estado_geo)) . '</td>';
        $html .= '<td>' . utf8_decode($tabloide->nome) . '</td>';
        $html .= '<td>' . utf8_decode($core->gsi("nome", $db_prefix . "produtos", "id=" . $capa->id_produto)) . '</td>';
        $html .= '<td>CAPA</td>';
        $html .= '<td>' . $capa->de . '</td>';
        $html .= '<td>' . $capa->por . '</td>';
        $html .= '</tr>';
    }
    $versos = $core->gsim("*", "tabloide_versos", "id_tabloide=" . $tabloide->id);
    foreach ($versos as $key => $verso) {
        $html .= '<tr>';
        $html .= '<td>' . utf8_decode($core->gsi('geo',$db_prefix.'aux_estados','id='.$tabloide->id_estado_geo)) . '</td>';
        $html .= '<td>' . utf8_decode($tabloide->nome) . '</td>';
        $html .= '<td>' . utf8_decode($core->gsi("nome", $db_prefix . "produtos", "id=" . $verso->id_produto)) . '</td>';
        $html .= '<td>VERSO</td>';
        $html .= '<td>' . $verso->de . '</td>';
        $html .= '<td>' . $verso->por . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</td>';
    $html .= '</tr>';
}

$html .= '</table>';
// Configurações header para forçar o download

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
header("Content-Description: PHP Generated Data");

// Envia o conteúdo do arquivo
echo $html;
exit;
