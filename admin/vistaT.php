<?php 

include_once ("seccion/bd.php");
include_once ("seccion/Talleres.php");

// Procesar acciones de activar/desactivar
if ($_POST) {
    $id = $_POST['id'] ?? '';
    $accion = $_POST['accion'] ?? '';
    
    if ($id && $accion) {
        $nuevoEstado = ($accion == 'habilitar') ? 'activo' : 'inactivo';
        $sentencia = $conexion->prepare("UPDATE talleres SET estado = :estado WHERE Id = :id");
        $sentencia->bindParam(':estado', $nuevoEstado);
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        
        // Recargar para ver cambios
        header("Location: vistaT.php?estado=" . ($_GET['estado'] ?? 'todos'));
        exit();
    }
}

$filtro = isset($_GET['estado']) ? $_GET['estado'] : "todos";

if ($filtro == "activo") {
    $sentencia = $conexion->prepare("SELECT * FROM talleres WHERE estado='activo'");
} elseif ($filtro == "inactivo") {
    $sentencia = $conexion->prepare("SELECT * FROM talleres WHERE estado='inactivo'");
} else {
    $sentencia = $conexion->prepare("SELECT * FROM talleres");
}

$sentencia->execute();
$listaTalleres = $sentencia->fetchAll(PDO::FETCH_ASSOC);


include_once 'template/cabecera.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Talleres</title>
    <link rel="stylesheet" href="./css/vistaT.css">
</head>
<body>

<div class="contenedor-principal">
    <div class="header-talleres">
        <h1>🎨 Gestión de Talleres</h1>
        <p>Administra y visualiza todos los talleres disponibles</p>
    </div>

    <div class="controles-busqueda">
        <div class="buscador-container">
            <input type="text" id="searchInput" onkeyup="filterTalleres()" 
                   placeholder="🔍 Buscar taller por nombre..." class="buscador-input">
        </div>
        
        <div class="filtros-container">
            <a href="vistaT.php?estado=todos" class="btn-filtro <?= $filtro == 'todos' ? 'btn-filtro-activo' : '' ?>">
                📋 Todos los Talleres
            </a>
            <a href="vistaT.php?estado=activo" class="btn-filtro <?= $filtro == 'activo' ? 'btn-filtro-activo' : '' ?>">
                ✅ Talleres Activos
            </a>
            <a href="vistaT.php?estado=inactivo" class="btn-filtro <?= $filtro == 'inactivo' ? 'btn-filtro-activo' : '' ?>">
                ⚠️ Talleres Inactivos
            </a>
        </div>
    </div>

    <?php if (empty($listaTalleres)): ?>
        <div class="mensaje-vacio">
            <div class="icono-vacio">📭</div>
            <h3>No hay talleres disponibles</h3>
            <p>No se encontraron talleres en el estado seleccionado.</p>
        </div>
    <?php else: ?>
        <div class="grid-talleres">
            <?php foreach($listaTalleres as $taller): ?>
                <div class="card-taller list-group-item">
                    <div class="card-header">
                        <h3 class="titulo-taller"><?php echo htmlspecialchars($taller['nombre']); ?></h3>
                        <span class="estado-badge estado-<?php echo $taller['estado']; ?>">
                            <?php echo $taller['estado'] == 'activo' ? '🟢 Activo' : '🔴 Inactivo'; ?>
                        </span>
                    </div>
                    
                    <div class="card-body">
                        <div class="info-taller">
                            <div class="info-item">
                                <span class="info-icono">📅</span>
                                <span class="info-texto"><?php echo htmlspecialchars($taller['dia']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-icono">⏰</span>
                                <span class="info-texto"><?php echo htmlspecialchars($taller['horario']); ?></span>
                            </div>
                        </div>
                        
                        <div class="imagen-taller">
                            <img src="../images/<?php echo $taller['foto']; ?>" 
                                 alt="<?php echo htmlspecialchars($taller['nombre']); ?>" 
                                 class="img-taller">
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <form id="formTaller<?php echo $taller['Id']; ?>" action="vistaT.php" method="post" class="form-accion">
                            <input type="hidden" name="id" value="<?php echo $taller['Id']; ?>">
                            <input type="hidden" name="accion" value="">
                        </form>
                        
                        <div class="botones-accion">
                            <a href="t.php?id=<?php echo $taller['Id'];?>" class="btn btn-ver">
                                👁️ Ver Detalles
                            </a>
                            
                            <button type="button" 
                                    class="btn btn-estado <?php echo $taller['estado'] == 'activo' ? 'btn-desactivar' : 'btn-activar'; ?>" 
                                    onclick="enviarAccion('<?php echo $taller['Id']; ?>', '<?php echo $taller['estado'] == 'activo' ? 'deshabilitar' : 'habilitar'; ?>')">
                                <?php echo $taller['estado'] == 'activo' ? '⏸️ Desactivar' : '▶️ Activar'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function filterTalleres() {
    var input, filter, container, items, title, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    container = document.querySelector('.grid-talleres');
    items = container.getElementsByClassName('list-group-item');
    
    for (i = 0; i < items.length; i++) {
        title = items[i].getElementsByClassName("titulo-taller")[0];
        if (title) {
            txtValue = title.textContent || title.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                items[i].style.display = "";
            } else {
                items[i].style.display = "none";
            }
        }
    }
}

function enviarAccion(id, accion) {
    const form = document.getElementById('formTaller' + id);
    form.querySelector('[name="accion"]').value = accion;
    form.submit();
}
</script>

</body>
</html>