<?php
include_once __DIR__ . '/admin/seccion/bd.php';

if (isset($_GET['id'])) {
    $libroId = $_GET['id'];
    $usuarioId = $_SESSION['socios']['id'];

    // Eliminar la reserva del carrito
    $stmt = $conexion->prepare("DELETE FROM reservas WHERE usuario_id = :usuario_id AND libro_id = :libro_id AND estado = 'en carrito'");
    $stmt->bindValue(':usuario_id', $usuarioId);
    $stmt->bindValue(':libro_id', $libroId);

    if ($stmt->execute()) {
        echo "<h2>El libro ha sido eliminado del carrito.</h2>";
    } else {
        echo "<h2>Hubo un error al eliminar el libro del carrito.</h2>";
    }
}
?>
