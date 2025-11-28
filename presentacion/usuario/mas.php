<?php
// Presentacion/Usuario/mas.php

include_once __DIR__ . '/../../Logica/Admin/bd.php';
include_once 'cabecera.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito_reservas'])) {
    $_SESSION['carrito_reservas'] = [];
}

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

// Verificar si ya está en el carrito
$enCarrito = false;
foreach ($_SESSION['carrito_reservas'] as $item) {
    if ($item['id'] == $libro['id']) {
        $enCarrito = true;
        break;
    }
}

// Verificar límite de reservas
$limiteAlcanzado = count($_SESSION['carrito_reservas']) >= 3;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $libro['nombre']; ?> - Detalles</title>
    <link rel="stylesheet" href="../../css/Usuario/mas.css">
</head>
<body>
    <div class="contenedor-detalle">
        <div class="tarjeta-detalle">
            <div class="seccion-imagen">
                <img class="imagen-libro" src="../../imagenes/lib<?php echo $libro['imagen']; ?>" alt="Portada de <?php echo $libro['nombre']; ?>">
            </div>
            
            <div class="seccion-info">
                <span class="categoria-libro"><?php echo $libro['categoria']; ?></span>
                <h1 class="titulo-libro"><?php echo $libro['nombre']; ?></h1>
                <p class="autor-libro">por <?php echo $libro['autor']; ?></p>
                <p class="fecha-libro">Publicado: <?php echo $libro['fecha']; ?></p>
                <p class="stock-libro">Disponibles: <?php echo $libro['stock']; ?></p>
                
                <div class="info-adicional">
                    <h3>📖 Sinopsis</h3>
                    <p class="descripcion-libro"><?php echo $libro['descripcion']; ?></p>
                </div>
                
            <div class="contenedor-botones">
    <a href="productos.php" class="btn-volver">← Volver a la Biblioteca</a>
    
    <?php if ($enCarrito): ?>
        <button class="btn-en-carrito" disabled>✅ Ya en carrito</button>
    <?php elseif ($limiteAlcanzado): ?>
        <button class="btn-limite" disabled>❌ Límite de 3 libros alcanzado</button>
    <?php elseif ($libro['stock'] <= 0): ?>
        <button class="btn-sin-stock" disabled>❌ No disponible</button>
    <?php else: ?>
        <a href="controlador.php?accion=agregar&id=<?php echo $libro['id']; ?>" class="btn-reservar">📚 Reservar este Libro</a>
    <?php endif; ?>
    
    <a href="ver_carrito.php" class="btn-ver-carrito">🛒 Ver Carrito (<?php echo count($_SESSION['carrito_reservas']); ?>)</a>
</div>
            </div>
        </div>
    </div>

    <?php include_once 'pie.php'; ?>
</body>
</html>