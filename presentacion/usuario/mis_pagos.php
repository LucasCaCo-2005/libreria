<?php
// mis_pagos.php - VERSIÓN CORREGIDA
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ ."/../../Logica/Admin/bd.php");
include_once(__DIR__ ."/../../Logica/usuario/pagos.php");
// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pagos - Biblioteca</title>
    <link rel="stylesheet" href="../../css/usuario/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/usuario/mpagos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      
    </style>
</head>
<body>
    

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
                <p>Contacta con la asociacion y hazte socio para activar tu cuenta.</p>
                <a href="contacto.php" class="btn btn-light btn-lg mt-3">
                    <i class="fas fa-envelope me-2"></i>Contactar Asociacion
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