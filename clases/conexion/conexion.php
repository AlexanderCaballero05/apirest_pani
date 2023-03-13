<?php
class Conexionn {

    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    /* -------------------------------------------------------------------------------------------------------------------------
    ------------------------------------------Inicio de codigo de la conexion----------------------------------------------------
    ---------------------------------------------------------------------------------------------------------------------------- */
    function __construct(){/* es la primera funcion que se ejecuta y no hace falta mandarla a llamar, ya que al instanciar la clase conexion se ejecuta automaticamnete*/
        $listadatos = $this->datosConexion();//mandar a llamar la funcion datosConexion y guardarlos en la variable $listadatos

        foreach ($listadatos as $key => $value) { //aqui recorro el array y capturo los valores uno por uno por eso uso el $value
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }

        $this->conexion = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);// la clase de msqli recibe como parametros, las variables del base de datos
        if($this->conexion->connect_errno){
            echo "algo va mal con la conexion";
            die();
        }

    }
    //Esta funcion solo se puede utilizar dentro de esta clase
    private function datosConexion(){//Esta funcion es para capturar los detos del archivo config y convertilos a un array
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion . "/" . "config");/*Abre y guarda todo el contenido del archivo config y devolverlo 
                                                                    en este caso config esta sin extension*/
        return json_decode($jsondata, true);// con el json_decode se convierte en un array asosiativo debe de llevar true como parametro
    }

    /*---------------------------------------------------- Fin de codigo de la conexion -----------------------------------------------*/


    /*FUNCION PARA 
    Convertir los registros que nos develve la base de datos a UTP8, PARA EVITATR PROBLEMAS DE LEGIBILIDAD COMO UNA TILDE*/
    private function convertirUTF8($array){
        array_walk_recursive($array,function(&$item,$key){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

//Esta funcion se va ejecutar fuera de esta clase porque es publica, pero se tiene que instanciar la clase
    public function obtenerDatos($sqlstring){//$sqlstring es el parametro que funciona como el SELECT * FROM
        $results = $this->conexion->query($sqlstring);
        $resultArray = array();
        foreach ($results as $key) {//aqui recorro el array y capturo los valores y no uso el $value porque quiero que toda la linea sea agregada
            $resultArray[] = $key;//funciona igual que el array_push
        }
        return $this->convertirUTF8($resultArray);

    }

    public function nonQuery($sqlstr){
        $results = $this->conexion->query($sqlstr);
        return $this->conexion->affected_rows;
    }

    //INSERT 
    public function nonQueryId($sqlstr){
        $results = $this->conexion->query($sqlstr);
         $filas = $this->conexion->affected_rows;
         if($filas >= 1){
            return $this->conexion->insert_id;
         }else{
             return 0;
         }
    }
     
    //encriptar

    protected function encriptar($string){//Solo la podemos usar si heredamos esta clase a la clase en donde se quiera utilizar y utilizamos parent::encriptar
        return md5($string);
    }





}



?>