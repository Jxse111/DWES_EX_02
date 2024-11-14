<?php

function suma($numero1, $numero2) {
    return $numero1 + $numero2;
}

function resta($numero1, $numero2) {
    return $numero1 - $numero2;
}

function multiplicación($numero1, $numero2) {
    return $numero1 * $numero2;
}

function división($numero1, $numero2) {
    return $numero1 / $numero2;
}

function calcularPuntuacion($tiempo1, $tiempo2, $tiempo3) {
    $puntuacionResultado = $tiempo1 + $tiempo2 + $tiempo3;
    return $puntuacionResultado;
}

function calcularPuesto($puntuacionTotal, $categoria) {
    $resultado = "";
    //En el caso de que la categoría sea Sprint
    if ($categoria == "Sprint" && $puntuacionTotal < 11000) {
        $resultado = "Con pódium";
    } else if ($categoria == "Sprint" && $puntuacionTotal > 11000 && $puntuacionTotal < 25000) {
        $resultado = "Finalista";
    } else if ($categoria == "Sprint" && $puntuacionTotal > 25000) {
        $resultado = "Sin premio";
    }
    //En el caso de que la categoría sea Olímpica
    if ($categoria == "Olímpica" && $puntuacionTotal < 17000) {
        $resultado = "Con pódium";
    } else if ($categoria == "Olímpica" && $puntuacionTotal > 17000 && $puntuacionTotal < 39000) {
        $resultado = "Finalista";
    } else if ($categoria == "Olímpica" && $puntuacionTotal > 39000) {
        $resultado = "Sin premio";
    }
    //En el caso de que la categoría sea Ironman
    if ($categoria == "Ironman" && $puntuacionTotal < 22000) {
        $resultado = "Con pódium";
    } else if ($categoria == "Ironman" && $puntuacionTotal > 22000 && $puntuacionTotal < 54000) {
        $resultado = "Finalista";
    } else if ($categoria == "Ironman" && $puntuacionTotal > 54000) {
        $resultado = "Sin premio";
    }
    return $resultado;
}
