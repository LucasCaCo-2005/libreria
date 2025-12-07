<?php

include_once '../../persistencia/admin/bd.php'; 
include_once 'cabecera.php'; // conexión


// Obtengo la Id del Socio logueado
if (!isset($_SESSION['usuario']['id'])) {
    echo "<h2>Debes iniciar sesión para inscribirte.</h2>";
    exit;
}

$socio_id = $_SESSION['usuario']['id'];



// Validar que viene un taller por GET
if (!isset($_GET['id'])) {
    echo "<h2>Error: Taller no especificado.</h2>";
    exit;
}

$taller_id = $_GET['id'];

//  Verifico si el socio ya está inscrito en ese Taller
$sentencia = $conexion->prepare("
    SELECT id FROM inscTalleres
    WHERE socio_id = :socio_id AND taller_id = :taller_id
");
$sentencia->execute([
    ":socio_id" => $socio_id,
    ":taller_id" => $taller_id
]);

if ($sentencia->fetch()) {
    echo "<h2>Ya estás inscrito en este taller.</h2>
          <a href='talleres.php'>Volver</a>";
    exit;
}

// Inserto los datos de la inscripción en la Bd
$insert = $conexion->prepare("
    INSERT INTO inscTalleres (socio_id, taller_id)
    VALUES (:socio_id, :taller_id)
");

if ($insert->execute([
    ":socio_id" => $socio_id,
    ":taller_id" => $taller_id
])) {

    echo "
    <h2> Inscripción realizada con éxito, te esperamos</h2>
    <a href='talleres.php?id=$taller_id'>Volver a Talleres</a>
    ";
} else {
    echo "<h2>Error al inscribirse</h2>";
}
?>
