<?php
include_once __DIR__ . '/../../logica/admin/bd.php';
include_once 'cabecera.php';

$libro = null;
if (isset($_GET['id'])) {
    $idLibro = $_GET['id'];
    // Obtener los detalles del libro desde la base de datos
    $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id = :id");
    $sentencia->bindParam(":id", $idLibro);
    $sentencia->execute();
    $libro = $sentencia->fetch(PDO::FETCH_ASSOC);
    
    if (!$libro) {
        echo "El libro no existe o no se pudo obtener.";
        exit();
    }
} else {
    echo "Error: El ID del libro no se ha pasado correctamente en la URL.";
    exit();
}

// Procesar la acción de reserva
if (isset($_GET['accion']) && $_GET['accion'] == 'reserva') {
    // Verificar si el libro y el usuario están disponibles
    if (!$libro) {
        echo "No se encontró el libro.";
        exit();
    }

    // Obtenemos el ID del usuario de la sesión
    $usuarioId = $_SESSION['socios']['id']; // Asegúrate de que 'socios' tenga 'id'

// Verificamos si el libro ya está en el carrito
$stmt = $conexion->prepare("SELECT * FROM reservas WHERE usuario_id = :usuario_id AND libro_id = :libro_id AND estado = :estado");
$stmt->bindValue(':usuario_id', $usuarioId);
$stmt->bindValue(':libro_id', $libro['id']);
$stmt->bindValue(':estado', 'en carrito'); // Ahora 'en carrito' es un parámetro vinculado
$stmt->execute();
$existeReserva = $stmt->fetch(PDO::FETCH_ASSOC);
    // Si el libro no está en el carrito, lo agregamos
    if (!$existeReserva) {
// Insertar el libro en el carrito de reservas
$stmt = $conexion->prepare("INSERT INTO reservas (libro_id, usuario_id, fecha_reserva, estado) VALUES (:libro_id, :usuario_id, :fecha_reserva, :estado)");
$stmt->bindValue(':libro_id', $libro['id']);
$stmt->bindValue(':usuario_id', $usuarioId);
$stmt->bindValue(':fecha_reserva', date('Y-m-d H:i:s')); // Fecha actual
$stmt->bindValue(':estado', 'en carrito');

if ($stmt->execute()) {
    echo "<h2>El libro ha sido agregado al carrito de reservas: " . $libro['nombre'] . "</h2>";
} else {
    echo "<h2>Hubo un error al agregar el libro al carrito.</h2>";
}
    }
}
?>

