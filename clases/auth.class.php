<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';


class auth extends Conexionn{//con el extends heredamos todos los metodos de la clase conexionn a excepcion de los metodos privados

    public function login($json){//Metodo login para la autenticacion de un usuario a la API
      
        $_respuestas  = new respuestas;
        $datos = json_decode($json,true);// desde el archivo auth.php enviamos el parametro JSON $postBody para ser evaluado en esta funcion
        if(!isset($datos['usuario']) || !isset($datos["password"])){//con el signo ! lo estamos negando
            //error con los campos
            return $_respuestas ->error_400();/*datos incorrectos o formato incorrecto, esto quiere decir que no se enviaron bien los paramtros
                                                  de usuario y password  en el JSON desde postaman */
        }else{
            //if todo esta bien
            $usuario = $datos['usuario'];//Esto es el usuario y contrasena que nos envian desde la parte que consume la API 
            $password = $datos['password'];
            //---------------------------------hasta aqui primera parte

            $password = parent::encriptar($password);//Se encripta la contrasena
            $datos = $this->obtenerDatosUsuario($usuario);//con la funcion Se evalua el usuario 
            if($datos){//Si existe el usuario continue
                       echo "todo esta bien";       
                    if($password == $datos[0]['Password']){ //verificar si la contraseña es igual
                            if($datos[0]['estados_id'] == "1"){//verificar si esta activo
                            
                                $verificar  = $this->insertarToken($datos[0]['Id']);/*Hago el insert del token desde la funcion
                                                                                    y obtengo el ID del array $datos para enviarlo como parametro a la funcion*/
                                if($verificar){// si se guardo
                                        
                                        $result = $_respuestas ->response;/*Obtenemos los datos del atributo $response de la clase respuestas para modificarlo el result
                                                                         Luego retorno el token en el array*/
                                        $result["result"] = array(
                                            "token" => $verificar
                                        );
                                        return $result;/*****************aqui se realiza el guardado del toke*******************************/
                                }else{
                                        //error al guardar
                                        return $_respuestas ->error_500("Error interno, no hemos podido guardar");
                                }
                            }else{
                                //el usuario esta inactivo
                                return $_respuestas ->error_200("El usuario esta inactivo");
                            }
                    }else{
                        //la contraseña no es igual
                        return $_respuestas ->error_200("El usuario o contraseña incorrectas");
                    }
            }else{
                //no existe el usuario
                return $_respuestas ->error_200("El usuario $usuario o contraseña  incorrectas");
            }
        }
    }


    //Metodo utilizado solo en esta clase
    private function obtenerDatosUsuario($correo){
        $query = "SELECT Id,Password,estados_id FROM pani_usuarios WHERE Usuario = '$correo'";
        $datos = parent::obtenerDatos($query);//Aqui con el parent:: obtenemos o heredamos el metodo obtenerDatos, ya que hicimos el extendes de la clase Conexionn
        if(isset($datos[0]["Id"])){//Si en la fila 0 del array nos devuelve un campo llamado UsuarioId
            return $datos;
        }else{
            return 0;
        }
    }

    //Metodo utilizado solo en esta clase
    private function insertarToken($usuarioid){
        $val = true;//agregamos el true para agregarlo a la funcion del token
        $token = bin2hex(openssl_random_pseudo_bytes(16,$val)); /*bin2hex nos devuelve los numeros del 1 al 9 y de la a hasta f
                                                                  penssl_random_pseudo_bytes genera una cadena de bytes pseudoaleatoria*/
        $date = date("Y-m-d H:i");
        $estado = "Activo";
        $query = "INSERT INTO usuarios_token (UsuarioId,Token,Estado,Fecha)VALUES('$usuarioid','$token','$estado','$date')";//el $usuarioid lo enviamos por parametro
        $verifica = parent::nonQuery($query);
        if($verifica){
            return $token;//Si se guardo se envia el token al usuario
        }else{
            return 0;
        }
    }


}




?>