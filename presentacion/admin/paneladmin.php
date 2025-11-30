<?php
include_once __DIR__ ."/../../Logica/Admin/Talleres.php";
include_once "cabecera.php";
include_once __DIR__ ."/../../Logica/Admin/bd.php";
$tallerSeleccionado = null;
$resultados = [];

// Conexión
$conn = (new conexion())->Conectar();

$stmt = $conn->query("SELECT DATABASE()");
echo "<p>📦 Base de datos actual: " . $stmt->fetchColumn() . "</p>";

// Variables del formulario con null 
$txtID          = $_POST['id'] ?? "";
$txtNombre      = $_POST['nombre'] ?? "";
$txtDia         = $_POST['dia'] ?? "";
$txtHorario     = $_POST['horario'] ?? "";
$txtDescripcion = $_POST['descripcion'] ?? "";
$costo          = $_POST['costo'] ?? "";
$txtestado      = $_POST['estado'] ?? "";
$accion         = $_POST['accion'] ?? "";
$filtro_estado  = $_POST['filtro_estado'] ?? "activo";

// Eliminar imagen del taller
if (isset($_POST['eliminar_imagen'])) {
    $id = intval($_POST['id']);
    if ($id > 0) {
        // Obtener información de la imagen actual
        $stmt = $conn->prepare("SELECT foto FROM talleres WHERE Id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $taller = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($taller && !empty($taller['foto'])) {
            // Eliminar archivo físico si existe
            $ruta_imagen = __DIR__ . "/../../imagenes/" . $taller['foto'];
            if (file_exists($ruta_imagen)) {
                unlink($ruta_imagen);
            }
            
            // Actualizar base de datos
            $stmtUpdate = $conn->prepare("UPDATE talleres SET foto = NULL WHERE Id = :id");
            $stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtUpdate->execute();
            
            echo "<script>alert('Imagen eliminada correctamente');</script>";
            
            // Recargar datos del taller si estamos editando
            if ($txtID == $id) {
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
        }
    }
}

// Cargar datos del taller si se viene desde "Ir a Editar"
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
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

// creacion de talleres
if (isset($_POST['agregar'])) { // crear instancia
    $taller = new Talleres(); // setters para propiedades
    $taller->setNombre($txtNombre);
    $taller->setDia($txtDia);
    $taller->setHorario($txtHorario);
    $taller->setDescripcion($txtDescripcion);
    $taller->setCosto($costo);
    $taller->setEstado($txtestado ?: "activo");

    // Subir imagen si se seleccionó
    if (!empty($_FILES['image']['name'])) {
        include_once "cargarimagen.php";
        $foto = CargarFoto();
        if ($foto) {
            $taller->setFoto($foto);
        }
    }

    $taller->CargarTalleres(); // guarda en base de datos
}

//obtiene talleres según filtro
if (isset($_POST['ListarTalleres'])) {
    $taller = new Talleres();
    if ($filtro_estado == "todos") {
        $resultados = $taller->ListarTalleres();
    } else {
        $resultados = array_filter($taller->ListarTalleres(), function($t) use ($filtro_estado) {
            return $t->getEstado() == $filtro_estado;
        });
    }
}

// Busca taller por id
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
            include_once "cargarimagen.php";
            $foto = CargarFoto();
            if ($foto) {
                $stmtFoto = $conn->prepare("UPDATE talleres SET foto = :foto WHERE Id = :id");
                $stmtFoto->bindParam(':foto', $foto);
                $stmtFoto->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtFoto->execute();
            }
        }

        echo "<script>alert('Taller modificado correctamente');</script>";
        // Limpiar formulario después de modificar
        $txtID = $txtNombre = $txtDia = $txtHorario = $txtDescripcion = $costo = $txtestado = "";
    } else {
        echo "<script>alert('Seleccione un taller antes de modificar');</script>";
    }
}

// limpia formulario 
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
    <link rel="stylesheet" href="./css/Usuario/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/admin/padmin.css">
    <style>
        .filtro-container {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }
        
        .filtro-form {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filtro-select {
            min-width: 150px;
        }
        
        .imagen-info {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 0.9rem;
        }
        
        .btn-eliminar-imagen {
            background: #dc3545;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-top: 5px;
            cursor: pointer;
        }
        
        .btn-eliminar-imagen:hover {
            background: #c82333;
        }
        
        .imagen-actual {
            margin-top: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            border: 1px dashed #dee2e6;
        }
        
        .estado-activo {
            color: #28a745;
            font-weight: bold;
        }
        
        .estado-inactivo {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="admin-container">
    <div class="admin-header">
        <h1>🏛️ Panel de Administración</h1>
        <p>Gestiona los talleres de tu biblioteca</p>
        <?php if (!empty($txtID)): ?>
            <div class="alert alert-info" style="margin-top: 15px;">
                <strong>📝 Editando:</strong> Taller #<?= $txtID ?> - <?= htmlspecialchars($txtNombre) ?>
            </div>
        <?php endif; ?>
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
                               placeholder="Ingrese nombre del taller" >
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
                        
                        <?php if (!empty($txtID)): ?>
                            <?php
                            // Obtener información de la imagen actual
                            $stmt = $conn->prepare("SELECT foto FROM talleres WHERE Id = :id");
                            $stmt->bindParam(':id', $txtID, PDO::PARAM_INT);
                            $stmt->execute();
                            $imagen_actual = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            
                            <?php if (!empty($imagen_actual['foto'])): ?>
                                <div class="imagen-actual">
                                    <strong>Imagen actual:</strong> <?= htmlspecialchars($imagen_actual['foto']) ?>
                                    <form method="post" style="display: inline; margin-left: 10px;">
                                        <input type="hidden" name="id" value="<?= $txtID ?>">
                                        <button type="submit" name="eliminar_imagen" class="btn-eliminar-imagen" 
                                                onclick="return confirm('¿Está seguro de que desea eliminar la imagen actual?')">
                                            🗑️ Eliminar imagen
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="imagen-info">
                                    ℹ️ No hay imagen actual para este taller
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" name="agregar" class="btn btn-success" <?= !empty($txtID) ? 'disabled' : '' ?>>
                    ➕ Agregar Taller
                </button>
                <button type="submit" name="Modificar" class="btn btn-warning" <?= empty($txtID) ? 'disabled' : '' ?>>
                    ✏️ Modificar
                </button>
                <button type="submit" name="Limpiar" class="btn btn-danger">
                    🗑️ Cancelar
                </button>
            </div>
        </form>
    </div>

    <!-- Filtro de talleres -->
    <div class="filtro-container">
        <form method="post" class="filtro-form">
            <div class="form-group mb-0">
                <label for="filtro_estado" class="form-label"><strong>Filtrar por estado:</strong></label>
                <select id="filtro_estado" name="filtro_estado" class="form-select filtro-select">
                    <option value="activo" <?= $filtro_estado == "activo" ? "selected" : "" ?>>🟢 Talleres Activos</option>
                    <option value="inactivo" <?= $filtro_estado == "inactivo" ? "selected" : "" ?>>🔴 Talleres Inactivos</option>
                </select>
            </div>
            <button type="submit" name="ListarTalleres" class="btn btn-primary">
                📋 Listar Talleres
            </button>
        </form>
    </div>

    <?php if (!empty($resultados)) : ?>
        <div class="table-container">
            <div style="padding: 20px; background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                <h3 style="margin: 0; color: var(--color-primary);">
                    📊 Lista de Talleres 
                    <span style="font-size: 0.9rem; color: #666;">
                        (<?= $filtro_estado == 'activo' ? 'Activos' : 'Inactivos' ?>)
                    </span>
                </h3>
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

<?php include("pie.php") ?>