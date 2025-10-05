<?php
include_once "seccion/Talleres.php";
include_once "seccion/persona.php";
include_once "template/cabecera.php";
include_once ("../admin/config/bd.php");
// (aquí van tus clases Talleres y TalleresBD como te pasé antes)

// ----------------------
// PROCESAR FORMULARIOS
// ----------------------
$resultados = []; // para guardar lista o búsqueda

// Agregar
if(isset($_POST['agregar'])){
    $taller = new Talleres();
    $taller->setNombre($_POST['nombre']);
    $taller->setDia($_POST['dia']);
    $taller->setHorario($_POST['horario']);
    $taller->setfoto($_FILES['image']['name']);
    include_once "../cargarimagen.php";
    $taller->setDescripcion($_POST['descripcion']);
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

// Buscar
if (isset($_POST['BuscarTalleres'])) {
    $taller = new Talleres();
    if (!empty($_POST["id"])) $taller->setId($_POST["id"]);
    if (!empty($_POST["nombre"])) $taller->setNombre($_POST["nombre"]);
    if (!empty($_POST["dia"])) $taller->setDia($_POST["dia"]);
    if (!empty($_POST["horario"])) $taller->setHorario($_POST["horario"]);
    if (!empty($_POST["foto"])) $taller->setFoto($_POST["foto"]);
    if (!empty($_POST["descripcion"])) $taller->setDescripcion($_POST["descripcion"]);
    if (!empty($_POST["estado"])) $taller->setEstado($_POST["estado"]);
    
    $resultados = $taller->BuscarTalleres();
}

// Cambiar
if(isset($_POST['Cambiar'])){
    $taller = new Talleres();
    $taller->setId($_POST['id']);
    $taller->setNombre($_POST['nombre']);
    $taller->setDia($_POST['dia']);
    $taller->setHorario($_POST['horario']);
    $taller->setDescripcion($_POST['descripcion']);
    $taller->setEstado($_POST['estado']);
    
    $taller->CambiarTalleres();
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
            <input type="text" name="nombre" id="nombre">
        </div>

        <div>
            <label for="edad">Día</label>
            <input type="text" name="dia" id="dia">
        </div>

        <div>
            <label for="tipo">Horario</label>
            <input type="text" name="horario" id="horario">
        </div>

          <div>
      <label for="exampleTextarea" class="form-label mt-4">Descripcion</label>
      <textarea class="form-control" id="exampleTextarea" rows="3" style="height: 92px;" name="descripcion" id="descripcion"></textarea>
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
            <input type="submit" name="BuscarTalleres" value="Buscar Talleres">
            <input type="submit" name="Cambiar" value="Cambiar">





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
                <th>Estado</th>
               
            </tr>
            <?php foreach ($resultados as $taller): ?>
                <tr>
                    <td><?= $taller->getId() ?></td>
                    <td><?= $taller->getNombre() ?></td>
                    <td><?= $taller->getDia() ?></td>
                    <td><?= $taller->getHorario() ?></td>
                    <td><?= $taller->getFoto() ?></td>
                    <td><?= $taller->getDescripcion() ?></td>
                    <td><?= $taller->getEstado() ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>
</html>
