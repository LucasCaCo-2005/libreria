<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php include_once 'template/cabecera.php';
include_once ("config/bd.php");
include_once ("seccion/Talleres.php");


$sentencia = $conexion->prepare("SELECT * FROM talleres");
$sentencia->execute();
$listaTalleres = $sentencia->fetchAll(PDO::FETCH_ASSOC); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Talleres Disponibles</h2>
            <div class="list-group">
                <?php foreach($listaTalleres as $taller){ ?> 
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="mb-1"><?php echo $taller['nombre']; ?></h5>
                        <small>Fecha: <?php echo $taller['dia']; ?> | Hora: <?php echo $taller['horario']; ?></small>
                        <p class="mb-1"><?php echo $taller['descripcion']; ?></p>
                        <img src="../images/<?php echo $taller['foto']; ?>" alt="<?php echo $taller['nombre']; ?>" style="max-width: 200px; height: auto;">
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>





    
</body>
</html>