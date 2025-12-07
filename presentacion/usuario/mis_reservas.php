<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario']['id'])) {
    header("Location: login.php?error=Debes iniciar sesión para ver tus reservas");
    exit();
}

include_once __DIR__ . '/../../Logica/Admin/bd.php';
include_once __DIR__ . '/../../Logica/Usuario/misReservas.php';
// obtiene datos de user 
$misReservasLogic = new MisReservasLogic($conexion);
$usuarioId = $_SESSION['usuario']['id'];

// Procesar cancelación de reserva
if (isset($_GET['accion']) && $_GET['accion'] == 'cancelar' && isset($_GET['id'])) {
    $resultado = $misReservasLogic->cancelarReserva($_GET['id'], $usuarioId);
    header("Location: mis_reservas.php?" . ($resultado['success'] ? 'success' : 'error') . "=" . urlencode($resultado['message']));
    exit();
}

// Obtener reservas
$reservasActivas = $misReservasLogic->obtenerReservasActivas($usuarioId);
$historialReservas = $misReservasLogic->obtenerHistorialReservas($usuarioId);

include_once 'cabecera.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas - AJUPEN</title>
    <link rel="stylesheet" href="../../css/Usuario/mis_reservas.css">
</head>
<body>
    <div class="contenedor-mis-reservas">
        <h1>📋 Mis Reservas</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <!-- Reservas Activas -->
        <section class="seccion-reservas">
            <h2>🟢 Reservas Activas</h2>
            
            <?php if (empty($reservasActivas)): ?>
                <div class="sin-reservas">
                    <p>No tienes reservas activas en este momento.</p>
                    <a href="productos.php" class="btn-explorar">📚 Explorar Biblioteca</a>
                </div>
            <?php else: ?>
                <div class="grid-reservas">
                    <?php foreach ($reservasActivas as $reserva): ?>
                        <div class="tarjeta-reserva activa">
                            <div class="info-libro">
                                <img src="../../imagenes/lib<?php echo $reserva['imagen']; ?>" alt="<?php echo $reserva['nombre']; ?>" class="imagen-libro">
                                <div class="detalles-libro">
                                    <h3><?php echo $reserva['nombre']; ?></h3>
                                    <p class="autor">por <?php echo $reserva['autor']; ?></p>
                                    <p class="categoria"><?php echo $reserva['categoria']; ?></p>
                                </div>
                            </div>
                            
                            <div class="info-reserva">
                                <div class="fechas">
                                    <p><strong>Reservado:</strong> <?php echo date('d/m/Y H:i', strtotime($reserva['fecha_reserva'])); ?></p>
                                    <p class="fecha-limite <?php echo (strtotime($reserva['fecha_limite']) - time() < 3 * 24 * 60 * 60) ? 'urgente' : ''; ?>">
                                        <strong>📅 Recoger antes:</strong> <?php echo date('d/m/Y', strtotime($reserva['fecha_limite'])); ?>
                                    </p>
                                    <?php 
                                        $diasRestantes = floor((strtotime($reserva['fecha_limite']) - time()) / (60 * 60 * 24));
                                        if ($diasRestantes >= 0) {
                                            echo "<p class='dias-restantes'><strong>⏳ Días restantes:</strong> $diasRestantes</p>";
                                        }
                                    ?>
                                </div>
                                
                                <div class="acciones-reserva">
                                    <a href="mas.php?id=<?php echo $reserva['libro_id']; ?>" class="btn-ver">👁️ Ver Libro</a>
                                    <a href="mis_reservas.php?accion=cancelar&id=<?php echo $reserva['id']; ?>" 
                                       class="btn-cancelar" 
                                       onclick="return confirm('¿Estás seguro de cancelar esta reserva?')">
                                       ❌ Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <section class="seccion-reservas">
            <h2>📜 Historial de Reservas</h2>
            
            <?php if (empty($historialReservas)): ?>
                <div class="sin-reservas">
                    <p>No tienes reservas en tu historial.</p>
                </div>
            <?php else: ?>
                <div class="grid-reservas">
                    <?php foreach ($historialReservas as $reserva): ?>
                        <div class="tarjeta-reserva historial <?php echo $reserva['estado']; ?>">
                            <div class="info-libro">
                                <img src="../../imagenes/lib<?php echo $reserva['imagen']; ?>" alt="<?php echo $reserva['nombre']; ?>" class="imagen-libro">
                                <div class="detalles-libro">
                                    <h3><?php echo $reserva['nombre']; ?></h3>
                                    <p class="autor">por <?php echo $reserva['autor']; ?></p>
                                    <p class="categoria"><?php echo $reserva['categoria']; ?></p>
                                </div>
                            </div>
                            
                            <div class="info-reserva">
                                <div class="fechas">
                                    <p><strong>Reservado:</strong> <?php echo date('d/m/Y H:i', strtotime($reserva['fecha_reserva'])); ?></p>
                                    <p><strong>Límite:</strong> <?php echo date('d/m/Y', strtotime($reserva['fecha_limite'])); ?></p>
                                    <p class="estado <?php echo $reserva['estado']; ?>">
                                        <strong>Estado:</strong> 
                                        <?php 
                                            $estados = [
                                                'pendiente' => '⏳ Expirada',
                                                'completada' => '✅ Completada',
                                                'cancelada' => '❌ Cancelada'
                                            ];
                                            echo $estados[$reserva['estado']] ?? $reserva['estado'];
                                        ?>
                                    </p>
                                </div>
                                
                                <div class="acciones-reserva">
                                    <a href="mas.php?id=<?php echo $reserva['libro_id']; ?>" class="btn-ver">👁️ Ver Libro</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        
        <div class="acciones-pagina">
            <a href="productos.php" class="btn-volver">📚 Seguir Explorando</a>
            <a href="ver_carrito.php" class="btn-carrito">🛒 Ver Carrito</a>
        </div>
    </div>

    <?php include_once 'pie.php'; ?>
</body>
</html>