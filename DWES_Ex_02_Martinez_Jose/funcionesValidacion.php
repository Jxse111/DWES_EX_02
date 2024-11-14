<?php

require_once './patrones.php';

// Funcion de validacion de nombre
function validarCadena($cadena) {
    $cadena = trim($cadena);
    $cadena = stripcslashes($cadena);
    $cadena = strip_tags($cadena);
    $cadena = htmlspecialchars($cadena);
    return $cadena;
}

function validarDni($dni) {
    global $patronDni;
    $dni = validarCadena($dni);
    $esValido = preg_match($patronDni, $dni);
    return $esValido ? $dni : false;
}

function validarNombre($nombre) {
    global $patronNombreYApellidos;
    if (validarCadena($nombre)) {
        if (preg_match($patronNombreYApellidos, $nombre)) {
            $resultado = $nombre;
        } else {
            $resultado = false;
        }
    } else {
        $resultado = false;
    }
    return $resultado;
}

function validarEmail($email) {
    global $patronEmail;
    $email = validarCadena($email);
    $esValido = preg_match($patronEmail, $email);
    return $esValido ? $email : false;
}

function validarUrl($url) {
    global $patronUrl;
    $url = validarCadena($url);
    $esValido = preg_match($patronUrl, $url);
    return $esValido ? $url : false;
}

// Funcion de validacion de edad
function validarEdad($numero) {
    $opciones = array('options' => array('min_range' => 18, 'max_range' => 100));
    return filter_has_var($numero, FILTER_VALIDATE_INT, $opciones) ? $numero : false;
}

// Funcion de validacion de sexo
function validarSexo($campo) {
    $sexo = ["Masculino", "Femenino", "Otro"];
    return in_array($campo, $sexo) ? $campo : false;
}

// Funcion de validacion de aficiones
function validarAficiones($campo) {
    $aficionValidada = ["deportes", "musica", "alimentacion", "moda"];
    foreach ($campo as $aficion) {
        if (!in_array($aficion, $aficionValidada)) {
            $campo = false;
        }
    }
    return $campo;
}

// Funcion de validacion de módulos
function validarMódulos($modulos) {
    $modulosValidos = ["DWES", "DWEC", "DIWEB", "EIE", "DESAW", "HLC"];
    if (is_array($modulos)) {
        $resultado = array_intersect($modulos, $modulosValidos);
        return $resultado ? $resultado : false; // Retorna los módulos válidos o false si no hay
    }
}

// Funcion de validacion de categorías
function validarCategorías($categorias) {
    $categoriasValidas = ["Sprint", "Olímpica", "Ironman"];
    return in_array($categorias, $categoriasValidas) ? $categorias : false;
}

// Función de validación de año
function validarAño($anio) {
    global $patronAnio;
    $anio = filter_var($anio, FILTER_VALIDATE_INT); // Validamos que sea un entero
    $esValido = ($anio !== false && preg_match($patronAnio, $anio)); // Verificamos la validez
    return $esValido ? $anio : false; // Retorna el año si es válido, o false
}

// Funcion de validacion de provincias
function validarProvincias($campo) {
    $provincia = ["Almería", "Granada", "Córdoba", "Jaen", "Sevilla", "Huelva", "Málaga"];
    return in_array($campo, $provincia) ? $campo : false;
}

// Función de validación de numero
function validarNumero($numero) {
    $numero = validarCadena($numero); // Eliminamos etiquetas HTML
    if (is_numeric($numero)) {
        $esValido = $numero;
    } else {
        $esValido = false;
    }
    return $esValido;
}

// Función de validación de precio
function validarPrecio($numero) {
    $numero = strip_tags(htmlspecialchars($numero)); // Eliminamos etiquetas HTML
    $esValido = filter_var($numero, FILTER_VALIDATE_FLOAT);
    return $esValido ? $numero : false; // Retorna el nombre si es válido, o false
}

//Función de validacion del iva
function validarIVA($iva) {
    $valoresPermitidos = [0.21, 0.18];
    return in_array((float) $iva, $valoresPermitidos, true) ? (float) $iva : null;
}

//Funcion para validar matriculas Españolas
function validarMatricula($matricula) {
    global $patronMatricula;
    $matricula = validarCadena($matricula);
    $esValido = preg_match($patronMatricula, $matricula);
    return $esValido ? $matricula : false;
}

//Funcion que valida las marcas
function validarMarcas($marca) {
    $marcasValidas = ["Chrysler", "BMW", "Audi", "Otro"];
    return in_array($marca, $marcasValidas) ? $marca : false;
}

//Funcion para validar reparaciones
function validarReparacion($reparacion) {
    $reparacionesValidas = ["Cambio de aceite", "Cambio de filtros", "Correa de distribución", "Cambio de 2 neumáticos"];
    $resultadosValidos = [];
    if (is_array($reparacion)) {
        foreach ($reparacion as $valor) {
            if (in_array($valor, $reparacionesValidas)) {
                $resultadosValidos[] = $valor;
            }
        }
    }
    return $resultadosValidos; // Retorna solo las reparaciones válidas
}

//Funcion que valida el color
function validarColor($color) {
    $coloresPermitidos = ["Blanco", "Negro", "Rojo", "Otro"];
    return in_array($color, $coloresPermitidos) ? $color : false;
}

// Funcion de validacion de Modalidades
function validarModalidades($modalidades) {
    $modalidadesValidas = ["Individual", "Grupal", "Por club", "Federado/a"];
    if (is_array($modalidades)) {
        $resultado = array_intersect($modalidades, $modalidadesValidas);
        return $resultado ? $resultado : false; // Retorna las categorías válidas o false si no hay
    }
}
