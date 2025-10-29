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
$sentencia = $conexion->prepare("SELECT id, nombre, apellidos, correo FROM socios WHERE id = :id");
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

                echo "<script>alert('Pago registrado correctamente');</script>";
            } else {
                echo "<script>alert('Este socio ya realizó este pago en $mesActual');</script>";
            }
        }
        break;

    case "QuitarPago":
        if (isset($_POST['pago_id'])) {
            $pago_id = intval($_POST['pago_id']);
            $delete = $conexion->prepare("DELETE FROM pagos WHERE id = :id");
            $delete->bindParam(':id', $pago_id, PDO::PARAM_INT);
            $delete->execute();
            echo "<script>alert('Pago eliminado correctamente');</script>";
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Pagos - <?php echo htmlspecialchars($socio['nombre'] . ' ' . $socio['apellidos']); ?></title>
    <link rel="stylesheet" href="css/pagos.css">
</head>
<body>
    <div class="pagos-container">
        <div class="header-pagos">
            <h1>💰 Gestión de Pagos</h1>
            <p class="subtitle">Administración de pagos para socios</p>
        </div>

        <div class="info-socio">
            <div class="info-card">
                <div class="info-header">
                    <h3>👤 Información del Socio</h3>
                </div>
                <div class="info-content">
                    <div class="info-item">
                        <span class="info-label">Nombre:</span>
                        <span class="info-value"><?php echo htmlspecialchars($socio['nombre'] . ' ' . $socio['apellidos']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Correo:</span>
                        <span class="info-value"><?php echo htmlspecialchars($socio['correo']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">ID Socio:</span>
                        <span class="info-value">#<?php echo $socio_id; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="pagos-content">
            <div class="seccion-pago">
                <h2>💳 Registrar Nuevo Pago</h2>
                <div class="opciones-pago">
                    <form action="pagos.php?socio_id=<?php echo $socio_id; ?>" method="post" class="form-pago">
                        <input type="hidden" name="socio_id" value="<?php echo $socio['id']; ?>">
                        <input type="hidden" name="tipo_pago" value="pago1">
                        <button type="submit" name="accion" value="Pagar" class="btn-pagar btn-completo">
                            <span class="btn-icon">💰</span>
                            <span class="btn-text">Pagar Cuota Completa</span>
                            <span class="btn-monto">$100.00</span>
                        </button>
                    </form>

                    <form action="pagos.php?socio_id=<?php echo $socio_id; ?>" method="post" class="form-pago">
                        <input type="hidden" name="socio_id" value="<?php echo $socio['id']; ?>">
                        <input type="hidden" name="tipo_pago" value="pago2">
                        <button type="submit" name="accion" value="Pagar" class="btn-pagar btn-medio">
                            <span class="btn-icon">💵</span>
                            <span class="btn-text">Pagar Media Cuota</span>
                            <span class="btn-monto">$50.00</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="stats-section">
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $totalPagos; ?></div>
                        <div class="stat-label">Socios pagaron este mes</div>
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
</body>
</html>