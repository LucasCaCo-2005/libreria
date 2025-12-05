<?php
//session_start();
header('Content-Type: application/json');
include_once("../logica/Reserva.php");
include_once __DIR__ . '/admin/seccion/bd.php';

if (isset($_GET['id'])) {
    $libroId = $_GET['id'];
    $usuarioId = $_SESSION['socios']['id'];

    // Cambiar el estado de la reserva a "pendiente"
    $stmt = $conexion->prepare("UPDATE reservas SET estado = 'pendiente' WHERE usuario_id = :usuario_id AND libro_id = :libro_id AND estado = 'en carrito'");
    $stmt->bindValue(':usuario_id', $usuarioId);
    $stmt->bindValue(':libro_id', $libroId);

    if ($stmt->execute()) {
        echo "<h2>Reserva confirmada con éxito.</h2>";
    } else {
        echo "<h2>Hubo un error al confirmar la reserva.</h2>";
    }
}
?>










if (!isset($_SESSION['usuario'])) {
    echo json_encode(['ok' => false, 'mensaje' => 'No estás logueado']);
    exit;
}

if (!isset($_SESSION['reservas']) || empty($_SESSION['reservas'])) {
    echo json_encode(['ok' => false, 'mensaje' => 'No hay reservas en el carrito']);
    exit;
}

$ci = $_SESSION['usuario']->getCi();
$errores = 0;

foreach ($_SESSION['reservas'] as $reserva) {
    if (!isset($reserva['id'], $reserva['prestamo'], $reserva['devolucion'])) {
        $errores++;
        continue;
    }

    $r = new Reserva();
    $r->setCi($ci);
    $r->setLibro_id($reserva['libro_id']);
    $r->setPrestamo($reserva['prestamo']);
    $r->setDevolucion($reserva['devolucion']);
    $r->setTipo("reserva");

    if (!$r->Reservar()) {
        $errores++;
    }
}

if ($errores === 0) {
    unset($_SESSION['reservas']); // Vaciar carrito
    echo json_encode(['ok' => true, 'mensaje' => 'Reservas confirmadas con éxito']);
} else {
    echo json_encode(['ok' => false, 'mensaje' => "Algunas reservas fallaron ($errores errores)"]);
}
