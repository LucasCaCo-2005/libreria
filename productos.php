
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
  .carta-chica {
    width: 200px; 
    border: 1px solid #ceababff;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.1);

  }
  .carta-chica img {
    height: 150px;
    object-fit: cover;
  }
  .contenedor-libros {
  display: flex;
  flex-wrap: wrap;   
  justify-content: center; 
  gap: 20px; 
}
</style>

</head>
<body>

<?php include_once 'template/cabecera.php'; ?>

<?php   
include_once ("admin/config/bd.php");

$sentencia = $conexion->prepare("SELECT * FROM libros");
$sentencia->execute();
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>
 <?php   
 foreach($listaLibros as $libro)
 ?> 
<div class="contenedor-libros">
<?php foreach($listaLibros as $libro){ ?> 
    <div class="card carta-chica">
        <img class="card-img-top" src="/images/<?php echo $libro['imagen']; ?>" alt="">
        <div class="card-body">
            <h6 class="card-title"><?php echo $libro['nombre']; ?></h6>
            <h6 class="card-title"><?php echo $libro['autor']; ?></h6>
            <a class="btn btn-sm btn-primary" href="" role="button">Ver más</a>
        </div> 
    </div> 
<?php } ?>
</div> 
<?php include_once 'template/pie.php'; ?>

</body>
</html>