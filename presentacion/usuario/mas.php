<?php
include_once __DIR__ . '/../../Logica/Admin/bd.php';
include_once 'cabecera.php';
$libro = null;
if(isset($_GET['id'])){
    $idLibro = $_GET['id'];

    $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
    $sentencia->bindParam(":id", $idLibro);
    $sentencia->execute();
    $libro = $sentencia->fetch(PDO::FETCH_ASSOC);
}
if(!$libro){
    echo "<h2>Libro no encontrado</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $libro['nombre']; ?> - Detalles</title>
    <link rel="stylesheet" href="../../css/Usuario/mas.css">
    <style>
       
    </style>
</head>
<body>
    <div class="contenedor-detalle">
        <div class="tarjeta-detalle">
            <div class="seccion-imagen">
                <img class="imagen-libro" src="../../imagenes/<?php echo $libro['imagen']; ?>" alt="Portada de <?php echo $libro['nombre']; ?>">
            </div>
            
            <div class="seccion-info">
                <span class="categoria-libro"><?php echo $libro['categoria']; ?></span>
                <h1 class="titulo-libro"><?php echo $libro['nombre']; ?></h1>
                <p class="autor-libro">por <?php echo $libro['autor']; ?></p>
                <p class="fecha-libro">Publicado: <?php echo $libro['fecha']; ?></p>
                
                <div class="info-adicional">
                    <h3>📖 Sinopsis</h3>
                    <p class="descripcion-libro"><?php echo $libro['descripcion']; ?></p>
                </div>
                
                <div class="contenedor-botones">
                    <a href="productos.php" class="btn-volver">← Volver a la Biblioteca</a>
                    <a href="reserva.php?id=<?php echo $libro['id']; ?>" class="btn-reservar">📚 Reservar este Libro</a>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'pie.php'; ?>
</body>
</html>