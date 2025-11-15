<?php include_once 'cabecera.php'; ?>

<?php



include_once("admin/config/bd.php");
========
include_once __DIR__ . "/../../Logica/Admin/bd.php";


if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    $libro = $sentencia->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Libro</title>
    <style>
        .detalle {
            width: 600px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 15px;
        }
        .detalle img {
            max-width: 200px;
        }
    </style>
</head>
<body>

<div class="detalle">
    <?php if($libro){ ?>
        <h2><?php echo $libro['nombre']; ?></h2>
        <h4>Autor: <?php echo $libro['autor']; ?></h4>
        <img src="./img/<?php echo $libro['imagen']; ?>" alt="">
    <?php } else { ?>
        <p>No se encontró el libro.</p>
    <?php } ?>
</div>
<a class="btn btn-sm btn-primary" href="productos.php">Volver</a>
</body>
</html>
 <?php include_once 'pie.php'; 