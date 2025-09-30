    $estados_validos = ['disponible', 'reservado', 'adoptado'];
    if (!in_array($estado, $estados_validos)) {
        die("Estado no válido.");
    }
    $sentencia = $conexion->prepare("INSERT INTO libros (nombre, precio, categoria) VALUES (:nombre, :precio, :categoria)");
    $sentencia->bindParam(':nombre', $nombre);


    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === '¡Libro agregado exitosamente!'): ?>
    <div class="danger" role="alert">
        <strong></strong>
    </div>
<?php endif; ?>

<div class="alert alert-success strong" role="alert">
    <?php if (isset($_GET['mensaje'])) {
        echo $_GET['mensaje'];
    } ?>

