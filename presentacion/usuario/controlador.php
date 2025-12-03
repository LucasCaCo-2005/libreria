<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../Logica/Admin/bd.php';
include_once __DIR__ . '/../../Logica/Usuario/reservaLogic.php';

$reservaLógica = new ReservaLogic($conexion);

// Verificar que el usuario esté logueado usando la variable correcta
if (!isset($_SESSION['usuario']['id'])) {
    $_SESSION['return_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php?error=Debes iniciar sesión para reservar libros");
    exit();
}

$usuarioId = $_SESSION['usuario']['id'];
$accion = $_GET['accion'] ?? $_POST['accion'] ?? '';

error_log("Usuario ID: $usuarioId, Acción: $accion");

switch ($accion) {
    case 'agregar':
        $idLibro = $_GET['id'] ?? null;
        if (!$idLibro) {
            header("Location: productos.php?error=Libro no especificado");
            exit();
        }
        
        $resultado = $reservaLógica->agregarAlCarrito($idLibro, $usuarioId);
        header("Location: mas.php?id=$idLibro&" . ($resultado['success'] ? 'success' : 'error') . "=" . urlencode($resultado['message']));
        exit();
        
    case 'eliminar':
        $idLibro = $_GET['id'] ?? null;
        if ($idLibro && $reservaLógica->eliminarDelCarrito($idLibro)) {
            header("Location: ver_carrito.php?success=Libro eliminado del carrito");
        } else {
            header("Location: ver_carrito.php?error=Error al eliminar el libro");
        }
        exit();
        
    case 'vaciar':
        if ($reservaLógica->vaciarCarrito()) {
            header("Location: ver_carrito.php?success=Carrito vaciado");
        } else {
            header("Location: ver_carrito.php?error=Error al vaciar el carrito");
        }
        exit();
        
    case 'confirmar':
        error_log("Procesando confirmación para usuario: $usuarioId");
        $resultado = $reservaLógica->confirmarReserva($usuarioId);
        
        if ($resultado['success']) {
            $_SESSION['reserva_confirmada'] = $resultado['data'];
            error_log("Reserva confirmada, redirigiendo a resconf.php");
            header("Location: resconf.php");
        } else {
            error_log("Error en reserva: " . $resultado['message']);
            header("Location: ver_carrito.php?error=" . urlencode($resultado['message']));
        }
        exit();
        
    default:
        error_log("Acción no reconocida: $accion, redirigiendo a productos");
        header("Location: productos.php");
        exit();
}
?>