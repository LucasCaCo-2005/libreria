<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . "/../../logica/admin/Avisos.php";
include_once __DIR__ . "/../../persistencia/admin/AvisosBD.php";
include_once __DIR__ . "/../../logica/admin/bd.php";
include_once __DIR__ . "/../../presentacion/admin/cabecera.php";

$avisoSeleccionado = null;
$resultados = [];

// Conexión
$conn = (new conexion())->Conectar();
// Variables del formulario con null
$txtID = $_POST['id'] ?? "";
$txtTitulo = $_POST['titulo'] ?? "";
$txtContenido = $_POST['contenido'] ?? "";
$txtActivo = $_POST['activo'] ?? "";
$txtFecha_creacion = $_POST['fecha_creacion'] ?? "";

// Creación de avisos
if (isset($_POST['agregar'])) { 
    $aviso = new Avisos();
    $aviso->setTitulo($txtTitulo);
    $aviso->setContenido($txtContenido);
    $aviso->setActivo($txtActivo);
    $aviso->setFecha_creacion($txtFecha_creacion);
    $aviso->CargarAvisos(); // Guarda en base de datos
}

// Obtiene todos los Avisos
if (isset($_POST['ListarAvisos'])) {
    $aviso = new Avisos();
    $resultados = $aviso->ListarAvisos();
}

// Busca aviso por id
if (isset($_POST['BuscarAvisos'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("SELECT * FROM avisos WHERE Id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $avisoSeleccionado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($avisoSeleccionado) {
        $txtID = $avisoSeleccionado['id'];
        $txtTitulo = $avisoSeleccionado['titulo'];
        $txtContenido = $avisoSeleccionado['contenido'];
        $txtActivo = $avisoSeleccionado['activo'];
        $txtFecha_creacion = $avisoSeleccionado['fecha_creacion'];
    }
}

// Modificar Aviso
if (isset($_POST['Modificar'])) {
    $id = intval($_POST['id']);
    if ($id > 0) {
        $sql = "UPDATE avisos
                SET titulo = :titulo, contenido = :contenido, activo = :activo, fecha_creacion = :fecha_creacion
             WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':titulo', $txtTitulo);
        $stmt->bindParam(':contenido', $txtContenido);
        $stmt->bindParam(':activo', $txtActivo);
        $stmt->bindParam(':fecha_creacion', $txtFecha_creacion);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Aviso modificado correctamente');</script>";
    } else {
        echo "<script>alert('Seleccione un aviso antes de modificar');</script>";
    }
}

// Limpiar formulario
if (isset($_POST['Limpiar'])) {
    $txtID = $txtTitulo = $txtContenido = $txtActivo = $txtFecha_creacion = "";
    $avisoSeleccionado = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Avisos</title>
    <link rel="stylesheet" href="./css/Usuario/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/admin/padmin.css">
</head>
<body>

<div class="admin-container">
    <div class="admin-header">
        <h1>🏛️ Panel de Administración</h1>
        <p>Gestiona los Avisos</p>
    </div>

    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($txtID) ?>">

            <div class="form-section">
                <h3>📝 Información del Aviso</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="titulo">Titulo del Aviso</label>
                        <input type="text" id="titulo" name="titulo" class="form-control" 
                               value="<?= htmlspecialchars($txtTitulo ?? '') ?>" 
                               placeholder="Ingrese Titulo del Aviso">
                    </div>

                    <div class="form-group">
                        <label for="contenido">Contenido</label>
                        <input type="text" id="contenido" name="contenido" class="form-control" 
                               value="<?= htmlspecialchars($txtContenido ?? '') ?>" 
                               placeholder="Ingrese el contenido del aviso">
                    </div>

                    <div class="form-group">
                        <label for="activo">Activo</label>
                        <input type="text" id="activo" name="activo" class="form-control" 
                               value="<?= htmlspecialchars($txtActivo ?? '') ?>" 
                               placeholder="Ej: 1 = Activo - 0 = Desactivado">
                    </div>

                    <div class="form-group">
                        <label for="fecha_creacion">Fecha Publicación</label>
                        <?php
                        // Asegurando que $txtFecha_creacion no sea null
                        $Fecha_creacion = $txtFecha_creacion ?? ''; 
                        ?>
                        <input type="text" id="fecha_creacion" name="fecha_creacion" class="form-control"
                               value="<?= htmlspecialchars($Fecha_creacion) ?>"
                               placeholder="Ingrese fecha">
                    </div>
                </div>

            <div class="btn-group">
                <button type="submit" name="agregar" class="btn btn-success" <?= !empty($txtID) ? 'disabled' : '' ?>>
                    ➕ Agregar Aviso
                </button>
                <button type="submit" name="ListarAvisos" class="btn btn-primary">
                    📋 Listar Avisos
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
            <h3 style="margin: 0; color: var(--color-primary);">📊 Lista de Avisos</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Contenido</th>
                    <th>Activo</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $aviso): ?>
                    <tr>
                        <td><strong>#<?= $aviso->getId() ?></strong></td>
                        <td><?= htmlspecialchars($aviso->getTitulo()) ?></td>
                        <td><?= htmlspecialchars(substr($aviso->getContenido(), 0, 50)) ?>...</td>
                        <td><?= htmlspecialchars($aviso->getActivo()) ?></td>
                        <td><?= htmlspecialchars($aviso->getFecha_creacion() ?? '') ?></td>

                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $aviso->getId() ?>">
                                <button type="submit" name="BuscarAvisos" class="accion-btn">
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
