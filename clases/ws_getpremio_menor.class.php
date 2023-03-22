<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class ws_getpremio_menor{

    private $sorteo = "";
    private $numero = "";
    private $serie = "";
    

    public function ObtenerPremioMenor($sorteo, $numero, $serie){

        $_ObtenerDatos = new Conexionn;
        $queryObtener_total ="SELECT netopayment, detalle_venta FROM archivo_pagos_menor 
                              WHERE sorteo = $sorteo AND numero= $numero AND serie=$serie;";
        $datos = $_ObtenerDatos->obtenerDatos($queryObtener_total);
        return $datos;

    }


    public function ObtenerPremioPost($json){
        $datos = json_decode($json, true);
        $this->sorteo = $datos['sorteo'];
        $this->numero = $datos['numero'];
        $this->serie = $datos['serie'];
        $resp = $this->post();
        return $resp;
       


    }

    public function post(){
        $_ObtenerDatosPost = new Conexionn;
        $query = "SELECT estado , detalle_venta, totalpayment FROM archivo_pagos_menor WHERE sorteo= '". $this->sorteo ."' AND numero= '". $this->numero ."' AND serie= '". $this->serie ."';";
        $datos = $_ObtenerDatosPost->obtenerDatos($query);
        
        return $datos;
    }



}

?>
