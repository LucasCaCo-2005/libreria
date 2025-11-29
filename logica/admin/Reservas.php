<?php
// Logica/Admin/reservasAdminLogic.php

class ReservasAdminLogic {
    private $conexion;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    
    public function obtenerReservasPendientes() {
        $sentencia = $this->conexion->prepare(
            "SELECT r.*, 
                    l.nombre as libro_nombre, 
                    l.autor as libro_autor, 
                    l.imagen as libro_imagen,
                    l.categoria as libro_categoria,
                    u.nombre as usuario_nombre,
                    u.correo as usuario_correo,
                    u.telefono as usuario_telefono
             FROM reservas r 
             INNER JOIN libros l ON r.libro_id = l.id 
             INNER JOIN socios u ON r.usuario_id = u.id 
             WHERE r.estado = 'pendiente'
             AND r.fecha_limite >= CURDATE()
             ORDER BY r.fecha_limite ASC, r.fecha_reserva ASC"
        );
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerReservasHoy() {
        $sentencia = $this->conexion->prepare(
            "SELECT r.*, 
                    l.nombre as libro_nombre, 
                    l.autor as libro_autor, 
                    l.imagen as libro_imagen,
                    u.nombre as usuario_nombre
             FROM reservas r 
             INNER JOIN libros l ON r.libro_id = l.id 
             INNER JOIN socios u ON r.usuario_id = u.id 
             WHERE r.estado = 'pendiente'
             AND r.fecha_limite = CURDATE()
             ORDER BY r.fecha_reserva ASC"
        );
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function marcarComoPreparado($reservaId) {
        try {
            $sentencia = $this->conexion->prepare(
                "UPDATE reservas SET estado = 'preparado' WHERE id = :reserva_id"
            );
            $sentencia->bindParam(':reserva_id', $reservaId);
            $sentencia->execute();
            
            return ['success' => true, 'message' => 'Reserva marcada como preparada'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al actualizar la reserva: ' . $e->getMessage()];
        }
    }
    
    public function marcarComoEntregado($reservaId) {
        try {
            $sentencia = $this->conexion->prepare(
                "UPDATE reservas SET estado = 'completada' WHERE id = :reserva_id"
            );
            $sentencia->bindParam(':reserva_id', $reservaId);
            $sentencia->execute();
            
            return ['success' => true, 'message' => 'Reserva marcada como entregada'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al actualizar la reserva: ' . $e->getMessage()];
        }
    }
    
    public function obtenerEstadisticas() {
        $stats = [];
        
        // Total reservas pendientes
        $sentencia = $this->conexion->prepare(
            "SELECT COUNT(*) as total FROM reservas WHERE estado = 'pendiente' AND fecha_limite >= CURDATE()"
        );
        $sentencia->execute();
        $stats['pendientes'] = $sentencia->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Reservas para hoy
        $sentencia = $this->conexion->prepare(
            "SELECT COUNT(*) as total FROM reservas WHERE estado = 'pendiente' AND fecha_limite = CURDATE()"
        );
        $sentencia->execute();
        $stats['hoy'] = $sentencia->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Reservas preparadas
        $sentencia = $this->conexion->prepare(
            "SELECT COUNT(*) as total FROM reservas WHERE estado = 'preparado'"
        );
        $sentencia->execute();
        $stats['preparadas'] = $sentencia->fetch(PDO::FETCH_ASSOC)['total'];
        
        return $stats;
    }
}
?>