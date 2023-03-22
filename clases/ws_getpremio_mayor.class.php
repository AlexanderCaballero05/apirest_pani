<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


/*Una clase puede tener sus propias constantes, variables (llamadas "propiedades"),
 y funciones (llamados "métodos").*/
class ws_getpremio_menor extends Conexionn {
    private $usuario = "";//Declaracion de la propiedad Usuario
    private $token = "";//Declaracion de la propiedad Token
    private $sorteo = "";
    private $numero = "";
    private $serie = "";
    //Declaracion del metodo 

    //--------------Obtener el valor del premio menor por el metodo get--------------------------------//
    public function ObtenerPremio($sorteo, $numero){
        $query = "SELECT estado , detalle_venta, total FROM archivo_pagos_mayor WHERE sorteo = '$sorteo' AND numero = '$numero'; ";
        $datos = parent::obtenerDatos($query);

        if($datos > 1){
            return $datos;
        }elseif($datos < 1){
            return $datos = "No tiene premio";
        }
    }


    public function get($json){
        $_respuesta = new respuestas;
       
        $datos = json_decode($json, true);
        
        if(isset($datos['token'])){
            $this->token = $datos["token"];
        $arrayToken = $this->buscarToken();
            if($arrayToken){
                if(!isset($datos['sorteo']) || !isset($datos['numero']) || !isset($datos['serie'])){
                    return $_respuesta->error_400();
                }else{
                    $sorteo = $datos['sorteo'];
                    $numero = $datos['numero'];
                    $serie = $datos['serie'];
                    $respp= $this->ObtenerPremio($sorteo, $numero, $serie);
                    return $respp;

                }
                   

            }else{
                return $_respuesta->error_401("El token que envio es invalido o ha caducado ");
            }

        }else{
            return $_respuesta->error_401();

        }
    }
  //--------------Fin Obtener el valor del premio menor por el metodo get--------------------------------//


  //--------------Inicio de Obtener el valor del premio menor por el metodo POST--------------------------------//

    public function premioMenor(){
        $query = "SELECT estado , detalle_venta, totalpayment FROM archivo_pagos_menor WHERE sorteo= '". $this->sorteo ."' AND numero= '". $this->numero ."' AND serie= '". $this->serie ."';";
        $datos = parent::obtenerDatos($query);
        return($datos);
    }




    public function post($json){
            $_respuesta = new respuestas;
            $datos = json_decode($json, true);//convierto los datos de JSON ah array asociativo
            if(!isset($datos['token'])){// si no esta la variable token con isset
                    return $_respuesta->error_401();//no autorizado
            }else{
                    $this->token = $datos['token'];//igualamos el atributo Token = con el array $datos
                    $arrayToken = $this->buscarToken();//con el $this invocamos la funcion buscarToken y obtenemos todos los datos desde la DB
                    if($arrayToken){
                            $this->sorteo = $datos['sorteo'];
                            $this->numero = $datos['numero'];
                            $this->serie = $datos['serie'];
                            $resp = $this->premioMenor();
                            return $resp;
                    }else{
                        return $_respuesta->error_401("El token que envio es invalido o ha caducado ");
                    }
            }

    }

  //--------------fin de Obtener el valor del premio menor por el metodo POST--------------------------------//


    //con esta funcion vamos a retornar el Token que tiene el usuario
    private function buscarToken(){
        $query = "SELECT TokenId, UsuarioId, Estado FROM usuarios_token WHERE Token = '". $this->token ."' AND Estado = 'Activo' ";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }

//cada vez que haga una consulta el usuario o la aplicacion que esta consumiendo la API, se va actualizar el token para ver que sigue activo el usuario
    private function actualizarToken($tokenid){
        $date = date("Y-m-d H:i");
        $query = "UPDATE usuarios_token SET fecha = '$date' WHERE TokenId = '$tokenid'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }
}

?>