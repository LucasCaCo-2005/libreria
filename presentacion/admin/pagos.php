<?php
// Incluir archivos necesarios
include_once(__DIR__ ."/../../Logica/Admin/users.php");
include_once("cabecera.php");
include_once(__DIR__ ."/../../Logica/Admin/bd.php");
include_once(__DIR__ ."/../../Logica/Admin/pagos.php");

// Verificar que se haya especificado un socio
if (!isset($_GET['socio_id'])) {
    echo "<div class='error'>No se ha especificado un socio.</div>";
    include_once("pie.php");
    exit;
}

$socio_id = intval($_GET['socio_id']);

// Instanciar gestor de pagos
$gestorPagos = new GestorPagos($conexion);

// Obtener información del socio
$socio = $gestorPagos->obtenerInfoSocio($socio_id);

if (!$socio) {
    echo "<div class='error'>Socio no encontrado.</div>";
    include_once("pie.php");
    exit;
}

// Procesar acciones
$mensaje = null;
$tipoMensaje = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    
    switch ($accion) {
        case 'Pagar':
            $tipoPago = $_POST['tipo_pago'] ?? '';
            if ($tipoPago) {
                $resultado = $gestorPagos->registrarPago($socio_id, $tipoPago);
                $mensaje = $resultado['message'];
                $tipoMensaje = $resultado['success'] ? 'success' : 'error';
            }
            break;
            
        case 'QuitarPago':
            $pago_id = $_POST['pago_id'] ?? 0;
            if ($pago_id > 0) {
                $resultado = $gestorPagos->eliminarPago($pago_id);
                $mensaje = $resultado['message'];
                $tipoMensaje = $resultado['success'] ? 'success' : 'error';
            }
            break;
    }
}

// Obtener datos para la vista
$historialPagos = $gestorPagos->obtenerHistorialSocio($socio_id);
$estadisticas = $gestorPagos->obtenerEstadisticasMesActual();
$puedePagar = $gestorPagos->socioPuedePagar($socio_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pagos - <?php echo htmlspecialchars($socio['nombre']); ?></title>
    <link rel="stylesheet" href="../../css/admin/pagos.css">
</head>
<body>
    <div class="pagos-container">
        <div class="header-pagos">
            <h1>💰 Gestión de Pagos</h1>
            <p class="subtitle">Administración de pagos para socios</p>
        </div>

        <?php if ($mensaje): ?>
            <div class="alert alert-<?php echo $tipoMensaje; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <div class="info-socio">
            <div class="info-card">
                <div class="info-header">
                    <h3>👤 Información del Socio</h3>
                    <span class="estado-badge estado-<?php echo $socio['estado']; ?>">
                        <?php echo $socio['estado']; ?>
                    </span>
                </div>
                <div class="info-content">
                    <div class="info-item">
                        <span class="info-label">Nombre:</span>
                        <span class="info-value"><?php echo htmlspecialchars($socio['nombre']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Correo:</span>
                        <span class="info-value"><?php echo htmlspecialchars($socio['correo']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">ID Socio:</span>
                        <span class="info-value">#<?php echo htmlspecialchars($socio['socio']); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="pagos-content">
            <?php if ($puedePagar): ?>
                <div class="seccion-pago">
                    <h2>💳 Registrar Nuevo Pago</h2>
                    <div class="opciones-pago">
                        <form method="post" class="form-pago">
                            <input type="hidden" name="accion" value="Pagar">
                            <input type="hidden" name="tipo_pago" value="pago1">
                            <button type="submit" class="btn-pagar btn-completo">
                                <span class="btn-icon">💰</span>
                                <span class="btn-text">Pagar Cuota Completa</span>
                                <span class="btn-monto">$100.00</span>
                            </button>
                        </form>

                        <form method="post" class="form-pago">
                            <input type="hidden" name="accion" value="Pagar">
                            <input type="hidden" name="tipo_pago" value="pago2">
                            <button type="submit" class="btn-pagar btn-medio">
                                <span class="btn-icon">💵</span>
                                <span class="btn-text">Pagar Media Cuota</span>
                                <span class="btn-monto">$50.00</span>
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    ⚠️ Este socio no puede realizar pagos. Estado actual: <?php echo $socio['estado']; ?>
                </div>
            <?php endif; ?>

            <div class="stats-section">
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $estadisticas['total_socios_pagaron']; ?></div>
                        <div class="stat-label">Socios pagaron este mes</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-content">
                        <div class="stat-value">$<?php echo number_format($estadisticas['total_recaudado'], 2); ?></div>
                        <div class="stat-label">Total recaudado</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo date('F Y'); ?></div>
                        <div class="stat-label">Mes actual</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="seccion-historial">
            <h2>📊 Historial de Pagos Recientes</h2>
            <div class="historial-container">
                <?php if (empty($historialPagos)): ?>
                    <div class="sin-pagos">
                        <div class="sin-pagos-icono">💸</div>
                        <p>No hay pagos registrados aún</p>
                    </div>
                <?php else: ?>
                    <div class="lista-pagos">
                        <?php foreach ($historialPagos as $pago): ?>
                            <div class="pago-item">
                                <div class="pago-icono">
                                    <?php echo $pago['tipo_pago'] == 'pago1' ? '💰' : '💵'; ?>
                                </div>
                                <div class="pago-info">
                                    <div class="pago-mes"><?php echo htmlspecialchars($pago['mes_pagado']); ?></div>
                                    <div class="pago-tipo">
                                        <?php echo $pago['tipo_pago'] == 'pago1' ? 'Cuota Completa' : 'Media Cuota'; ?>
                                    </div>
                                    <div class="pago-fecha"><?php echo $pago['fecha_pago']; ?></div>
                                </div>
                                <div class="pago-monto">$<?php echo number_format($pago['monto'], 2); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="acciones-adicionales">
            <a href="pagosS.php" class="btn-secundario">
                <span class="btn-icon">📋</span>
                Ver Todos los Pagos
            </a>
            <a href="sociosT.php" class="btn-secundario">
                <span class="btn-icon">←</span>
                Volver a Socios
            </a>
        </div>
    </div>

    <?php include_once("pie.php"); ?>
</body>
</html>