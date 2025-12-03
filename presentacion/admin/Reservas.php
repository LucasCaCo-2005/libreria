<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario']['id'])) {
    header("Location: ../login.php?error=Debes iniciar sesión para acceder al panel de administración");
    exit();
}

// Verificar que el usuario sea administrador (estado = 'admin')
if ($_SESSION['usuario']['estado'] != 'admin') {
    header("Location: ../Usuario/dashboard.php?error=No tienes permisos de administrador");
    exit();
}

include_once __DIR__ . '/../../Logica/Admin/authHelper.php';
AuthHelper::requerirAdministrador();


include_once __DIR__ . '/../../Logica/Admin/bd.php';
include_once __DIR__ . '/../../Logica/Admin/reservas.php';

$reservasAdmin = new ReservasAdminLogic($conexion);

// Procesar acciones
if (isset($_GET['accion']) && isset($_GET['id'])) {
    $accion = $_GET['accion'];
    $reservaId = $_GET['id'];
    
    switch ($accion) {
        case 'preparar':
            $resultado = $reservasAdmin->marcarComoPreparado($reservaId);
            break;
        case 'entregar':
            $resultado = $reservasAdmin->marcarComoEntregado($reservaId);
            break;
    }
    
    if (isset($resultado)) {
        header("Location: reservas.php?" . ($resultado['success'] ? 'success' : 'error') . "=" . urlencode($resultado['message']));
        exit();
    }
}

// Obtener datos
$reservasPendientes = $reservasAdmin->obtenerReservasPendientes();
$reservasHoy = $reservasAdmin->obtenerReservasHoy();
$estadisticas = $reservasAdmin->obtenerEstadisticas();

include_once 'cabecera.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de Reservas</title>
    <link rel="stylesheet" href="../../css/admin/reservas.css">
</head>
<body>
    <div class="contenedor-admin">
        <h1>📚 Administración de Reservas</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <!-- Estadísticas -->
        <div class="estadisticas">
            <div class="tarjeta-estadistica">
                <h3>📦 Pendientes</h3>
                <p class="numero"><?php echo $estadisticas['pendientes']; ?></p>
                <p class="descripcion">Reservas por preparar</p>
            </div>
            <div class="tarjeta-estadistica urgente">
                <h3>⚠️ Para Hoy</h3>
                <p class="numero"><?php echo $estadisticas['hoy']; ?></p>
                <p class="descripcion">Vencen hoy</p>
            </div>
            <div class="tarjeta-estadistica preparada">
                <h3>✅ Preparadas</h3>
                <p class="numero"><?php echo $estadisticas['preparadas']; ?></p>
                <p class="descripcion">Listas para entregar</p>
            </div>
        </div>

        <!-- Reservas para Hoy -->
        <section class="seccion-reservas">
            <h2>⚠️ Reservas que Vencen Hoy</h2>
            
            <?php if (empty($reservasHoy)): ?>
                <div class="sin-reservas">
                    <p>No hay reservas que venzan hoy. ¡Buen trabajo! 🎉</p>
                </div>
            <?php else: ?>
                <div class="lista-reservas">
                    <?php foreach ($reservasHoy as $reserva): ?>
                        <div class="tarjeta-reserva urgente">
                            <div class="info-libro">
                                <img src="../../imagenes/lib<?php echo $reserva['libro_imagen']; ?>" alt="<?php echo $reserva['libro_nombre']; ?>" class="imagen-libro">
                                <div class="detalles-libro">
                                    <h3><?php echo $reserva['libro_nombre']; ?></h3>
                                    <p class="autor">por <?php echo $reserva['libro_autor']; ?></p>
                                </div>
                            </div>
                            
                            <div class="info-usuario">
                                <h4>👤 Datos del Usuario</h4>
                                <p><strong>Nombre:</strong> <?php echo $reserva['usuario_nombre'] . ' ' . $reserva['usuario_apellidos']; ?></p>
                                <p><strong>Correo:</strong> <?php echo $reserva['usuario_correo']; ?></p>
                                <p><strong>Teléfono:</strong> <?php echo $reserva['usuario_telefono'] ?? 'No proporcionado'; ?></p>
                            </div>
                            
                            <div class="info-reserva">
                                <p><strong>📅 Fecha Límite:</strong> <span class="urgente">HOY</span></p>
                                <p><strong>⏰ Reservado:</strong> <?php echo date('d/m/Y H:i', strtotime($reserva['fecha_reserva'])); ?></p>
                            </div>
                            
                            <div class="acciones-admin">
                                <a href="reservas_admin.php?accion=preparar&id=<?php echo $reserva['id']; ?>" class="btn-preparar">
                                    📦 Marcar como Preparado
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- Todas las Reservas Pendientes -->
        <section class="seccion-reservas">
            <h2>📋 Todas las Reservas Pendientes</h2>
            
            <?php if (empty($reservasPendientes)): ?>
                <div class="sin-reservas">
                    <p>No hay reservas pendientes en este momento.</p>
                </div>
            <?php else: ?>
                <div class="lista-reservas">
                    <?php foreach ($reservasPendientes as $reserva): 
                        $diasRestantes = floor((strtotime($reserva['fecha_limite']) - time()) / (60 * 60 * 24));
                        $claseUrgencia = $diasRestantes <= 1 ? 'muy-urgente' : ($diasRestantes <= 3 ? 'urgente' : 'normal');
                    ?>
                        <div class="tarjeta-reserva <?php echo $claseUrgencia; ?>">
                            <div class="info-libro">
                                <img src="../../imagenes/lib<?php echo $reserva['libro_imagen']; ?>" alt="<?php echo $reserva['libro_nombre']; ?>" class="imagen-libro">
                                <div class="detalles-libro">
                                    <h3><?php echo $reserva['libro_nombre']; ?></h3>
                                    <p class="autor">por <?php echo $reserva['libro_autor']; ?></p>
                                    <p class="categoria"><?php echo $reserva['libro_categoria']; ?></p>
                                </div>
                            </div>
                            
                            <div class="info-usuario">
                                <h4>👤 Usuario</h4>
                                <p><strong>Nombre:</strong> <?php echo $reserva['usuario_nombre']; ?></p>
                                <p><strong>Contacto:</strong> <?php echo $reserva['usuario_correo']; ?></p>
                                <?php if ($reserva['usuario_telefono']): ?>
                                    <p><strong>Teléfono:</strong> <?php echo $reserva['usuario_telefono']; ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="info-reserva">
                                <p><strong>📅 Fecha Límite:</strong> 
                                    <span class="<?php echo $claseUrgencia; ?>">
                                        <?php echo date('d/m/Y', strtotime($reserva['fecha_limite'])); ?>
                                    </span>
                                </p>
                                <p><strong>⏰ Días restantes:</strong> <?php echo $diasRestantes; ?> días</p>
                                <p><strong>📝 Reservado:</strong> <?php echo date('d/m/Y H:i', strtotime($reserva['fecha_reserva'])); ?></p>
                            </div>
                            
                            <div class="acciones-admin">
                                <a href="reservas.php?accion=preparar&id=<?php echo $reserva['id']; ?>" class="btn-preparar">
                                    📦 Preparar
                                </a>
                                <a href="reservas.php?accion=entregar&id=<?php echo $reserva['id']; ?>" class="btn-entregar" 
                                   onclick="return confirm('¿Marcar esta reserva como entregada?')">
                                    ✅ Entregado
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <?php include_once 'pie.php'; ?>
</body>
</html>