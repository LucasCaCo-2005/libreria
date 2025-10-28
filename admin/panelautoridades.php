<?php
include_once __DIR__ . "/../admin/seccion/bd.php";

include_once __DIR__ . "/seccion/autoridades.php";


$autoridadesSeleccionado = null;
$resultados = [];

// Conexión con la base de datos
$conn = (new Conexion())->Conectar();

// Variables del formulario
$txtID           = $_POST['id'] ?? "";
$txtCedula       = $_POST['cedula'] ?? "";
$txtNombre       = $_POST['nombre'] ?? "";
$txtCargo        = $_POST['cargo'] ?? "";
$txtFecha_inicio = $_POST['fecha_inicio'] ?? "";
$txtFecha_fin    = $_POST['fecha_fin'] ?? "";
$txtestado       = $_POST['estado'] ?? "";

if (isset($_POST['ListarAutoridades'])) {
    $autoridad = new Autoridades();
    $resultados = $autoridad->ListarAutoridades();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administración</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<?php
include_once "template/cabecera.php";
?>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden"   required readonly  name="id" value="<?= htmlspecialchars($txtID) ?>">

<div>
    <label>Cedula</label>
    <input type="text" name="cedula" value="<?= htmlspecialchars($txtCedula ?? '') ?>" placeholder="Ingrese cedula">
</div>

<div>
    <label>Nombre</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($txtNombre ?? '') ?>" placeholder="Ingrese Nombre">
</div>


<div>
    <label>Cargo</label>
    <input type="text" name="cargo" value="<?= htmlspecialchars($txtCargo ?? '') ?>" placeholder="Ingrese Cargo">
</div>

<div>
    <label>Inicio</label>
    <input type="date" name="fecha_inicio" value="<?= htmlspecialchars($txtFecha_inicio ?? '') ?>" placeholder="Ingrese Fecha Inicio">
</div>

<div>
    <label>Fin</label>
    <input type="date" name="fecha_fin" value="<?= htmlspecialchars($txtFecha_fin ?? '') ?>" placeholder="Ingrese Fecha Fin">
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
            <input type="submit" name="ListarAutoridades" value="Listar Autoridades">
            <input type="submit" name="Modificar" value="Modificar">
           <input type="submit" name="Limpiar" value="Cancelar">

        </div>
    </form>

    <?php if (!empty($resultados)) : ?>
        <table border="1">
            <tr>
                <th>Id</th>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Foto</th>
                <th>Estado</th>
                </tr>

        <br>    <div>

            
            <?php foreach ($resultados as $autoridad): ?> <br>
                <tr>
                    <td><?= $autoridad->getId() ?></td>
                    <td><?= htmlspecialchars($autoridad->getCedula()) ?></td>
                    <td><?= htmlspecialchars($autoridad->getNombre()) ?></td>
                    <td><?= htmlspecialchars($autoridad->getCargo()) ?></td>
                    <td><?= htmlspecialchars($autoridad->getFecha_inicio()) ?></td>
                    <td><?= htmlspecialchars($autoridad->getFecha_fin()) ?></td>
                  
                    <td>
    <?php if (!empty($autoridad->getFoto())): ?>
        <img src="/sitioweb/images/<?= htmlspecialchars($autoridad->getFoto()) ?>" 
             alt="Foto de <?= htmlspecialchars($autoridad->getCargo()) ?>" 
             width="80" height="80">
    <?php else: ?>
        Sin foto
    <?php endif; ?>
    
</td>
  <td>          
    <?php 
        $estado = htmlspecialchars($autoridad->getEstado());
        echo strlen($estado) > 50 ? substr($estado, 0, 50) . '...' : $estado;
    ?>
</td>
                             <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $autoridad->getId() ?>">
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
