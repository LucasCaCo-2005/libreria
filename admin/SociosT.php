<?php
// --- INICIA PHP: incluye cabecera y carga datos ---
include_once("config/bd.php");
include_once("template/cabecera.php");
include_once("seccion/users.php");

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


$estadoSeleccionado = $_GET['estado'] ?? '';
$filtro = $estadoSeleccionado ? "WHERE estado = :estado" : '';

$sentencia = $conexion->prepare("SELECT * FROM socios $filtro");
if ($estadoSeleccionado) {
    $sentencia->bindParam(':estado', $estadoSeleccionado);
}
$sentencia->execute();
$listaSocios = $sentencia->fetchAll(PDO::FETCH_ASSOC);




?>
<style>

.col-12.socios-wrapper { padding: 0; }

.socios-container {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 15px !important;
    width: 100%;
    align-items: flex-start;
    margin-top: 10px;
}

.socio-card {
    flex: 0 1 calc(33.333% - 10px); 
    box-sizing: border-box;
    min-width: 220px;
    border: 1px solid #ceabab;
    border-radius: 10px;
    padding: 14px;
    background-color: #fff;
    box-shadow: 2px 2px 6px rgba(0,0,0,0.08);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.socio-card:hover {
    transform: translateY(-4px);
    box-shadow: 3px 6px 14px rgba(0,0,0,0.12);
}

.socio-card h5 { margin: 0 0 8px; color: #333; }
.socio-card p { margin: 4px 0; color: #555; font-size: 0.95rem; }

@media (max-width: 992px) {
    .socio-card { flex: 0 1 calc(50% - 10px); } 
}
@media (max-width: 576px) {
    .socio-card { flex: 0 1 100%; }
}
.button1 {
    background-color: #0057a0;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button1:hover {
    background-color: #003d70;
}

.button {
    background-color: #008000;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button2 {
    background-color: #ff0000;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button3 {
    background-color: #966868ff;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.form-control.search-socios { width: 100%; max-width: 360px; }
</style>

<div class="col-12 socios-wrapper">
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control search-socios" placeholder="Buscar socio por nombre o apellido" onkeyup="filterItems()">
    </div>

    <form method="GET" class="mb-3">
        <select name="estado" onchange="this.form.submit()" class="form-control" style="max-width:220px;">
            <option value="">Todos los estados</option>
            <option value="activo" <?php if ($estadoSeleccionado == 'activo') echo 'selected'; ?>>Activos</option>
            <option value="inactivo" <?php if ($estadoSeleccionado == 'inactivo') echo 'selected'; ?>>Inactivos</option>
        </select>
    </form>

 <div class="socios-container" id="sociosContainer">
    <?php foreach ($listaSocios as $socio): ?>
        <div class="socio-card" data-nombre="<?php echo htmlspecialchars(strtoupper($socio['nombre'] . ' ' . $socio['apellidos'])); ?>">
            <h5><?php echo htmlspecialchars($socio['nombre'] . ' ' . $socio['apellidos']); ?></h5>
            <p><strong>Cédula:</strong> <?php echo htmlspecialchars($socio['cedula']); ?></p>
            <p><strong>Domicilio:</strong> <?php echo htmlspecialchars($socio['domicilio']); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($socio['telefono']); ?></p>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($socio['correo']); ?></p>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars(ucfirst($socio['estado'])); ?></p>

            <button type="button" class="button1" onclick="window.location.href='socios.php?socio_id=<?php echo $socio['id']; ?>'">Ir a editar</button>
            <button type="button" class="button" onclick="window.location.href='pagos.php?socio_id=<?php echo $socio['id']; ?>'">Ver pagos</button>

            <!-- Formulario oculto -->
            <form id="formSocio<?php echo $socio['id']; ?>" method="POST" action="SociosT.php" style="display:inline;">
                <input type="hidden" name="socio_id" value="<?php echo $socio['id']; ?>">
                <input type="hidden" name="nuevo_estado" value="">
            </form>

            <!-- Botón visible que activa/desactiva -->
            <button 
                type="button" 
                class="button2" 
                onclick="enviarSocioAccion('<?php echo $socio['id']; ?>', '<?php echo $socio['estado'] == 'activo' ? 'inactivo' : 'activo'; ?>')">
                <?php echo $socio['estado'] == 'activo' ? 'Desactivar' : 'Activar'; ?>
            </button>
        </div>
    <?php endforeach; ?>
</div>

<script>
function enviarSocioAccion(id, nuevoEstado) {
    const form = document.getElementById('formSocio' + id);
    form.querySelector('[name="nuevo_estado"]').value = nuevoEstado;
    form.submit();
}
</script>


<script>
function filterItems() {
    var input = document.getElementById('searchInput');
    var filter = (input.value || '').trim().toUpperCase();
    var items = document.querySelectorAll('.socio-card');

    items.forEach(function(card) {
        var nombre = card.dataset.nombre || '';
        if (filter === '' || nombre.indexOf(filter) > -1) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>





<?php include_once 'template/pie.php'; ?>
</div>
</div> 
