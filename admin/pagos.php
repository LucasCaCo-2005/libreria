<?php
include_once("seccion/bd.php");
include_once("template/cabecera.php");
include_once("seccion/users.php");

// Verifica si se recibió el ID del socio por GET
if (!isset($_GET['socio_id'])) {
    echo "No se ha especificado un socio.";
    exit;
}
$socio_id = intval($_GET['socio_id']);

// Obtiene los datos del socio
$sentencia = $conexion->prepare("SELECT id, nombre, apellidos, correo, cedula, telefono FROM socios WHERE id = :id");
$sentencia->bindParam(':id', $socio_id, PDO::PARAM_INT);
$sentencia->execute();
$socio = $sentencia->fetch(PDO::FETCH_ASSOC);

if (!$socio) {
    echo "Socio no encontrado.";
    exit;
}

// Variables del formulario
$accion = isset($_POST['accion']) ? $_POST['accion'] : "";
$tipoPago = isset($_POST['tipo_pago']) ? $_POST['tipo_pago'] : "";

// Lógica principal de acciones
switch ($accion) {
    case "Pagar":
        $mesActual = date("F Y");
        $fechaHoy = date("Y-m-d");

        // Definimos los tipos de pago
        $tipos = [
            "pago1" => 100.00,
            "pago2" => 50.00
        ];

        if (array_key_exists($tipoPago, $tipos)) {
            $monto = $tipos[$tipoPago];

            // Verificar si el socio ya pagó ese tipo en el mes actual
            $check = $conexion->prepare("
                SELECT COUNT(*) 
                FROM pagos 
                WHERE socio_id = :socio_id 
                  AND mes_pagado = :mes 
                  AND tipo_pago = :tipo_pago
            ");
            $check->bindParam(':socio_id', $socio_id, PDO::PARAM_INT);
            $check->bindParam(':mes', $mesActual, PDO::PARAM_STR);
            $check->bindParam(':tipo_pago', $tipoPago, PDO::PARAM_STR);
            $check->execute();

            if ($check->fetchColumn() == 0) {
                // Registrar el pago
                $insert = $conexion->prepare("
                    INSERT INTO pagos (socio_id, fecha_pago, mes_pagado, tipo_pago, monto)
                    VALUES (:socio_id, :fecha_pago, :mes_pagado, :tipo_pago, :monto)
                ");
                $insert->bindParam(':socio_id', $socio_id, PDO::PARAM_INT);
                $insert->bindParam(':fecha_pago', $fechaHoy, PDO::PARAM_STR);
                $insert->bindParam(':mes_pagado', $mesActual, PDO::PARAM_STR);
                $insert->bindParam(':tipo_pago', $tipoPago, PDO::PARAM_STR);
                $insert->bindParam(':monto', $monto);
                $insert->execute();

                $mensajeExito = "✅ Pago registrado correctamente - $" . $monto . " - " . $mesActual;
            } else {
                $mensajeError = "⚠️ Este socio ya realizó este pago en $mesActual";
            }
        }
        break;

    case "QuitarPago":
        if (isset($_POST['pago_id'])) {
            $pago_id = intval($_POST['pago_id']);
            $delete = $conexion->prepare("DELETE FROM pagos WHERE id = :id");
            $delete->bindParam(':id', $pago_id, PDO::PARAM_INT);
            $delete->execute();
            $mensajeExito = "🗑️ Pago eliminado correctamente";
        }
        break;
}

// Consulta de pagos del mes actual
$mesActual = date("F Y");

$sentenciaPagos = $conexion->prepare("
    SELECT p.*, s.nombre, s.apellidos 
    FROM pagos p
    INNER JOIN socios s ON p.socio_id = s.id
    WHERE p.mes_pagado = :mes
");
$sentenciaPagos->bindParam(':mes', $mesActual, PDO::PARAM_STR);
$sentenciaPagos->execute();
$listaPagos = $sentenciaPagos->fetchAll(PDO::FETCH_ASSOC);

// Contar total de socios que pagaron este mes
$sentenciaContador = $conexion->prepare("
    SELECT COUNT(DISTINCT socio_id) as total 
    FROM pagos 
    WHERE mes_pagado = :mes
");
$sentenciaContador->bindParam(':mes', $mesActual, PDO::PARAM_STR);
$sentenciaContador->execute();
$totalPagos = $sentenciaContador->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener historial de pagos del socio
$sentenciaHistorial = $conexion->prepare("
    SELECT * FROM pagos 
    WHERE socio_id = :socio_id 
    ORDER BY fecha_pago DESC 
    LIMIT 10
");
$sentenciaHistorial->bindParam(':socio_id', $socio_id, PDO::PARAM_INT);
$sentenciaHistorial->execute();
$historialPagos = $sentenciaHistorial->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Pagos - <?php echo htmlspecialchars($socio['nombre'] . " " . $socio['apellidos']); ?></title>
    <link rel="stylesheet" href="./css/pagos.css">
    <style>
    
    </style>
</head>
<body>

<div class="pagos-container">
    <!-- Header -->
    <div class="header-pagos">
        <h1>💰 Gestor de Pagos</h1>
        <p class="subtitle">Administración de pagos para socios</p>
    </div>

    <!-- Alertas -->
    <?php if (isset($mensajeExito)): ?>
        <div class="alertas">
            <div class="alerta alerta-exito">
                <span class="alerta-icono">✅</span>
                <span><?php echo $mensajeExito; ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($mensajeError)): ?>
        <div class="alertas">
            <div class="alerta alerta-error">
                <span class="alerta-icono">⚠️</span>
                <span><?php echo $mensajeError; ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Información del Socio -->
    <div class="info-socio">
        <div class="info-grid">
            <div class="info-item">
                <span class="info-icono">👤</span>
                <div class="info-contenido">
                    <div class="info-label">Socio</div>
                    <div class="info-valor"><?php echo htmlspecialchars($socio['nombre'] . " " . $socio['apellidos']); ?></div>
                </div>
            </div>
            <div class="info-item">
                <span class="info-icono">🆔</span>
                <div class="info-contenido">
                    <div class="info-label">Cédula</div>
                    <div class="info-valor"><?php echo htmlspecialchars($socio['cedula']); ?></div>
                </div>
            </div>
            <div class="info-item">
                <span class="info-icono">📧</span>
                <div class="info-contenido">
                    <div class="info-label">Correo</div>
                    <div class="info-valor"><?php echo htmlspecialchars($socio['correo']); ?></div>
                </div>
            </div>
            <div class="info-item">
                <span class="info-icono">📞</span>
                <div class="info-contenido">
                    <div class="info-label">Teléfono</div>
                    <div class="info-valor"><?php echo htmlspecialchars($socio['telefono']); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="pagos-content">
        <!-- Sección de Pagos -->
        <div class="seccion-pago">
            <div class="seccion-header">
                <h2>💳 Registrar Nuevo Pago</h2>
            </div>
            <div class="seccion-body">
                <div class="opciones-pago">
                    <!-- Pago Completo -->
                    <div class="opcion-pago">
                        <div class="opcion-header">
                            <div class="opcion-titulo">Cuota Completa</div>
                            <div class="opcion-monto">$100.00</div>
                        </div>
                        <div class="opcion-descripcion">
                            Pago mensual completo - Acceso a todos los servicios de la biblioteca
                        </div>
                        <form action="pagos.php?socio_id=<?php echo $socio_id; ?>" method="post">
                            <input type="hidden" name="socio_id" value="<?php echo $socio['id']; ?>">
                            <input type="hidden" name="tipo_pago" value="pago1">
                            <button type="submit" name="accion" value="Pagar" class="btn-pagar btn-pagar-completo">
                                💰 Pagar Cuota Completa
                            </button>
                        </form>
                    </div>

                    <!-- Pago Medio -->
                    <div class="opcion-pago">
                        <div class="opcion-header">
                            <div class="opcion-titulo">Media Cuota</div>
                            <div class="opcion-monto">$50.00</div>
                        </div>
                        <div class="opcion-descripcion">
                            Pago reducido - Acceso limitado a servicios de la biblioteca
                        </div>
                        <form action="pagos.php?socio_id=<?php echo $socio_id; ?>" method="post">
                            <input type="hidden" name="socio_id" value="<?php echo $socio['id']; ?>">
                            <input type="hidden" name="tipo_pago" value="pago2">
                            <button type="submit" name="accion" value="Pagar" class="btn-pagar btn-pagar-medio">
                                💰 Pagar Media Cuota
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de Pagos -->
        <div class="seccion-pago">
            <div class="seccion-header">
                <h2>📊 Historial de Pagos Recientes</h2>
            </div>
            <div class="seccion-body">
                <div class="historial-pagos">
                    <?php if (empty($historialPagos)): ?>
                        <div class="sin-historial">
                            <i>💸</i>
                            <p>No hay pagos registrados</p>
                            <small>Los pagos aparecerán aquí una vez realizados</small>
                        </div>
                    <?php else: ?>
                        <?php foreach ($historialPagos as $pago): ?>
                            <div class="pago-item">
                                <div class="pago-info">
                                    <div class="pago-mes"><?php echo htmlspecialchars($pago['mes_pagado']); ?></div>
                                    <div class="pago-detalle">
                                        <?php 
                                        $tipoTexto = $pago['tipo_pago'] == 'pago1' ? 'Cuota Completa' : 'Media Cuota';
                                        echo $tipoTexto . ' - ' . $pago['fecha_pago'];
                                        ?>
                                    </div>
                                </div>
                                <div class="pago-monto">$<?php echo number_format($pago['monto'], 2); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Adicionales -->
    <div class="acciones-adicionales">
        <a href="pagosS.php" class="btn-secundario">
            📋 Ver Todos los Pagos
        </a>
    </div>
</div>

<script>
// Efecto de selección en las opciones de pago
document.querySelectorAll('.opcion-pago').forEach(opcion => {
    opcion.addEventListener('click', function() {
        // Remover selección anterior
        document.querySelectorAll('.opcion-pago').forEach(o => {
            o.classList.remove('seleccionada');
        });
        // Agregar selección actual
        this.classList.add('seleccionada');
    });
});

// Confirmación para pagos
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const tipoPago = this.querySelector('[name="tipo_pago"]').value;
        const monto = tipoPago === 'pago1' ? '$100.00' : '$50.00';
        const confirmacion = confirm(`¿Está seguro de registrar el pago de ${monto}?`);
        
        if (!confirmacion) {
            e.preventDefault();
        }
    });
});
</script>

<?php include_once 'template/pie.php'; ?>
</body>
</html>