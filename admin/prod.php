<?php
include_once("template/cabecera.php");
include_once("seccion/bd.php");

echo "<!-- DEBUG: Script iniciado -->";

// Procesar acciones del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<!-- DEBUG: Método POST -->";
    
    $accion = $_POST['accion'] ?? "";
    $txtID = $_POST['txtID'] ?? "";
    
    echo "<!-- DEBUG: Acción: " . $accion . " -->";
    echo "<!-- DEBUG: ID recibido: " . $txtID . " -->";

    if ($accion === 'Seleccionar' && !empty($txtID)) {
        echo "<!-- DEBUG: Intentando seleccionar libro ID: " . $txtID . " -->";
        
        // Verificar conexión
        if (!$conexion) {
            echo "<!-- DEBUG: Error - No hay conexión a la BD -->";
        } else {
            echo "<!-- DEBUG: Conexión a BD OK -->";
        }
        
        try {
            // Primero veamos si la tabla existe y tiene datos
            $checkTable = $conexion->query("SELECT COUNT(*) as total FROM libros");
            $totalLibros = $checkTable->fetch(PDO::FETCH_ASSOC);
            echo "<!-- DEBUG: Total libros en BD: " . $totalLibros['total'] . " -->";
            
            // Ahora busquemos el libro específico
            $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id = :id");
            $sentencia->bindParam(':id', $txtID);
            $sentencia->execute();
            
            echo "<!-- DEBUG: Query ejecutada -->";
            
            $libro = $sentencia->fetch(PDO::FETCH_ASSOC);
            
            if ($libro) {
                echo "<!-- DEBUG: Libro encontrado -->";
                echo "<!-- DEBUG: Datos del libro: " . print_r($libro, true) . " -->";
                
                // Mostrar cada campo individualmente
                foreach ($libro as $campo => $valor) {
                    echo "<!-- DEBUG: Campo '$campo' = '$valor' -->";
                }
                
                $_SESSION['libroSeleccionado'] = $libro;
                echo "<!-- DEBUG: Sesión guardada -->";
                header("Location: libros_debug_detallado.php?debug=seleccionado&id=" . $txtID);
                exit();
            } else {
                echo "<!-- DEBUG: Libro NO encontrado con ID: " . $txtID . " -->";
                
                // Ver qué IDs existen
                $allIds = $conexion->query("SELECT id FROM libros")->fetchAll(PDO::FETCH_COLUMN);
                echo "<!-- DEBUG: IDs existentes: " . implode(', ', $allIds) . " -->";
            }
        } catch (PDOException $e) {
            echo "<!-- DEBUG: Error PDO: " . $e->getMessage() . " -->";
        }
    }
}

// Variables iniciales
$txtID = $txtNombre = $txtIMG = $txtfecha = $txtAutor = $txtStock = $txtDesc = $txtCat = "";

// Si hay libro seleccionado en sesión, cargar los datos
if (isset($_SESSION['libroSeleccionado'])) {
    echo "<!-- DEBUG: Cargando datos de sesión -->";
    $libro = $_SESSION['libroSeleccionado'];
    
    $txtID = $libro['id'] ?? "";
    $txtNombre = $libro['nombre'] ?? "";
    $txtIMG = $libro['imagen'] ?? "";
    $txtfecha = $libro['fecha'] ?? "";
    $txtAutor = $libro['autor'] ?? "";
    $txtStock = $libro['stock'] ?? "";
    $txtDesc = $libro['descripcion'] ?? "";
    $txtCat = $libro['categoria'] ?? "";
    
    echo "<!-- DEBUG: Datos cargados - ID: $txtID, Nombre: $txtNombre, Autor: $txtAutor -->";
    
    // Limpiar sesión después de usar
    unset($_SESSION['libroSeleccionado']);
}

// Obtener lista de libros
$listaLibros = $conexion->query("SELECT id, nombre, autor FROM libros LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
echo "<!-- DEBUG: Lista de libros obtenida -->";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Detallado</title>
    <style>
        .debug-info { background: #f0f0f0; padding: 10px; margin: 10px 0; border-left: 4px solid #007bff; }
        .current-data { background: #e8f5e8; padding: 10px; margin: 10px 0; border-left: 4px solid #28a745; }
        .form-group { margin-bottom: 15px; }
        .form-control { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-primary { background: #007bff; color: white; }
        .btn-info { background: #17a2b8; color: white; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background: #f8f9fa; }
    </style>
</head>
<body>
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">

<div class="debug-info">
    <h3>🔍 INFORMACIÓN DE DEBUG</h3>
    <p>ID actual: <strong><?= $txtID ?></strong></p>
    <p>Nombre actual: <strong><?= $txtNombre ?></strong></p>
    <p>Autor actual: <strong><?= $txtAutor ?></strong></p>
</div>

<?php if (isset($_GET['debug'])): ?>
<div class="current-data">
    <h3>📋 DATOS ACTUALES EN FORMULARIO</h3>
    <p>Después de seleccionar libro ID: <?= $_GET['id'] ?? '' ?></p>
</div>
<?php endif; ?>

<h2>Formulario de Libros</h2>
<form method="POST">
    <input type="hidden" name="txtID" value="<?= $txtID ?>">
    
    <div class="form-group">
        <label>Nombre:</label>
        <input type="text" name="txtNombre" value="<?= $txtNombre ?>" class="form-control">
        <small>Valor actual: "<?= $txtNombre ?>"</small>
    </div>
    
    <div class="form-group">
        <label>Autor:</label>
        <input type="text" name="txtAutor" value="<?= $txtAutor ?>" class="form-control">
        <small>Valor actual: "<?= $txtAutor ?>"</small>
    </div>
    
    <div class="form-group">
        <label>Fecha:</label>
        <input type="text" name="txtfecha" value="<?= $txtfecha ?>" class="form-control">
        <small>Valor actual: "<?= $txtfecha ?>"</small>
    </div>
    
    <button type="submit" name="accion" value="Seleccionar" class="btn btn-primary">Seleccionar (Debug)</button>
</form>

<hr>

<h3>Libros existentes (primeros 5)</h3>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Autor</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listaLibros as $libro): ?>
        <tr>
            <td><?= $libro['id'] ?></td>
            <td><?= $libro['nombre'] ?></td>
            <td><?= $libro['autor'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="txtID" value="<?= $libro['id'] ?>">
                    <button type="submit" name="accion" value="Seleccionar" class="btn btn-info">Seleccionar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>
</body>
</html>
<?php include("template/pie.php"); ?>