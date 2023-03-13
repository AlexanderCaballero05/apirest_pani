<?php 
require_once 'clases/auth.class.php';
require_once 'clases/respuestas.class.php';//Primero se requiere el archivo de la clase

$_auth = new auth;// Instanciar la clase
$_respuestas = new respuestas;// Instanciar la clase con la abreviatura $_nombre de la clase



if($_SERVER['REQUEST_METHOD'] == "POST"){//Para mayor seguridad se envia el metodo POST para la atenticacion del usuario

    //recibir datos desde POSTMAN por ejemplo
    $postBody = file_get_contents("php://input");

    //enviamos los datos al manejador
    $datosArray = $_auth->login($postBody);/*en la variable  $_auth guardamos la instancia de la clase auth del archivo auth.class.php
                                             y hacemos usos de la function login y recibe como parametro un JSON que es la variable $postBody*/

    //delvolvemos una respuesta explicacion del Metodo GET
    header('Content-Type: application/json');

    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }

    echo json_encode($datosArray);/* Se imprime Estamos devolviendo un array, 
                                   pero al utilizar json_encode lo convertimos a un string por ello, Utilizamos echo */


}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();//Si no se envia correctamente el metodo
    echo json_encode($datosArray);

}


?>