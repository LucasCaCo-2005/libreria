<?php
include_once("cabecera.php");
include_once(__DIR__ ."/../../Logica/Admin/bd.php");
// establece el formato de los meses, en ingles
$mesActual = date("F Y");

// Consulta para traer datos de los socios, se muestran los recienttes primero
$consultaPagos = $conexion->prepare("
    SELECT p.id, s.nombre, s.apellidos, p.tipo_pago, p.monto, p.fecha_pago, p.mes_pagado
    FROM pagos p
    INNER JOIN socios s ON p.socio_id = s.id
    WHERE p.mes_pagado = :mes
    ORDER BY p.fecha_pago DESC
");
$consultaPagos->bindParam(':mes', $mesActual, PDO::PARAM_STR);
$consultaPagos->execute();
$pagos = $consultaPagos->fetchAll(PDO::FETCH_ASSOC);

// Consulta para traer socios que NO estan en pagos
$consultaNoPagaron = $conexion->prepare("
    SELECT s.id, s.nombre, s.apellidos, s.cedula, s.correo, s.telefono
    FROM socios s
    WHERE s.id NOT IN (
        SELECT socio_id FROM pagos WHERE mes_pagado = :mes
    )
    ORDER BY s.apellidos, s.nombre
");
$consultaNoPagaron->bindParam(':mes', $mesActual, PDO::PARAM_STR);
$consultaNoPagaron->execute();
$noPagaron = $consultaNoPagaron->fetchAll(PDO::FETCH_ASSOC);

// Calculos para estadisticas
$totalPagos = count($pagos);
$totalNoPagaron = count($noPagaron);
$totalRecaudado = array_sum(array_column($pagos, 'monto'));
$totalSocios = $totalPagos + $totalNoPagaron;
$porcentajePagos = $totalSocios > 0 ? round(($totalPagos / $totalSocios) * 100, 1) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Pagos - <?php echo $mesActual; ?></title>
<<<<<<<< HEAD:presentacion/admin/pagosS.php
    <link rel="stylesheet" href="../../css/admin/pagoss.css">
========
    <link rel="stylesheet" href="../css/Admin/pagoss.css">
>>>>>>>> 72a969d9b84989c8325ef25b7bf44b91d1c94b1a:Presentacion/Admin/pagosS.php
    <style>
     
    </style>
</head>
<body>

<div class="reporte-pagos">
    <div class="header-reporte">
        <h1>📊 Reporte de Pagos Mensual</h1>
        <div class="mes-actual"><?php echo $mesActual; ?></div>
    </div>

    <!-- Estadísticas -->
    <div class="estadisticas-container">
        <div class="tarjeta-estadistica">
            <span class="estadistica-icono">👥</span>
            <div class="estadistica-valor valor-neutral"><?php echo $totalSocios; ?></div>
            <div class="estadistica-label">Total de Socios</div>
        </div>
        <div class="tarjeta-estadistica">
            <span class="estadistica-icono">✅</span>
            <div class="estadistica-valor valor-positivo"><?php echo $totalPagos; ?></div>
            <div class="estadistica-label">Socios que Pagaron</div>
        </div>
        <div class="tarjeta-estadistica">
            <span class="estadistica-icono">⏸️</span>
            <div class="estadistica-valor valor-negativo"><?php echo $totalNoPagaron; ?></div>
            <div class="estadistica-label">Socios Pendientes</div>
        </div>
        <div class="tarjeta-estadistica">
            <span class="estadistica-icono">💰</span>
            <div class="estadistica-valor valor-positivo">$<?php echo number_format($totalRecaudado, 2); ?></div>
            <div class="estadistica-label">Total Recaudado</div>
        </div>
    </div>

    <div class="secciones-reporte">
      
        <div class="seccion-pagos">
            <div class="seccion-header">
                <h2>
                    <span style="color: #4a8b6b;">✅</span>
                    Socios que Pagaron
                </h2>
                <span class="contador-seccion"><?php echo $totalPagos; ?> registros</span>
            </div>
            <div class="seccion-body"> <!-- -->
                <?php if ($totalPagos > 0): ?> <!-- Muestra pagos si hay en primer lugar -->
                    <div class="table-responsive">
                        <table class="tabla-pagos">
                            <thead>
                                <tr> <!-- Datos de interes -->
                                    <th>Socio</th>
                                    <th>Tipo de Pago</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Mes Pagado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pagos as $pago): // foreACH que muestra los pagos, tipo de pago y datos del socio ?>
                                    <tr>
                                        <td>
                                            <div class="info-socio">
                                                <div class="avatar-socio">
                                                    <?php echo strtoupper(substr($pago['nombre'], 0, 1) . substr($pago['apellidos'], 0, 1)); ?>
                                                </div>
                                                <div class="info-socio-texto">
                                                    <div class="nombre-socio">
                                                        <?php echo htmlspecialchars($pago['nombre'] . " " . $pago['apellidos']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td> <!-- Diferenciaicon de los tipos de pagos-->
                                            <span class="badge-tipo <?php echo $pago['tipo_pago'] == 'pago1' ? 'badge-completo' : 'badge-medio'; ?>">
                                                <?php echo $pago['tipo_pago'] == 'pago1' ? 'Cuota Completa' : 'Media Cuota'; ?>
                                            </span>
                                        </td>
                                        <td class="monto-pago">$<?php echo number_format($pago['monto'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($pago['fecha_pago']); ?></td>
                                        <td><?php echo htmlspecialchars($pago['mes_pagado']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Resumen de Recaudacion -->
                    <div class="resumen-recaudacion">
                        <div class="resumen-titulo">
                            <span>💰</span>
                            Resumen de Recaudacion
                        </div>
                        <div class="resumen-monto">$<?php echo number_format($totalRecaudado, 2); ?></div>
                        <div style="margin-top: 8px; font-size: 0.9rem; color: var(--color-dark); opacity: 0.8;">
                            <?php echo $porcentajePagos; ?>% de socios han pagado este mes
                        </div>
                    </div>
                <?php else: ?>
                    <div class="sin-registros">
                        <i>💸</i>
                        <h3>No hay pagos registrados</h3>
                        <p>No se han registrado pagos para el mes de <?php echo $mesActual; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Socios Pendientes a pagar -->
        <div class="seccion-pagos">
            <div class="seccion-header">
                <h2>
                    <span style="color: #8b6b6b;">⏸️</span>
                    Socios Pendientes de Pago
                </h2>
                <span class="contador-seccion"><?php echo $totalNoPagaron; ?> registros</span>
            </div>
            <div class="seccion-body">
                <?php if ($totalNoPagaron > 0): // muestra unicamente si hay pagos?> 
                    <div class="table-responsive">
                        <table class="tabla-pagos">
                            <thead>
                                <tr>
                                    <th>Socio</th>
                                    <th>Contacto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($noPagaron as $socio): ?><!-- Foreach para mostrar cada caso -->
                                    <tr>
                                        <td>
                                            <div class="info-socio">
                                                <div class="avatar-socio">
                                                    <?php
                                                    // saca la primer letra del nombre y apellido para el avatar, strtoupper vuelve mayuscula
                                                    echo strtoupper(substr($socio['nombre'], 0, 1) . substr($socio['apellidos'], 0, 1));  ?> 
                                                </div>
                                                <div class="info-socio-texto">
                                                    <div class="nombre-socio">
                                                        <?php echo htmlspecialchars($socio['nombre'] . " " . $socio['apellidos']); ?>
                                                    </div>
                                                    <div class="detalle-socio">
                                                        Cédula: <?php echo htmlspecialchars($socio['cedula']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="detalle-socio">
                                                <div>📧 <?php echo htmlspecialchars($socio['correo']); ?></div>
                                                <div>📞 <?php echo htmlspecialchars($socio['telefono']); ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="acciones-rapidas">
                                                <a href="pagos.php?socio_id=<?php echo $socio['id']; ?>" class="btn-pagar">
                                                    💵 Registrar Pago
                                                </a> <!-- Boton para ir a pagar rapido -->
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?> <!-- Caso de pago total -->
                    <div class="sin-registros">
                        <i>🎉</i>
                        <h3>¡Todos al día!</h3>
                        <p>Todos los socios han pagado este mes</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// solo hace algo cuando la pagina esta biwen cargada
document.addEventListener('DOMContentLoaded', function() {
    // Animación para las tarjetas 
    const tarjetas = document.querySelectorAll('.tarjeta-estadistica');
    tarjetas.forEach((tarjeta, index) => {
        tarjeta.style.animationDelay = `${index * 0.1}s`;
        tarjeta.classList.add('fade-in');
    });
    
    // Confirmación para registrar pagos y evitar pagos accidentales
    document.querySelectorAll('.btn-pagar').forEach(boton => {
        boton.addEventListener('click', function(e) {
            if (!confirm('¿Está seguro de que desea registrar el pago para este socio?')) {
                e.preventDefault();
            }
        });
    });
});
</script>

<style>
.fade-in {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
</body>
</html>