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


    // Rellenar variables para mostrar en el formulario
    if ($tallerSeleccionado) {
        $txtID          = $tallerSeleccionado['Id'];
        $txtNombre      = $tallerSeleccionado['nombre'];
        $txtDia         = $tallerSeleccionado['dia'];
        $txtHorario     = $tallerSeleccionado['horario'];
        $txtDescripcion = $tallerSeleccionado['descripcion'];
        $costo          = $tallerSeleccionado['costo'];
        $txtestado      = $tallerSeleccionado['estado'];
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
    <title>Panel de administración</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

    <form action="" method="post" enctype="multipart/form-data">

        <input type="hidden"   required readonly  name="id" value="<?= htmlspecialchars($txtID) ?>">

        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($txtNombre) ?>" placeholder="Ingrese nombre">
        </div>

        <div>
            <label>Día</label>
            <input type="text" name="dia" value="<?= htmlspecialchars($txtDia) ?>" placeholder="Ingrese día">
        </div>

        <div>
            <label>Horario</label>
            <input type="text" name="horario" value="<?= htmlspecialchars($txtHorario) ?>" placeholder="Ingrese horario">
        </div>

         <div>
            <label for="costo">Costo</label>
            <input type="text" name="costo" id="costo" value="<?php echo htmlspecialchars($costo); ?>" placeholder="Ingrese costo">
        </div>
        <div>
            <label>Descripción</label>
            <textarea name="descripcion" rows="3" placeholder="Descripción del taller"><?= htmlspecialchars($txtDescripcion) ?></textarea>
        </div>
        <div>
            <label>Estado</label>
            <select name="estado">
                <option value="activo"   <?= ($txtestado == "activo") ? "selected" : "" ?>>Activo</option>
                <option value="inactivo" <?= ($txtestado == "inactivo") ? "selected" : "" ?>>Inactivo</option>
            </select>
        </div>
        <div>
            <label>Foto</label>
            <input type="file" name="image">
        </div>
        <div>
           <input type="submit" name="agregar" value="Agregar" <?= !empty($txtID) ? 'disabled' : '' ?>>
            <input type="submit" name="ListarTalleres" value="Listar Talleres">
            <input type="submit" name="Modificar" value="Modificar">
           <input type="submit" name="Limpiar" value="Cancelar">

        </div>
    </form>

    <?php if (!empty($resultados)) : ?>
        <table border="1">
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Día</th>
                <th>Horario</th>
                <th>Foto</th>
                <th>Descripción</th>
                <th>Costo</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>

        <br>    <div>

            
            <?php foreach ($resultados as $taller): ?> <br>
                <tr>
                    <td><?= $taller->getId() ?></td>
                    <td><?= htmlspecialchars($taller->getNombre()) ?></td>
                    <td><?= htmlspecialchars($taller->getDia()) ?></td>
                    <td><?= htmlspecialchars($taller->getHorario()) ?></td>
                    <td><?= htmlspecialchars($taller->getFoto()) ?></td>
                 <td>
    <?php 
        $descripcion = htmlspecialchars($taller->getDescripcion());
        echo strlen($descripcion) > 50 ? substr($descripcion, 0, 50) . '...' : $descripcion;
    ?>
</td>
                    <td><?= htmlspecialchars($taller->getCosto()) ?></td>
                    <td><?= htmlspecialchars ($taller->getEstado()) ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $taller->getId() ?>">
                            <input type="submit" name="BuscarTalleres" value="Seleccionar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

</body>
</html>

<?php  include("../template/pie.php") ?>
