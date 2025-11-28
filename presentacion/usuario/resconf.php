<?php
// Presentacion/Usuario/resconf.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar que hay una reserva confirmada
if (!isset($_SESSION['reserva_confirmada'])) {
    header("Location: productos.php");
    exit();
}

$reserva = $_SESSION['reserva_confirmada'];
unset($_SESSION['reserva_confirmada']);

include_once 'cabecera.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva Confirmada</title>
    <link rel="stylesheet" href="../../css/Usuario/confirmacion.css">
</head>
<body>
    <div class="contenedor-confirmacion">
        <div class="tarjeta-confirmacion">
            <div class="icono-exito">✅</div>
            <h1>¡Reserva Confirmada!</h1>
            <p class="mensaje-exito">Tu reserva ha sido procesada exitosamente.</p>
            
            <div class="detalles-reserva">
                <p><strong>Fecha de reserva:</strong> <?php echo $reserva['fecha_reserva']; ?></p>
                <p><strong>Fecha límite para recoger:</strong> <?php echo $reserva['fecha_limite']; ?></p>
                <p><strong>Libros reservados:</strong> <?php echo count($reserva['libros']); ?></p>
            </div>
            
            <div class="lista-libros-reservados">
                <h3>Libros reservados:</h3>
                <?php foreach ($reserva['libros'] as $libro): ?>
                    <div class="libro-reservado">
                        <strong><?php echo $libro['nombre']; ?></strong> - <?php echo $libro['autor']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="instrucciones">
                <h3>📋 Instrucciones:</h3>
                <ul>
                    <li>Presenta tu identificación en la biblioteca</li>
                    <li>Tienes hasta el <?php echo $reserva['fecha_limite']; ?> para recoger tus libros</li>
                    <li>Después de esta fecha, la reserva se cancelará automáticamente</li>
                </ul>
            </div>
            
            <div class="acciones-confirmacion">
                <a href="productos.php" class="btn-volver">📚 Seguir Explorando</a>
                <a href="mis_reservas.php" class="btn-ver-reservas">📋 Ver Mis Reservas</a>
            </div>
        </div>
    </div>

    <?php include_once 'pie.php'; ?>
</body>
</html>