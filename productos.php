
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
  .carta-chica {
    width: 200px; 
    margin: 10px;
    display: inline-block;
  }
  .carta-chica img {
    height: 150px;
    object-fit: cover;
  }
</style>

</head>
<body>
    






<?php include_once 'template/cabecera.php'; ?>



<?php include_once 'template/cabecera.php'; ?>

<?php   
include_once ("admin/config/bd.php");

$sentencia = $conexion->prepare("SELECT * FROM libros");
$sentencia->execute();
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);






?>
 <?php   
 foreach($listaLibros as $libro){ 
    
 
 
 
 ?> 


<div class="d-flex flex-wrap justify-content-center">

    <div class="card carta-chica">
        <img class="card-img-top" src="./img/<?php echo $libro['imagen']; ?>" alt="">
        <div class="card-body">
            <h6 class="card-title"><?php echo $libro['nombre']; ?></h6>

            <a class="btn btn-sm btn-primary" href="" role="button">Ver más</a>
        </div>
    </div>

   <?php } ?>

</div>

<?php include_once 'template/pie.php'; ?>







</body>
</html>