<?php 
include_once(__DIR__ ."/../../Logica/Admin/bd.php");
include_once 'cabecera.php';

$usuario_id = $_SESSION['socios']['id'];  // Obtener el ID del usuario desde la sesión
$sentencia = $conexion->prepare("SELECT * FROM reservas INNER JOIN libros ON reservas.libro_id = libros.id WHERE reservas.usuario_id = :usuario_id AND reservas.estado = 'en carrito'");
$sentencia->bindParam(':usuario_id', $usuario_id);
$sentencia->execute();
$reservas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Mis Reservas (Carrito)</h2>

<?php if ($reservas): ?>
    <ul>
        <?php foreach ($reservas as $reserva): ?>
            <li>
                Libro: <?php echo $reserva['nombre']; ?> |
                Autor: <?php echo $reserva['autor']; ?> |
                Estado: <?php echo $reserva['estado']; ?> |
                <a href="/../../Logica/Admin/confirmar_reserva.php?id=<?php echo $reserva['libro_id']; ?>">Confirmar</a> | 
                <a href="/../../Logica/Admin/eliminar_reserva.php?id=<?php echo $reserva['libro_id']; ?>">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No tienes libros en tu carrito.</p>
<?php endif; ?>

<?php include_once 'pie.php'; ?>
