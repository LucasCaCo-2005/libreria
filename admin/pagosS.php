<?php

include_once("template/cabecera.php");
include_once("seccion/bd.php");

// Mes actual en formato igual al usado en pagos.php
$mesActual = date("F Y");

// --- 1️⃣ Obtener todos los pagos realizados este mes ---
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

// --- 2️⃣ Obtener socios que NO han pagado este mes ---
$consultaNoPagaron = $conexion->prepare("
    SELECT s.id, s.nombre, s.apellidos, s.cedula
    FROM socios s
    WHERE s.id NOT IN (
        SELECT socio_id FROM pagos WHERE mes_pagado = :mes
    )
    ORDER BY s.apellidos, s.nombre
");
$consultaNoPagaron->bindParam(':mes', $mesActual, PDO::PARAM_STR);
$consultaNoPagaron->execute();
$noPagaron = $consultaNoPagaron->fetchAll(PDO::FETCH_ASSOC);

// Contadores
$totalPagos = count($pagos);
$totalNoPagaron = count($noPagaron);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagos del Mes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2, h3 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #fafafa; }
        .pagos { color: green; }
        .nopagos { color: red; }
       
    </style>
</head>
<body>

    <h2>💰 Registro de Pagos — <?php echo $mesActual; ?></h2>

    <h3 class="pagos">Socios que pagaron este mes (<?php echo $totalPagos; ?>)</h3>
    <?php if ($totalPagos > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Socio</th>
                    <th>Tipo de Pago</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Mes Pagado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pagos as $pago): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pago['nombre'] . " " . $pago['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($pago['tipo_pago']); ?></td>
                        <td>$<?php echo number_format($pago['monto'], 2); ?></td>
                        <td><?php echo htmlspecialchars($pago['fecha_pago']); ?></td>
                        <td><?php echo htmlspecialchars($pago['mes_pagado']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay pagos registrados este mes.</p>
    <?php endif; ?>


    <h3 class="nopagos">Socios que aún no pagaron (<?php echo $totalNoPagaron; ?>)</h3>
    <?php if ($totalNoPagaron > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Socio</th>
                    <th>cedula</th>
                     <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($noPagaron as $socio): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($socio['nombre'] . " " . $socio['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($socio['cedula']); ?></td>
                        <td>
                            <a href="pagos.php?socio_id=<?php echo $socio['id']; ?>" class="btn">
                                💵 Pagar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>🎉 Todos los socios han pagado este mes.</p>
    <?php endif; ?>

</body>
</html>
