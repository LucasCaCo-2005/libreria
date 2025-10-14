<?php
include_once "seccion/Talleres.php";
include_once "seccion/persona.php";
include_once "template/cabecera.php";
include_once ("seccion/bd.php");
// (aquí van tus clases Talleres y TalleresBD como te pasé antes)

// ----------------------
// PROCESAR FORMULARIOS
// ----------------------
$resultados = []; 

$txtID         = $_POST['txtID'] ?? "";
$txtNombre     = $_POST['txtNombre'] ?? "";
$txtDia        = $_POST['txtDia'] ?? "";
$txtHorario    = $_POST['txtHorario'] ?? "";
$txtDescripcion= $_POST['txtDescripcion'] ?? "";
$costo   = $_POST['costo'] ?? "";
$txtestado     = $_POST['txtestado'] ?? "";
$accion        = $_POST['accion'] ?? "";

// Agregar
if(isset($_POST['agregar'])){
    $taller = new Talleres();
    $taller->setNombre($_POST['nombre']);
    $taller->setDia($_POST['dia']);
    $taller->setHorario($_POST['horario']);
    $taller->setfoto($_FILES['image']['name']);
    include_once "../cargarimagen.php";
    $taller->setDescripcion($_POST['descripcion']);
    $taller->setCosto($_POST['costo']);
    $taller->setEstado($_POST['estado']);
  

    $foto = CargarFoto();
    if($foto != null){
        $taller->setFoto($foto);
        $taller->CargarTalleres();
    }
}

// Listar
if(isset($_POST['ListarTalleres'])) {
    $taller = new Talleres();
    $resultados = $taller->ListarTalleres();
    
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
        <input type="number" name="id" id="idAnimal" hidden>

        <div>
            <label for="nombreL">Nombre</label>
            <input type="text" name="nombre" id="nombre"  value="<?php echo htmlspecialchars($txtNombre); ?>" placeholder="Ingrese nombre">
        </div>

        <div>
            <label for="edad">Día</label>
            <input type="text" name="dia" id="dia" value="<?php echo htmlspecialchars($txtDia); ?>" placeholder="Ingrese día" >
        </div>

        <div>
            <label for="tipo">Horario</label>
            <input type="text" name="horario" id="horario" value="<?php echo htmlspecialchars($txtHorario); ?>" placeholder="Ingrese horario" >
        </div>

        <div>
            <label for="costo">Costo</label>
            <input type="text" name="costo" id="costo" value="<?php echo htmlspecialchars($costo); ?>" placeholder="Ingrese costo">
        </div>

          <div>
      <label for="exampleTextarea" class="form-label mt-4"  value="<?php echo htmlspecialchars($txtDescripcion); ?>"      >Descripcion</label>
      <textarea class="form-control" id="exampleTextarea" rows="3" style="height: 92px;" name="descripcion" id="descripcion"  placeholder="Descripcion del libro"  ></textarea>
    </div>

            <div>
                <label for="estado">Estado</label>
                <select name="estado" id="estado">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
    <div> 
         <div>
            <label> Foto</label>
            <input type="file" name="image">
        </div>

        <div>

                        <input type="submit" name="agregar" value="Agregar">
            <input type="submit" name="ListarTalleres" value="Listar Talleres">
            <input type="submit" name="Modificar" value="Modificar">

        </div>
    </form>

    <?php if (!empty($resultados)) : ?>
        <table border="1">
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Día</th>
                <th>Horario</th>
                <th>Foto</th>´
                <th>Descripción</th>
                <th>Costo</th>
                <th>Estado</th>
                <th>Accion</th>
               
            </tr>
            <?php foreach ($resultados as $taller): ?>
                <tr>
                    <td><?= $taller->getId() ?></td>
                    <td><?= $taller->getNombre() ?></td>
                    <td><?= $taller->getDia() ?></td>
                    <td><?= $taller->getHorario() ?></td>
                    <td><?= $taller->getFoto() ?></td>
                    <td><?= $taller->getDescripcion() ?></td>
                    <td><?= $taller->getCosto() ?></td>
                    <td><?= $taller->getEstado() ?></td>
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

</body>
</html>
