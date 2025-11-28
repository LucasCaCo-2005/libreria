<?php
// Presentacion/Usuario/ver_carrito.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Inicializar carrito si no existe
if (!isset($_SESSION['carrito_reservas'])) {
    $_SESSION['carrito_reservas'] = [];
}

include_once 'cabecera.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Reservas</title>
    <link rel="stylesheet" href="../../css/Usuario/carrito.css">
</head>
<body>
    <div class="contenedor-carrito">
        <h1>🛒 Carrito de Reservas</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        
      <div class="info-carrito">
    <p>Límite: <strong><?php echo count($_SESSION['carrito_reservas']); ?>/3</strong> libros</p>
    <?php if (!empty($_SESSION['carrito_reservas'])): ?>
        <a href="controlador.php?accion=vaciar" class="btn-vaciar" onclick="return confirm('¿Estás seguro de vaciar el carrito?')">🗑️ Vaciar Carrito</a>
    <?php endif; ?>
</div>

        
        <?php if (empty($_SESSION['carrito_reservas'])): ?>
            <div class="carrito-vacio">
                <h2>Tu carrito de reservas está vacío</h2>
                <p>Agrega libros desde la biblioteca para reservarlos.</p>
                <a href="productos.php" class="btn-volver">📚 Explorar Biblioteca</a>
            </div>
        <?php else: ?>
            <div class="lista-libros-carrito">
                <?php foreach ($_SESSION['carrito_reservas'] as $libro): ?>
                    <div class="item-carrito">
                        <div class="libro-info">
                            <img src="../../imagenes/lib<?php echo $libro['imagen']; ?>" alt="<?php echo $libro['nombre']; ?>" class="imagen-libro-carrito">
                            <div class="detalles-libro">
                                <h3><?php echo $libro['nombre']; ?></h3>
                                <p class="autor">por <?php echo $libro['autor']; ?></p>
                                <p class="fecha-agregado">Agregado: <?php echo $libro['fecha_agregado']; ?></p>
                            </div>
                        </div>
                      <div class="acciones-libro">
    <a href="mas.php?id=<?php echo $libro['id']; ?>" class="btn-ver">👁️ Ver</a>
    <a href="controlador.php?accion=eliminar&id=<?php echo $libro['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar este libro del carrito?')">❌ Eliminar</a>
</div>

                <?php endforeach; ?>
            </div>
            <!-- DEBUG Temporal -->

            <div class="acciones-carrito">
    <a href="productos.php" class="btn-seguir">➕ Seguir Agregando</a>
    <form action="controlador.php" method="POST" class="form-confirmar">
        <input type="hidden" name="accion" value="confirmar">
        <button type="submit" class="btn-confirmar">✅ Confirmar Reserva</button>
    </form>
</div>
        <?php endif; ?>
    </div>

    <?php include_once 'pie.php'; ?>
</body>
</html>