<?php include_once 'template/cabecera.php'; ?>
<?php
include_once ("seccion/bd.php");
if(isset($_GET['devolver'])){
    $idPrestamo = $_GET['devolver'];
    $sentencia = $conexion->prepare("UPDATE prestamos SET devuelto=1 WHERE id=:id");
    $sentencia->bindParam(":id", $idPrestamo);
    $sentencia->execute();
}
$sentencia = $conexion->prepare("
    SELECT p.id, l.nombre AS libro, p.persona, 
           p.prestamo, p.devolucion, p.devuelto
    FROM prestamos p
    INNER JOIN libros l ON p.libro_id = l.id
    ORDER BY p.prestamo DESC
");
$sentencia->execute();
$prestamos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Préstamos</title>
    <style>
        table { width: 90%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Listado de Préstamos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Libro</th>
            <th>Persona</th>
            <th>Fecha Préstamo</th>
            <th>Fecha Devolución</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach($prestamos as $p){ ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><?php echo $p['libro']; ?></td>
            <td><?php echo $p['persona']; ?></td>
            <td><?php echo $p['prestamo']; ?></td>
            <td><?php echo $p['devolucion']; ?></td>
            <td><?php echo $p['devuelto'] ? 'Devuelto' : 'Prestado'; ?></td>
            <td>
                <?php if(!$p['devuelto']){ ?>
                    <a href="prest.php?devolver=<?php echo $p['id']; ?>" 
                       onclick="return confirm('¿Marcar como devuelto?')">Devolver</a>
                <?php } else { ?>
                    -----
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php include_once 'template/pie.php'; ?>
