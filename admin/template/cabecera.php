<?php 
session_start();
if(!isset($_SESSION['usuario'])){
    header("Location: ../index.php");
    exit();
}else{
    if($_SESSION['usuario']=="ok"){
        $nombreUsuario=$_SESSION['nombre'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
</head>
<body>
  
<?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb"      // info del host donde estoy ?>

<nav class="navbar navbar-expand navbar-light bg-light">
    <div class="nav navbar-nav">
        <a class="nav-item nav-link active" href="#">Administrador <span class="sr-only"></span></a>
        <a class="nav-item nav-link" href="<?php echo $url;?>/admin/inicio.php">Inicio</a>
                <a class="nav-item nav-link" href="<?php echo $url;?>/admin/seccion/productos.php">Libros</a>
               <a class="nav-item nav-link" href="<?php echo $url;?>/admin/prest.php">Prestamos</a>
                  <a class="nav-item nav-link" href="<?php echo $url;?>/admin/Vistalibros.php">Vistalibros</a>
                   <a class="nav-item nav-link" href="<?php echo $url;?>">Ver sitio web</a>
                        <a class="nav-item nav-link" href="<?php echo $url;?>/admin/seccion/socios.php">Socios</a> 
                         <a class="nav-item nav-link" href="<?php echo $url;?>/admin/seccion/logsos.php">Pagos</a> 
                      <a class="nav-item nav-link" href="<?php echo $url;?>/admin/seccion/cerrar.php">Cerrar</a> 
    </div>
</nav>
<div class="container">
    <br><br>
    <div class="row">
