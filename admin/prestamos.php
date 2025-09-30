<?php include_once 'template/cabecera.php'; ?>
<?php
include_once ("config/bd.php");

$libro = null;
if(isset($_GET['id'])){
    $idLibro = $_GET['id'];

    $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
    $sentencia->bindParam(":id", $idLibro);
    $sentencia->execute();
    $libro = $sentencia->fetch(PDO::FETCH_ASSOC);
}
if($_POST){
    $idLibro = $_POST['libro_id'];
    $nombrePersona = $_POST['persona'];
    $fechaPrestamo = $_POST['prestamo'];
    $fechaDevolucion = $_POST['devolucion'];
    $sentencia = $conexion->prepare("INSERT INTO prestamos (libro_id, persona, prestamo, devolucion) 
                                     VALUES (:libro_id, :persona, :prestamo, :devolucion)");
    $sentencia->bindParam(":libro_id", $idLibro);
    $sentencia->bindParam(":persona", $nombrePersona);
    $sentencia->bindParam(":prestamo", $fechaPrestamo);
    $sentencia->bindParam(":devolucion", $fechaDevolucion);
    $sentencia->execute();
    echo "<script>alert('Préstamo registrado correctamente');window.location='prest.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Préstamo</title>
</head>
<body>
    <br>
    <h2>Registrar Préstamo</h2>
    <?php if($libro){ ?>
        <br>
        <p><strong>Libro:</strong> <?php echo $libro['nombre']; ?> (<?php echo $libro['autor']; ?>)</p>
        <br>
        <form method="post">
            <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
            <label>Nombre de la persona:</label><br>
            <input type="text" name="persona" required><br><br>
            <label>Fecha de préstamo:</label><br>
            <input type="date" name="prestamo" required><br><br>
            <label>Fecha de devolución:</label><br>
            <input type="date" name="devolucion" required><br><br>
            <button type="submit">Guardar</button>
        </form>
    <?php } else { ?>
        <p>No se encontró el libro.</p>
    <?php } ?>
</body>
</html>
<?php include_once 'template/pie.php'; ?>
