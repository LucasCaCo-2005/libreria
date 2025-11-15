<?php
include_once __DIR__ . '/admin/seccion/bd.php';
header('Content-Type: application/json');
// Suponiendo que ya tienes la conexión con la base de datos
include_once 'conexion.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Obtener los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['nombre'])) {
    // Aquí se insertaría el libro en el carrito, por ejemplo
    $id_libro = $data['id'];
    $nombre_libro = $data['nombre'];

    // Aquí el código para agregar el libro a la reserva (carrito)
    // Por ejemplo, puedes agregarlo a la base de datos de reservas
    $stmt = $conexion->prepare("INSERT INTO reservas (libro_id, nombre) VALUES (:id, :nombre)");
    $stmt->bindParam(':id', $id_libro);
    $stmt->bindParam(':nombre', $nombre_libro);

    if ($stmt->execute()) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'mensaje' => 'Error al agregar al carrito']);
    }
} else {
    echo json_encode(['ok' => false, 'mensaje' => 'Datos incompletos']);
}

