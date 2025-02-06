<?php

//funcion 1 inicio
function es_multiplo($num)
{
    if ($num % 5 == 0 && $num % 7 == 0) {
        echo '<h3>R= El número ' . $num . ' SÍ es múltiplo de 5 y 7.</h3>';
    } else {
        echo '<h3>R= El número ' . $num . ' NO es múltiplo de 5 y 7.</h3>';
    }
}
// funcion 1 final



// funcion 2 inicio
function generar_secuencia() {
    $secuencia = [];
    $filas = 0;

    // Generar números hasta obtener una secuencia impar, par, impar
    while (true) {
        $numeros = [rand(100, 999), rand(100, 999), rand(100, 999)];
        $filas++;

        // Verifica si la secuencia es impar, par, impar
        if ($numeros[0] % 2 != 0 && $numeros[1] % 2 == 0 && $numeros[2] % 2 != 0) {
            $secuencia[] = $numeros;
            break;
        }
        $secuencia[] = $numeros;
    }
    return [
        'secuencia' => $secuencia,
        'total_numeros' => count($secuencia) * 3,
        'iteraciones' => $filas
    ];
}
//funcion 2 final


//funcion 3 inicio
function buscar_multiplo($numero_dado) {
    $contador = 1;
    while (true) {
        $numero_aleatorio = rand(1, 100);
        if ($numero_aleatorio % $numero_dado == 0) {
            return "El primer múltiplo de $numero_dado es $numero_aleatorio encontrado en $contador iteraciones.";
        }
        $contador++;
    }
}
//funcion 3 final


//funcion 4 inicio
function crear_arreglo_letras() {
    $arreglo = [];
    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i);
    }
    return $arreglo;
}
//funcion 4 final

?>
