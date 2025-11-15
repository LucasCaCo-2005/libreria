<?php

include_once(__DIR__ ."/../../Logica/Admin/bd.php");

include_once(__DIR__ ."/../../Logica/Admin/users.php");
include_once("cabecera.php");
// carga datos de los socios
$txtID         = $_POST['txtID'] ?? "";
$txtNombre     = $_POST['txtNombre'] ?? "";
$txtApellido   = $_POST['txtApellido'] ?? "";
$txtCedula     = $_POST['txtCedula'] ?? "";
$txtDomicilio  = $_POST['txtDomicilio'] ?? "";
$txtTelefono   = $_POST['txtTelefono'] ?? "";
$txtCorreo     = $_POST['txtCorreo'] ?? "";
$txtContraseña = $_POST['txtContraseña'] ?? "";
$txtestado     = $_POST['txtestado'] ?? "";
$accion        = $_POST['accion'] ?? "";
// Filtro por estado  con get
$estadoSeleccionado = $_GET['estado'] ?? '';
$filtro = $estadoSeleccionado ? "WHERE estado = :estado" : '';
// select de los socios
$sentencia = $conexion->prepare("SELECT * FROM socios $filtro");
if ($estadoSeleccionado) {
    $sentencia->bindParam(':estado', $estadoSeleccionado);
}
$sentencia->execute();
$listaSocios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Socios - Biblioteca</title>

    <link rel="stylesheet" href="../../css/admin/sociost.css">

    <link rel="stylesheet" href="../css/Admin/sociost.css">

   
</head>
<body>

<div class="socios-dashboard">
    <div class="dashboard-header">
        <h1>👥 Gestión de Socios</h1>
        <p>Administra y visualiza la información de todos los socios</p>
    </div>


    <div class="controles-superiores"> <!-- Buscador por nombre sin recargar pagina gracias a Js-->
        <div class="buscador-container">
            <input type="text" id="searchInput" class="buscador-input" 
                   placeholder="🔍 Buscar socio por nombre o apellido..." 
                   onkeyup="filterItems()">
            <span class="buscador-icono">📋</span>
        </div>
        
        <div class="filtro-container">
            <span class="filtro-label">Filtrar por estado:</span>
            <form method="GET" class="filtro-form">
                <select name="estado" onchange="this.form.submit()" class="filtro-select"> <!-- Filtro instantaneo -->
                    <option value="">Todos los socios</option>
                    <option value="activo" <?= ($estadoSeleccionado == 'activo') ? 'selected' : ''; ?>>🟢 Activos</option>
                    <option value="inactivo" <?= ($estadoSeleccionado == 'inactivo') ? 'selected' : ''; ?>>🔴 Inactivos</option>
                </select>
            </form>
        </div>
    </div>

    <?php // stats de los socios
    $totalSocios = count($listaSocios);
    $sociosActivos = count(array_filter($listaSocios, fn($socio) => $socio['estado'] === 'activo'));
    $sociosInactivos = $totalSocios - $sociosActivos;
    ?>
    
    <div class="estadisticas-container">
        <div class="tarjeta-estadistica">
            <span class="estadistica-icono">👥</span>
            <div class="estadistica-valor"><?= $totalSocios; ?></div>
            <div class="estadistica-label">Total de Socios</div>
        </div>
        <div class="tarjeta-estadistica">
            <span class="estadistica-icono">✅</span>
            <div class="estadistica-valor"><?= $sociosActivos; ?></div>
            <div class="estadistica-label">Socios Activos</div>
        </div>
        <div class="tarjeta-estadistica">
            <span class="estadistica-icono">⏸️</span>
            <div class="estadistica-valor"><?= $sociosInactivos; ?></div>
            <div class="estadistica-label">Socios Inactivos</div>
        </div>
    </div>

    <div class="grid-socios" id="sociosContainer">
        <?php if (empty($listaSocios)): ?>
            <div class="sin-resultados">
                <i>👥</i>
                <h3>No se encontraron socios</h3>
                <p><?= $estadoSeleccionado ? "No hay socios $estadoSeleccionado" : "No hay socios registrados en el sistema"; ?></p>
            </div>
        <?php else: ?>
            <?php foreach ($listaSocios as $socio): ?>
                <div class="tarjeta-socio" data-nombre="<?= htmlspecialchars(strtoupper($socio['nombre'] . ' ' . $socio['apellidos'])); ?>">
                   
                    <div class="tarjeta-header">
                        <span class="estado-socio estado-<?= $socio['estado']; ?>">
                            <?= $socio['estado'] == 'activo' ? '🟢 Activo' : '🔴 Inactivo'; ?>
                        </span>
                        <h3 class="nombre-socio"><?= htmlspecialchars($socio['nombre'] . ' ' . $socio['apellidos']); ?></h3>
                        <p class="cedula-socio">📋 <?= htmlspecialchars($socio['cedula']); ?></p>
                    </div>

                    <div class="tarjeta-body">
                        <div class="info-item">
                            <span class="info-icono">🏠</span>
                            <div class="info-contenido">
                                <div class="info-label">Domicilio</div>
                                <div class="info-valor"><?= htmlspecialchars($socio['domicilio'] ?: 'No especificado'); ?></div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-icono">📞</span>
                            <div class="info-contenido">
                                <div class="info-label">Teléfono</div>
                                <div class="info-valor"><?= htmlspecialchars($socio['telefono'] ?: 'No especificado'); ?></div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-icono">📧</span>
                            <div class="info-contenido">
                                <div class="info-label">Correo Electrónico</div>
                                <div class="info-valor"><?= htmlspecialchars($socio['correo']); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="tarjeta-footer">
                        <a href="socios.php?socio_id=<?= $socio['id']; ?>" class="btn-accion btn-editar">
                            ✏️ Editar
                        </a>
                        
                        <a href="pagos.php?socio_id=<?= $socio['id']; ?>" class="btn-accion btn-pagos">
                            💰 Pagos
                        </a>

                        <form id="formSocio<?= $socio['id']; ?>" method="POST" action="SociosT.php" class="form-accion-socio">
                            <input type="hidden" name="socio_id" value="<?= $socio['id']; ?>">
                            <input type="hidden" name="nuevo_estado" value="">
                        </form>
                        
                        <button type="button" 
                                class="btn-accion btn-estado <?= $socio['estado'] == 'activo' ? 'btn-desactivar' : 'btn-activar'; ?>" 
                                onclick="enviarSocioAccion('<?= $socio['id']; ?>', '<?= $socio['estado'] == 'activo' ? 'inactivo' : 'activo'; ?>')">
                            <?= $socio['estado'] == 'activo' ? '⏸️ Desactivar' : '▶️ Activar'; ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script> // gestion de estados, cambiar de estados por error
function enviarSocioAccion(id, nuevoEstado) {
    const confirmacion = confirm(`¿Está seguro de que desea ${nuevoEstado === 'activo' ? 'activar' : 'desactivar'} este socio?`);
    if (confirmacion) {
        const form = document.getElementById('formSocio' + id);
        form.querySelector('[name="nuevo_estado"]').value = nuevoEstado;
        form.submit();
    }
}
// busqueda en tiempo real
function filterItems() {
    const input = document.getElementById('searchInput');
    const filter = (input.value || '').trim().toUpperCase();
    const items = document.querySelectorAll('.tarjeta-socio');

    items.forEach(function(card) {
        const nombre = card.dataset.nombre || '';
        if (filter === '' || nombre.includes(filter)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

<?php include_once 'pie.php'; ?>
</body>
</html>