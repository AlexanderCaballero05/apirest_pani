<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Pani</title>
    <link rel="stylesheet" href="assets/estilo.css" type="text/css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-icons.css" type="text/css">

      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
 </head>
<body>

<div class="container">
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid bg-info">
    <a class="navbar-brand" href="#">
      <img src="pani1.png" alt="Logo" width="100" height="50" class="d-inline-block align-text-top">
      API pani
    </a>
  </div>
</nav>
    <div class="divbody">
        <h3>Auth - login</h3>
        <code>
           POST  /autentificar
           <br>
           {
               <br>
               "usuario" :"",  -> REQUERIDO
               <br>
               "password": "" -> REQUERIDO
               <br>
            }
        
        </code>

        <code>
         Para enviar la solicitud pasar por el metodo POST <strong>token</strong> como un encabezado codificado de HTTP
        </code>
    </div>      
    <div class="divbody">   
        <h3>Obtener de premios loteria menor</h3>
        <code>
           GET  /ws_getpremio_menor.php?sorteo=sorteo&numero=numero&serie=serie
        </code>

        
      
        
    </div>


</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    
</body>
</html>

