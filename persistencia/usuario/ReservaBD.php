<?php
include_once __DIR__ . '/admin/seccion/bd.php';
class ReservaBD {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Función para agregar una nueva reserva
    public function agregarReserva($libro_id, $usuario_id) {
        $sentencia = $this->conexion->prepare("INSERT INTO reservas (libro_id, usuario_id) VALUES (:libro_id, :usuario_id)");
        $sentencia->bindParam(':libro_id', $libro_id);
        $sentencia->bindParam(':usuario_id', $usuario_id);
        $sentencia->execute();
    }
}
?>
