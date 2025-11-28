<?php
// Logica/Usuario/misReservasLogic.php

class MisReservasLogic {
    private $conexion;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    
    public function obtenerReservasUsuario($usuarioId) {
        $sentencia = $this->conexion->prepare(
            "SELECT r.*, l.nombre, l.autor, l.imagen, l.descripcion, l.categoria
             FROM reservas r 
             INNER JOIN libros l ON r.libro_id = l.id 
             WHERE r.usuario_id = :usuario_id 
             ORDER BY r.fecha_reserva DESC"
        );
        $sentencia->bindParam(':usuario_id', $usuarioId);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerReservasActivas($usuarioId) {
        $sentencia = $this->conexion->prepare(
            "SELECT r.*, l.nombre, l.autor, l.imagen, l.descripcion, l.categoria
             FROM reservas r 
             INNER JOIN libros l ON r.libro_id = l.id 
             WHERE r.usuario_id = :usuario_id 
             AND r.estado = 'pendiente'
             AND r.fecha_limite >= CURDATE()
             ORDER BY r.fecha_limite ASC"
        );
        $sentencia->bindParam(':usuario_id', $usuarioId);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerHistorialReservas($usuarioId) {
        $sentencia = $this->conexion->prepare(
            "SELECT r.*, l.nombre, l.autor, l.imagen, l.descripcion, l.categoria
             FROM reservas r 
             INNER JOIN libros l ON r.libro_id = l.id 
             WHERE r.usuario_id = :usuario_id 
             AND (r.estado != 'pendiente' OR r.fecha_limite < CURDATE())
             ORDER BY r.fecha_reserva DESC"
        );
        $sentencia->bindParam(':usuario_id', $usuarioId);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function cancelarReserva($reservaId, $usuarioId) {
        try {
            $this->conexion->beginTransaction();
            
            // Verificar que la reserva pertenece al usuario
            $sentencia = $this->conexion->prepare(
                "SELECT * FROM reservas WHERE id = :reserva_id AND usuario_id = :usuario_id AND estado = 'pendiente'"
            );
            $sentencia->bindParam(':reserva_id', $reservaId);
            $sentencia->bindParam(':usuario_id', $usuarioId);
            $sentencia->execute();
            $reserva = $sentencia->fetch(PDO::FETCH_ASSOC);
            
            if (!$reserva) {
                return ['success' => false, 'message' => 'Reserva no encontrada o no se puede cancelar'];
            }
            
            // Actualizar estado de la reserva
            $sentencia = $this->conexion->prepare(
                "UPDATE reservas SET estado = 'cancelada' WHERE id = :reserva_id"
            );
            $sentencia->bindParam(':reserva_id', $reservaId);
            $sentencia->execute();
            
            // Devolver stock del libro
            $sentencia = $this->conexion->prepare(
                "UPDATE libros SET stock = stock + 1 WHERE id = :libro_id"
            );
            $sentencia->bindParam(':libro_id', $reserva['libro_id']);
            $sentencia->execute();
            
            $this->conexion->commit();
            return ['success' => true, 'message' => 'Reserva cancelada exitosamente'];
            
        } catch (Exception $e) {
            $this->conexion->rollBack();
            return ['success' => false, 'message' => 'Error al cancelar la reserva: ' . $e->getMessage()];
        }
    }
}
?>