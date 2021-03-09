<!DOCTYPE html>
<html lang="es">
<head>
  <title>API CoverManager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron">
  <div class="container text-center">
    <h1>API CoverManager</h1>      
    <p>A continuación están listados los endpoints requeridos en la API</p>
  </div>
</div>
  
<div class="container-fluid bg-3 text-center">    
  <h3>ENDPOINTS</h3><br>
  <div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
         <h4>Creación de mesa</h4><br>
         <p><strong><?php echo $this->config->item("base_url"); ?>api/createTable</strong></p>
        </div>
        <div class="col-md-6"> 
         <h4>Eliminación de mesa</h4><br>
         <p><strong><?php echo $this->config->item("base_url"); ?>api/deleteTable</strong></p>
        </div>
    </div>
  </div>
  <div class="row" style="margin-top: 50px;">
    <div class="col-md-12">
        <div class="col-md-6">
         <h4>Comprobación de disponibilidad</h4><br>
         <p><strong><?php echo $this->config->item("base_url"); ?>api/checkAvailability</strong></p>
        </div>
        <div class="col-md-6"> 
         <h4>Hacer reserva</h4><br>
         <p><strong><?php echo $this->config->item("base_url"); ?>api/createReservation</strong></p>
        </div>
    </div>
  </div>
  <div class="row" style="margin-top: 50px;">
    <div class="col-md-12">
        <div class="col-md-6">
         <h4>Eliminar reserva</h4><br>
         <p><strong><?php echo $this->config->item("base_url"); ?>api/deleteReservation</strong></p>
        </div>
    </div>
  </div>
</div><br>

</body>
</html>
