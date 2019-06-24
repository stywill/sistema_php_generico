<?php


function statusv($st) {
    switch ($st) {
        case 0: $sv = "Pendente"; break;
        case 1: $sv = "Aprovada"; break;
        case 2: $sv = "Reprovada"; break;
        case 3: $sv = "Ambev Avaliar"; break;
        case 4: $sv = "Foto Duplicada"; break;
        //default: $sv = "Pendente"; break;
    }
    return $sv;
}