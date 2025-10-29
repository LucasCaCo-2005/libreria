<?php
include_once "seccion/talleres.php";
include_once "template/cabecera.php";
include_once "seccion/bd.php";
$tallerSeleccionado = null;
$resultados = [];

// Conexión
$conn = (new conexion())->Conectar();
// Variables del formulario
$txtID          = $_POST['id'] ?? "";
$txtNombre      = $_POST['nombre'] ?? "";
$txtDia         = $_POST['dia'] ?? "";
$txtHorario     = $_POST['horario'] ?? "";
$txtDescripcion = $_POST['descripcion'] ?? "";
$costo          = $_POST['costo'] ?? "";
$txtestado      = $_POST['estado'] ?? "";
$accion         = $_POST['accion'] ?? "";

if (isset($_POST['agregar'])) {
    $taller = new Talleres();
    $taller->setNombre($txtNombre);
    $taller->setDia($txtDia);
    $taller->setHorario($txtHorario);
    $taller->setDescripcion($txtDescripcion);
    $taller->setCosto($costo);
    $taller->setEstado($txtestado ?: "activo");

    // Subir imagen si se seleccionó
    if (!empty($_FILES['image']['name'])) {
        include_once "../cargarimagen.php";
        $foto = CargarFoto();
        if ($foto) {
            $taller->setFoto($foto);
        }
    }

    $taller->CargarTalleres();
}

if (isset($_POST['ListarTalleres'])) {
    $taller = new Talleres();
    $resultados = $taller->ListarTalleres();
}

if (isset($_POST['BuscarTalleres'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("SELECT * FROM talleres WHERE Id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $tallerSeleccionado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tallerSeleccionado) {
        $txtID          = $tallerSeleccionado['Id'];
        $txtNombre      = $tallerSeleccionado['nombre'];
        $txtDia         = $tallerSeleccionado['dia'];
        $txtHorario     = $tallerSeleccionado['horario'];
        $txtDescripcion = $tallerSeleccionado['descripcion'];
        $costo          = $tallerSeleccionado['costo'];
        $txtestado      = $tallerSeleccionado['estado'];
    }
}

if (isset($_POST['Modificar'])) {
    $id = intval($_POST['id']);
    if ($id > 0) {
        // Actualizar campos con PDO
        $sql = "UPDATE talleres 
                SET nombre = :nombre, dia = :dia, horario = :horario, descripcion = :descripcion, 
                    costo = :costo, estado = :estado 
                WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $txtNombre);
        $stmt->bindParam(':dia', $txtDia);
        $stmt->bindParam(':horario', $txtHorario);
        $stmt->bindParam(':descripcion', $txtDescripcion);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':estado', $txtestado);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Si se subió una nueva imagen, actualizarla
        if (!empty($_FILES['image']['name'])) {
            include_once "../cargarimagen.php";
            $foto = CargarFoto();
            if ($foto) {
                $stmtFoto = $conn->prepare("UPDATE talleres SET foto = :foto WHERE Id = :id");
                $stmtFoto->bindParam(':foto', $foto);
                $stmtFoto->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtFoto->execute();
            }
        }

        echo "<script>alert('Taller modificado correctamente');</script>";
    } else {
        echo "<script>alert('Seleccione un taller antes de modificar');</script>";
    }
}

if (isset($_POST['Limpiar'])) {
    $txtID = $txtNombre = $txtDia = $txtHorario = $txtDescripcion = $costo = $txtestado = "";
    $tallerSeleccionado = null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Talleres</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/padmin.css">
    <style>
      
    </style>
</head>
<body>

<div class="admin-container">
    <div class="admin-header">
        <h1>🏛️ Panel de Administración</h1>
        <p>Gestiona los talleres de tu biblioteca</p>
    </div>

    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($txtID) ?>">

            <div class="form-section">
                <h3>📝 Información del Taller</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre">Nombre del Taller</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" 
                               value="<?= htmlspecialchars($txtNombre) ?>" 
                               placeholder="Ingrese nombre del taller" required>
                    </div>

                    <div class="form-group">
                        <label for="dia">Día</label>
                        <input type="text" id="dia" name="dia" class="form-control" 
                               value="<?= htmlspecialchars($txtDia) ?>" 
                               placeholder="Ej: Lunes, Martes, etc.">
                    </div>

                    <div class="form-group">
                        <label for="horario">Horario</label>
                        <input type="text" id="horario" name="horario" class="form-control" 
                               value="<?= htmlspecialchars($txtHorario) ?>" 
                               placeholder="Ej: 10:00 - 12:00">
                    </div>

                    <div class="form-group">
                        <label for="costo">Costo</label>
                        <input type="text" id="costo" name="costo" class="form-control" 
                               value="<?= htmlspecialchars($costo) ?>" 
                               placeholder="Ingrese costo">
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" 
                              rows="4" placeholder="Descripción detallada del taller"><?= htmlspecialchars($txtDescripcion) ?></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>⚙️ Configuración</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control">
                            <option value="activo" <?= ($txtestado == "activo") ? "selected" : "" ?>>🟢 Activo</option>
                            <option value="inactivo" <?= ($txtestado == "inactivo") ? "selected" : "" ?>>🔴 Inactivo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">Imagen del Taller</label>
                        <input type="file" id="image" name="image" class="form-control" 
                               accept="image/*">
                        <small style="color: #666; font-size: 0.85rem;">Formatos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
                    </div>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" name="agregar" class="btn btn-success" <?= !empty($txtID) ? 'disabled' : '' ?>>
                    ➕ Agregar Taller
                </button>
                <button type="submit" name="ListarTalleres" class="btn btn-primary">
                    📋 Listar Talleres
                </button>
                <button type="submit" name="Modificar" class="btn btn-warning">
                    ✏️ Modificar
                </button>
                <button type="submit" name="Limpiar" class="btn btn-danger">
                    🗑️ Cancelar
                </button>
            </div>
        </form>
    </div>

    <?php if (!empty($resultados)) : ?>
        <div class="table-container">
            <div style="padding: 20px; background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                <h3 style="margin: 0; color: var(--color-primary);">📊 Lista de Talleres</h3>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Día</th>
                        <th>Horario</th>
                        <th>Foto</th>
                        <th>Descripción</th>
                        <th>Costo</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $taller): ?>
                        <tr>
                            <td><strong>#<?= $taller->getId() ?></strong></td>
                            <td><?= htmlspecialchars($taller->getNombre()) ?></td>
                            <td><?= htmlspecialchars($taller->getDia()) ?></td>
                            <td><?= htmlspecialchars($taller->getHorario()) ?></td>
                            <td>
                                <?php if ($taller->getFoto()): ?>
                                    <span class="badge badge-success">📷 Disponible</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">❌ Sin imagen</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $descripcion = htmlspecialchars($taller->getDescripcion());
                                    echo strlen($descripcion) > 50 ? substr($descripcion, 0, 50) . '...' : $descripcion;
                                ?>
                            </td>
                            <td><strong><?= htmlspecialchars($taller->getCosto()) ?></strong></td>
                            <td>
                                <span class="<?= $taller->getEstado() == 'activo' ? 'estado-activo' : 'estado-inactivo' ?>">
                                    <?= $taller->getEstado() == 'activo' ? '🟢 Activo' : '🔴 Inactivo' ?>
                                </span>
                            </td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $taller->getId() ?>">
                                    <button type="submit" name="BuscarTalleres" class="accion-btn">
                                        👁️ Seleccionar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

<?php include("../template/pie.php") ?>