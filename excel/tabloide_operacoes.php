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
$arquivo = (!$lid) ? 'tabloides_cdd_revenda_' . date('d-m-Y') . '.xls' : 'tabloide_cdd_revenda_' . $core->sanitizeString($dados[0]->nome) . '_' . date('d-m-Y') . '.xls';
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
   .qtds td{
        background-color:#9999994f;
        color:white;
        text-align: center;
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
    $html .= '<th colspan="10" rospan="2"><center>' . utf8_decode($core->gsi('geo',$db_prefix.'aux_estados','id='.$tabloide->id_estado_geo)).' - '.utf8_decode($tabloide->nome) . '</center></th>';
    $html .= '</tr>';
    $html .= '<tr>';
    $html .= '<td><b>' . utf8_decode("GEO") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("CDD/Revenda") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("Cidade") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("Endereço") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("Cep") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("CNPJ") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("IE") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("Responçavel") . '</b></td>';
    $html .= '<td><b>' . utf8_decode("Telefone") . '</b></td>';
    $html .= '<td><b>Quantidade</b></td>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';    
    $cols = "top.quantidade,op.operacao'ope',op.cidade'cidade',op.endereco'endereco',op.cep'cep',op.cnpj'cnpj',op.ie'ie',op.responsavel'responsavel',op.contato_resp'contato'";
    $ops = $core->gsim($cols, "operacoes op , bwt_tabloide_operacoes top", "op.id = top.id_operacao AND top.id_tabloide =" . $tabloide->id);

    foreach ($ops as $key => $op) {
        $html .= '<td>' . utf8_decode($core->gsi('geo',$db_prefix.'aux_estados','id='.$tabloide->id_estado_geo)) . '</td>';
        $html .= '<td>' . utf8_decode($op->ope) . '</td>';
        $html .= '<td>' . utf8_decode($op->cidade) . '</td>';
        $html .= '<td>' . utf8_decode($op->endereco) . '</td>';
        $html .= '<td>' . utf8_decode($op->cep) . '</td>';
        $html .= '<td>' . utf8_decode($op->cnpj) . '</td>';
        $html .= '<td>' . utf8_decode($op->ie) . '</td>';
        $html .= '<td>' . utf8_decode($op->responsavel) . '</td>';
        $html .= '<td>' . utf8_decode($op->contato) . '</td>';
        $html .= '<td class="qtds"><b>' . utf8_decode($op->quantidade) . '<b></td>';
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
