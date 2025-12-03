<?php
// Obtener información actualizada del socio desde la base de datos
$socio_id = $_SESSION['usuario']['id'];

// Consultar el estado actual del socio desde la base de datos
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