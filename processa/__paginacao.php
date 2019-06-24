<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of __paginacao
 *
 * @author Wilson Oliveira
 */
class paginacao extends core {

    public function metr_echo($stats) {
        if ($stats) {
            return 'page-item';
        } else {
            return ' class="prev disabled"';
        }
    }

    public function metr_returnActive($lipos, $ppos) {
        if ($lipos == $ppos) {
            return ' page-item active';
        } else {
            return '';
        }
    }

    public function pagination($pag, $limitipp, $pagLink, $itens, $tabela, $qf) {


        $pag = (!$pag) ? 1 : $pag;
        $limitipp = (!$limitipp) ? 20 : $limitipp; //abrir opção depois?
        $limitpage = $pag - 1;
        $limitsql = $limitpage * $limitipp;

        $total_items = $this->gsi("count(id)", $this->db_prefix . $tabela, "(" . $qf . ")");
        $total_pags = ceil($total_items / $limitipp);

//paginação - posição 
        $vf_plastp = $total_pags - 1;
        if ($pag == 1) {
            $ppos = 1;
        } elseif ($pag == $total_pags) {
            $ppos = 5;
        } elseif ($pag == 2) {
            $ppos = 2;
        } elseif ($pag == $vf_plastp) {
            $ppos = 4;
        } else {
            $ppos = 3;
        }

        $link_prefix = $pagLink;
        $link_prefix .= $filterlink;

        $tmpvpn = $pag + 1;
        $tmpvpp = $pag - 1;
        if ($tmpvpp == 0) {
            $tmpvpp = 1;
        }

//JUMP PAGES (+- 5)
        $vf_jump_next = $pag + 5;
        $vf_jump_prev = $pag - 5;
        if ($vf_jump_next >= $total_pags) {
            $next_jump = $total_pags;
        } else {
            $next_jump = $vf_jump_next;
        }
        if ($vf_jump_prev <= 1) {
            $prev_jump = 1;
        } else {
            $prev_jump = $vf_jump_prev;
        }

//NEXT/PREV
        if ($pag == 1) {
            $next_pag = $pag + 1;
            $next_pag_st = true;
            $next_jump_st = true;
            $prev_pag = 0;
            $prev_pag_st = false;
            $prev_jump_st = false;

            $next_page_link = $link_prefix . "&pag=" . $tmpvpn;
            $prev_page_link = "#";
            $next_jump_link = $link_prefix . "&pag=" . $vf_jump_next;
            $prev_jump_link = "#";
        } elseif ($pag == $total_pags) {
            $next_pag = 0;
            $next_pag_st = false;
            $next_jump_st = false;
            $prev_pag = $pag - 1;
            $prev_pag_st = true;
            $prev_jump_st = true;

            $next_page_link = "#";
            $prev_page_link = $link_prefix . "&pag=" . $tmpvpp;
            $prev_jump_link = $link_prefix . "&pag=" . $vf_jump_prev;
            $next_jump_link = "#";
        } else {
            $next_pag = $pag + 1;
            $next_pag_st = true;
            $next_jump_st = true;
            $prev_pag = $pag - 1;
            $prev_pag_st = true;
            $prev_jump_st = true;

            $next_page_link = $link_prefix . "&pag=" . $tmpvpn;
            $prev_page_link = $link_prefix . "&pag=" . $tmpvpp;
            $prev_jump_link = $link_prefix . "&pag=" . $vf_jump_prev;
            $next_jump_link = $link_prefix . "&pag=" . $vf_jump_next;
        }
// ------// ------// ------// ------// ------// ------// ------
        $pagearray = array(
            1 => array('', ''),
            2 => array('', ''),
            3 => array('', ''),
            4 => array('', ''),
            5 => array('', '')
        );

//build the 5 links -- dava pra ter feito em um loop mas n vai rolar por tempo =/
        $tmpvp = 0;
        if ($ppos == 1) {
            $pagearray[1][0] = $pag;
            $pagearray[1][1] = "#";
            $tmpvp = $pag;
            for ($j = 2; $j < 6; $j++) {
                $tmpvp++;
                $pagearray[$j][0] = $tmpvp;
                $pagearray[$j][1] = $link_prefix . "&pag=" . $tmpvp;
            }
        } elseif ($ppos == 2) {
            $tmpvp = $pag - 1;
            $pagearray[1][0] = $tmpvp;
            $pagearray[1][1] = $link_prefix . "&pag=" . $tmpvp;
            $pagearray[2][0] = $pag;
            $pagearray[2][1] = "#";
            $tmpvp = $pag;
            for ($j = 3; $j < 6; $j++) {
                $tmpvp++;
                $pagearray[$j][0] = $tmpvp;
                $pagearray[$j][1] = $link_prefix . "&pag=" . $tmpvp;
            }
        } elseif ($ppos == 3) {
            $tmpvp = 0;
            $pagearray[3][0] = $pag;
            $pagearray[3][1] = "#";
            $tmpvp = $pag - 1;
            $pagearray[2][0] = $tmpvp;
            $pagearray[2][1] = $link_prefix . "&pag=" . $tmpvp;
            $tmpvp = $pag - 2;
            $pagearray[1][0] = $tmpvp;
            $pagearray[1][1] = $link_prefix . "&pag=" . $tmpvp;
            $tmpvp = $pag + 1;
            $pagearray[4][0] = $tmpvp;
            $pagearray[4][1] = $link_prefix . "&pag=" . $tmpvp;
            $tmpvp = $pag + 2;
            $pagearray[5][0] = $tmpvp;
            $pagearray[5][1] = $link_prefix . "&pag=" . $tmpvp;
        } elseif ($ppos == 4) {
            $tmpvp = $pag + 1;
            $pagearray[5][0] = $tmpvp;
            $pagearray[5][1] = $link_prefix . "&pag=" . $tmpvp;
            $pagearray[4][0] = $pag;
            $pagearray[1][1] = "#";
            $tmpvp = $pag;
            for ($j = 3; $j > 0; $j--) {
                $tmpvp--;
                $pagearray[$j][0] = $tmpvp;
                $pagearray[$j][1] = $link_prefix . "&pag=" . $tmpvp;
            }
        } elseif ($ppos == 5) {
            $pagearray[5][0] = $total_pags;
            $pagearray[1][1] = "#";
            $tmpvp = $pag;
            for ($j = 4; $j > 0; $j--) {
                $tmpvp--;
                $pagearray[$j][0] = $tmpvp;
                $pagearray[$j][1] = $link_prefix . "&pag=" . $tmpvp;
            }
        }
// ------// ------// ------// ------// ------// ------// ------
       /*
        $page_cod = '<div align="right"> <div> <ul class="pagination">'
                . '<li' . $this->metr_echo($prev_jump_st) . '>'
                . '<a href="' . $prev_jump_link . '">'
                . '<i class="fa fa-angle-double-left"></i>'
                . '</a>'
                . '</li>'
                . '<li' . $this->metr_echo($prev_pag_st) . '>'
                . '<a href="' . $prev_page_link . '">'
                . '<i class="fa fa-angle-left"></i>'
                . '</a>'
                . '</li>';
        for ($c = 1; $c < 6; $c++) {
            $page_cod .= '<li' . $this->metr_returnActive($c, $ppos) . '>'
                    . '<a href="' . $pagearray[$c][1] . '"> ' . $pagearray[$c][0] . ' </a>'
                    . '</li>';
        }
        $page_cod .= '<li' . $this->metr_echo($next_pag_st) . '>'
        . '<a href="' . $next_page_link . '">'
        . '<i class="fa fa-angle-right"></i></a>'
        . '</li>'
        . '<li' . $this->metr_echo($next_jump_st) . '>'
        . '<a href="' . $next_jump_link . '">'
        . '<i class="fa fa-angle-double-right"></i>'
        . '</a>'
        . '</li>'
        . '</ul> </div> </div>';
*/
       $page_cod = '<nav> 
           <ul class = "pagination">
           <li class = "' . $this->metr_echo($prev_jump_st) . '">
        <a class = "page-link" href = "' . $prev_page_link . '">Ante.</a>
        </li>';
        for ($c = 1; $c < 6; $c++) {
            $page_cod .= '<li class = "' . $this->metr_returnActive($c, $ppos) . '">
                        <a class = "page-link" href = "' . $pagearray[$c][1] . '">' . $pagearray[$c][0] . '</a>
                          </li>';
        }
         $page_cod .= '<li class = "' . $this->metr_echo($next_pag_st) . '">
        <a class = "page-link" href = "' . $next_page_link . '">Próx.</a>
        </li>
        </ul>
        </nav >';
// ------  // ------// ------// ------// ------// ------// ------// ------    

                $retorno = array('page_cod' => $page_cod, 'dados' => $this->gsim($itens, $tabela, $qf . " LIMIT $limitsql,$limitipp"),'query'=>$this->gsi2($itens, $tabela, $qf . " LIMIT $limitsql,$limitipp"));
        return $retorno;
    }

}
