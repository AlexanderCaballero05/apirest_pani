<?php
require_once "clases/respuestas.class.php";
require_once "clases/ws_getpremio_menor.class.php";

$_get_premioMenor = new ws_getpremio_menor;
$_respuestas = new respuestas;

if($_SERVER['REQUEST_METHOD'] == "GET"){
$postBody = file_get_contents("php://input");

    $sorteo = $_GET['sorteo'];
    $numero = $_GET['numero'];
    $serie = $_GET['serie'];

    $jsonBody = $_get_premioMenor->ObtenerPremioMenor($sorteo,$numero,$serie);

    header("content-type: application/json");
    echo json_encode($jsonBody);
    http_response_code(200);

}elseif($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");

 $jsonBody = $_get_premioMenor->ObtenerPremioPost($postBody);

 header("content-type: application/json");
    echo json_encode($jsonBody);
    http_response_code(200);


}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($jsonBody);
}

?>