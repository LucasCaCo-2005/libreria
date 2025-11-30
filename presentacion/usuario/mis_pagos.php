<?php
// mis_pagos.php - VERSIÓN CORREGIDA
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ ."/../../Logica/Admin/bd.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener información ACTUALIZADA del socio desde la base de datos
$socio_id = $_SESSION['usuario']['id'];

// Consultar el estado ACTUAL del socio desde la base de datos
$consultaSocio = $conexion->prepare("SELECT estado FROM socios WHERE id = :id");
$consultaSocio->bindParam(':id', $socio_id, PDO::PARAM_INT);
$consultaSocio->execute();
$socioActual = $consultaSocio->fetch(PDO::FETCH_ASSOC);

if (!$socioActual) {
    $mensaje_error = "No se encontró tu información de socio.";
} else {
    $estado_socio = $socioActual['estado'];
    
    // Actualizar el estado en sesión por si cambió
    $_SESSION['usuario']['estado'] = $estado_socio;

    // Verificar si el socio está activo
    if ($estado_socio !== 'activo') {
        $mensaje_error = "No puedes acceder a los pagos porque tu cuenta no está activa. Estado actual: " . $estado_socio;
    } else {
        // Consulta para obtener los pagos del socio
        $consultaPagos = $conexion->prepare("
            SELECT p.id, p.tipo_pago, p.monto, p.fecha_pago, p.mes_pagado
            FROM pagos p 
            WHERE p.socio_id = :socio_id 
            ORDER BY p.fecha_pago DESC
        ");
        $consultaPagos->bindParam(':socio_id', $socio_id, PDO::PARAM_INT);
        $consultaPagos->execute();
        $pagos = $consultaPagos->fetchAll(PDO::FETCH_ASSOC);
        
        $totalPagos = count($pagos);
        $totalPagado = array_sum(array_column($pagos, 'monto'));
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pagos - Biblioteca</title>
    <link rel="stylesheet" href="../../css/usuario/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #35c4f3;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
        }
        
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-left: 4px solid var(--primary-color);
            margin-bottom: 20px;
        }
        
        .stats-card.success {
            border-left-color: var(--success-color);
        }
        
        .stats-card.warning {
            border-left-color: var(--warning-color);
        }
        
        .stats-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            opacity: 0.8;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .pagos-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .table th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
        }
        
        .table td {
            padding: 15px;
            vertical-align: middle;
        }
        
        .badge-pago {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .badge-completo {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-medio {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .monto-pago {
            font-weight: bold;
            color: var(--success-color);
        }
        
        .estado-inactivo {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
            border-radius: 12px;
            margin: 20px 0;
        }
        
        .estado-inactivo i {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div style="background: yellow; padding: 10px; margin: 10px 0;">
    <strong>DEBUG:</strong><br>
    - Carrito count: <?php echo count($_SESSION['usuario']); ?><br>
    - Action URL: controladores/reservaController.php<br>
    - Session ID: <?php echo $_SESSION['id'] ?? 'No encontrado'; ?>
</div>

    <?php include_once('cabecera.php'); ?>

    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-receipt me-3"></i>Mis Pagos</h1>
                    <p class="mb-0">Historial de todos tus pagos realizados en la biblioteca</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-success fs-6 p-3">
                        <i class="fas fa-user-check me-2"></i>Cuenta Activa
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (isset($mensaje_error)): ?>
            <!-- Mostrar mensaje de error si el socio no está activo -->
            <div class="estado-inactivo">
                <i class="fas fa-user-slash"></i>
                <h2>Cuenta No Activa</h2>
                <p class="lead"><?php echo $mensaje_error; ?></p>
                <p>Por favor, contacta con la administración para activar tu cuenta.</p>
                <a href="contacto.php" class="btn btn-light btn-lg mt-3">
                    <i class="fas fa-envelope me-2"></i>Contactar Administración
                </a>
            </div>
        <?php else: ?>
            <!-- Mostrar estadísticas y pagos si el socio está activo -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-icon text-primary">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="stats-number"><?php echo $totalPagos; ?></div>
                        <div class="stats-label">Total de Pagos Realizados</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card success">
                        <div class="stats-icon text-success">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stats-number">$<?php echo number_format($totalPagado, 2); ?></div>
                        <div class="stats-label">Total Pagado</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card warning">
                        <div class="stats-icon text-warning">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stats-number">Activo</div>
                        <div class="stats-label">Estado de tu Cuenta</div>
                    </div>
                </div>
            </div>

            <?php if ($totalPagos > 0): ?>
                <!-- Tabla de pagos -->
                <div class="pagos-table">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-calendar me-2"></i>Fecha de Pago</th>
                                    <th><i class="fas fa-tags me-2"></i>Tipo de Pago</th>
                                    <th><i class="fas fa-dollar-sign me-2"></i>Monto</th>
                                    <th><i class="fas fa-calendar-alt me-2"></i>Mes Pagado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pagos as $pago): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo date('d/m/Y', strtotime($pago['fecha_pago'])); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo date('H:i', strtotime($pago['fecha_pago'])); ?></small>
                                        </td>
                                        <td>
                                            <span class="badge-pago <?php echo $pago['tipo_pago'] == 'pago1' ? 'badge-completo' : 'badge-medio'; ?>">
                                                <?php echo $pago['tipo_pago'] == 'pago1' ? 'Cuota Completa' : 'Media Cuota'; ?>
                                            </span>
                                        </td>
                                        <td class="monto-pago">$<?php echo number_format($pago['monto'], 2); ?></td>
                                        <td>
                                            <span class="fw-bold"><?php echo htmlspecialchars($pago['mes_pagado']); ?></span>
                                        </td>
                                     
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <!-- Estado vacío cuando no hay pagos -->
                <div class="empty-state">
                    <i class="fas fa-receipt"></i>
                    <h3>No hay pagos registrados</h3>
                    <p>No se han encontrado pagos en tu historial.</p>
                    <p class="text-muted">Si crees que esto es un error, contacta con la administración.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">¿Necesitas ayuda con tus pagos?</h5>
                        <p class="card-text">Si tienes alguna duda sobre tus pagos o necesitas realizar un pago, no dudes en contactarnos.</p>
                        <a href="contacto.php" class="btn btn-primary">
                            <i class="fas fa-envelope me-2"></i>Contactar Soporte
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/usuario/bootstrap.bundle.min.js"></script>
    <script>
        // Efecto de hover en las filas de la tabla
        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('.table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.transition = 'transform 0.2s ease';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>