<?php
require_once "clases/respuestas.class.php";
require_once "clases/ws_getPremio_mayor.class.php";

$_respuestas = new respuestas;
$_get_premio_menor = new  ws_getpremio_menor;

//en este archivo obtenemos todos los metodos
 


if($_SERVER['REQUEST_METHOD'] == "GET"){ 

$headers = getallheaders();

if(isset($headers['token'])){
    $send = [
        "token" => $headers['token']
    ];

    $post = json_encode($send);
}
$postBody = file_get_contents("php://input");

   if(isset($_GET['sorteo']) && isset($_GET['numero'])){
        $sorteo = $_GET['sorteo'];
        $numero = $_GET['numero'];
        //$serie = $_GET['serie'];
        $get_premio = $_get_premio_menor->ObtenerPremio($sorteo, $numero);

        header("Content-Type: application/json");
        echo json_encode($get_premio);
        http_response_code(200);
    
   } 







}elseif($_SERVER['REQUEST_METHOD'] == "POST"){


    $headers = getallheaders();
    if(isset($headers["token"]) && isset($headers['sorteo']) && isset($headers['numero']) && isset($headers['serie'])){
            $send = [
                    "token" => $headers["token"],
                    "sorteo" => $headers['sorteo'],
                    "numero" => $headers['numero'],
                    "serie" => $headers['serie']

            ];

            $postBody = json_encode($send);

    }else{ 
         
        $postBody = file_get_contents("php://input");
    }


     //enviamos los datos al manejador
        $datosArray = $_get_premio_menor->post($postBody);
        //delvovemos una respuesta 
        header('Content-Type: application/json');
        if(isset($datosArray["result"]["error_id"])){
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        }
        echo json_encode($datosArray);

        }else{
            header('Content-Type: application/json');
            $datosArray = $_respuestas->error_405();
            echo json_encode($datosArray);
        }


?>