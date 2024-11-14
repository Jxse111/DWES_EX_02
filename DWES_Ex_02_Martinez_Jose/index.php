<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once './funcionesValidacion.php';
        require_once './funciones.php';

        //Creación de variables
        $nombreCompletoSinFiltrar = filter_input(INPUT_POST, "nombreCompleto");
        $emailSinFiltrar = filter_input(INPUT_POST, "email");
        $fechaNacSinFiltrar = filter_input(INPUT_POST, "fechaNac");
        $generoSinFiltrar = filter_input(INPUT_POST, "género");
        $categoriaSinFiltrar = filter_input(INPUT_POST, "categoría");
        $modalidadesSinFiltrar = filter_input(INPUT_POST, "modalidades", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $tiempoNatSinFiltrar = filter_input(INPUT_POST, "tiempoNatacion");
        $tiempoCiclSinFiltrar = filter_input(INPUT_POST, "tiempoCiclismo");
        $tiempoCarrSinFiltrar = filter_input(INPUT_POST, "tiempoCarrera");
        $puntuacionTotal = "";
        $puestoCat = "";
        $formato = "%s,";

        $conjuntoCampos = $nombreCompletoSinFiltrar && $emailSinFiltrar && $fechaNacSinFiltrar && $generoSinFiltrar &&
                $categoriaSinFiltrar && $modalidadesSinFiltrar && $tiempoNatSinFiltrar && $tiempoCiclSinFiltrar &&
                $tiempoCarrSinFiltrar;

        //Si todos los campos existen dentro de la variable conjunto entonces valido todos los campos
        if ($conjuntoCampos) {
            $nombreCompleto = validarNombre($nombreCompletoSinFiltrar);
            $email = validarEmail($emailSinFiltrar);
            //Valido unicamente el año, ya que no se como aplicarlo a la fecha completa.
            $fechaNac = validarAño($fechaNacSinFiltrar);
            $genero = validarSexo($generoSinFiltrar);
            $categoria = validarCategorías($categoriaSinFiltrar);
            $modalidades = validarModalidades($modalidadesSinFiltrar);
            $tiempoNat = validarNumero($tiempoNatSinFiltrar);
            $tiempoCicl = validarNumero($tiempoCiclSinFiltrar);
            $tiempoCarr = validarNumero($tiempoCarrSinFiltrar);

            $camposValidados = $nombreCompleto && $email && $fechaNac && $genero && $categoria &&
                    $modalidades && $tiempoNat && $tiempoCicl && $tiempoCarr;

            //Si todos los campos son validos devuelvo el formulario de resultado y sino lo son muestro un erro de campos iválidos
            if (!$camposValidados) {
                echo "ERROR: campos inválidos o incorrectos";
            } else {
                $puntuacionTotal = calcularPuntuacion($tiempoNat, $tiempoCicl, $tiempoCarr);
                $puestoCat = calcularPuesto($puntuacionTotal, $categoria);
                ?>
                <h1>FORMULARIO RESULTANTE</h1>
                <form action="action">
                    <label>Nombre del participante:</label><br>
                    <input type="text" name="NombreParticipante" value="<?php echo $nombreCompleto ?>"><br><br>
                    <label>Categoría en la que compite: </label><br>
                    <input type="text"  name="CategoríasSeleccionadas" value="<?php echo $categoria ?>"><br><br>
                    <input type="text" name="modalidadesSeleccionadas" value="<?php
                    foreach ($modalidades as $claveModalidades => $modalidadesSeleccionadas) {
                        echo sprintf($formato, $modalidadesSeleccionadas);
                    }
                    ?>"><br><br> 
                    <label>Puntuación total: </label><br>
                    <input type="text" name="PuntuacionTotal" value="<?php echo $puntuacionTotal; ?>"><br><br>
                    <label>Puesto en la categoría:</label><br> 
                    <input type="text" name="PuestoCategoria" value="<?php echo $puestoCat ?>">
                </form><br><br>
                <hr>
                <?php
            }
        }
        ?>
        <h1>FORMULARIO PRINCIPAL</h1>
        <!-- Formulario principal -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <label for="matricula">Introduce tu nombre completo:</label>
            <input type="text" name="nombreCompleto" value="<?php if (filter_has_var(INPUT_POST, "nombreCompleto")) echo $nombreCompletoSinFiltrar; ?>"><br><br>
            <label for="marca">Introduce tu correo electrónico:</label>
            <input type="text" name="email" value="<?php if (filter_has_var(INPUT_POST, "email")) echo $emailSinFiltrar ?>"><br><br>
            <label for="modelo">Introduce tu año de nacimiento:</label>
            <input type="text" name="fechaNac" required value="<?php if (filter_has_var(INPUT_POST, "fechaNac")) echo $fechaNacSinFiltrar; ?>"><br><br>
            <label>Introduce tu género:</label><br>
            <input type="radio" name="género" value="Masculino" <?php if ($generoSinFiltrar === "Masculino") echo 'checked'; ?>> Masculino<br>
            <input type="radio" name="género" value="Femenino" <?php if ($generoSinFiltrar === "Femenino") echo 'checked'; ?>> Femenino<br>
            <input type="radio" name="género" value="Otro" <?php if ($generoSinFiltrar === "Otro") echo 'checked'; ?>> Otro<br><br>
            <label>Introduce tu categoría:</label><br>
            <input type="radio" name="categoría" value="Sprint" <?php if ($categoriaSinFiltrar === "Sprint") echo 'checked'; ?>> Sprint<br>
            <input type="radio" name="categoría" value="Olímpica" <?php if ($categoriaSinFiltrar === "Olímpica") echo 'checked'; ?>> Olímpica<br>
            <input type="radio" name="categoría" value="Ironman" <?php if ($categoriaSinFiltrar === "Ironman") echo 'checked'; ?>> Ironman<br><br>
            <label>Marque las modalidades en las que compite:</label><br>
            <input type="checkbox" name="modalidades[]" value="Individual"  <?php if (filter_has_var(INPUT_POST, "modalidades") && in_array("Individual", $modalidadesSinFiltrar)) echo 'checked'; ?>>Individual<br>
            <input type="checkbox" name="modalidades[]" value="Grupal"  <?php if (filter_has_var(INPUT_POST, "modalidades") && in_array("Grupal", $modalidadesSinFiltrar)) echo 'checked'; ?>>Grupal<br>
            <input type="checkbox" name="modalidades[]" value="Por club"  <?php if (filter_has_var(INPUT_POST, "modalidades") && in_array("Por club", $modalidadesSinFiltrar)) echo 'checked'; ?>>Por club<br>
            <input type="checkbox" name="modalidades[]" value="Federado/a"  <?php if (filter_has_var(INPUT_POST, "modalidades") && in_array("Federado/a", $modalidadesSinFiltrar)) echo 'checked'; ?>>Federado/a<br><br>
            <label>Puntuaciones de cada prueba: </label><br><br>
            <label>Natacion: </label>
            <input type="text" name="tiempoNatacion" value="<?php if (filter_has_var(INPUT_POST, "tiempoNatacion")) echo $tiempoNatSinFiltrar; ?>"><br><br>
            <label>Ciclismo: </label>
            <input type="text" name="tiempoCiclismo" value="<?php if (filter_has_var(INPUT_POST, "tiempoCiclismo")) echo $tiempoCiclSinFiltrar; ?>"><br><br>
            <label>Carrera: </label>
            <input type="text" name="tiempoCarrera" value="<?php if (filter_has_var(INPUT_POST, "tiempoCarrera")) echo $tiempoCarrSinFiltrar; ?>"><br><br>

            <button type="submit" name="enviar">Enviar</button>
        </form><br><br>


    </body>
</html>
