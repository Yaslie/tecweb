<?php
class Pagina {
    private $cabecera;
    private $cuerpo;
    private $pie;

    public function __construct($texto1, $texto2){
        $this->cabecera = new Cabecera($texto1);
        $this->cuerpo = new Cuerpo;
        $this->pie = new Pie($texto2);
    }

    public function insertar_cuerpo($texto){
        $this->cuerpo->insertar_parrafo($texto);
    }

    public function graficar(){
        $this->cabecera->graficar();
        $this->cuerpo->graficar();
        $this->pie->graficar();
    }
}

/**
 * Implementar las clases cabecera, cuerpo y pie
 * 1. La clase cabecera tiene las siguientes caracteristicas
 *      -Tiene un constructor que recibe un texto e inicializa 
 *      un atributo de nombre titulo.
 *      -Tiene una funcion graficar, que utiliza un encabezado
 *      de nivel 1, a partir de un texto y un estilo por defecto
 *      (no se le pide al usuario, por lo tanto no es un parameto).
 * 2.La clase cuerpo tiene las siguientes carcateristicas
 *      -No tiene constructr pero tiene un atributo privado que 
 *      corresponde a un arreglo de lineas de texto, el atributo 
 *      se debe llamar lineas.
 *      -Tiene una funcion graficar, que recorre el atributo lineas
 *      para mostrar elementos <p> que contienen el texto de dentro 
 *      del arreglo.
 * 3. La clase pie tiene las siguientes caracteristicas
 *      -Tiene un constructor que recibe un texto e inicializa un 
 *      atributo de nombre mensaje.
 *      -Tiene una funcion graficar, que utiliza un encabezado
 *      de nivel 4, a partir de un texto y un estilo por defecto
 *      (no se le pide al usuario, por lo tanto no es un parameto).
 */
?>