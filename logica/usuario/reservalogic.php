<?php
// Logica/Usuario/reservaLogic.php

class ReservaLogic {
    private $conexion;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    
    public function agregarAlCarrito($idLibro, $usuarioId) {
        // Verificar si el libro existe y tiene stock
        $sentencia = $this->conexion->prepare("SELECT * FROM libros WHERE id = :id AND stock > 0");
        $sentencia->bindParam(":id", $idLibro);
        $sentencia->execute();
        $libro = $sentencia->fetch(PDO::FETCH_ASSOC);
        
        if (!$libro) {
            return ['success' => false, 'message' => 'Libro no disponible'];
        }
        
        // Inicializar carrito si no existe
        if (!isset($_SESSION['carrito_reservas'])) {
            $_SESSION['carrito_reservas'] = [];
        }
        
        // Verificar límite de 3 libros
        if (count($_SESSION['carrito_reservas']) >= 3) {
            return ['success' => false, 'message' => 'Límite de 3 libros alcanzado'];
        }
        
        // Verificar si ya está en el carrito
        foreach ($_SESSION['carrito_reservas'] as $item) {
            if ($item['id'] == $libro['id']) {
                return ['success' => false, 'message' => 'El libro ya está en tu carrito'];
            }
        }
        
        // Agregar al carrito
        $_SESSION['carrito_reservas'][] = [
            'id' => $libro['id'],
            'nombre' => $libro['nombre'],
            'autor' => $libro['autor'],
            'imagen' => $libro['imagen'],
            'fecha_agregado' => date('Y-m-d H:i:s')
        ];
        
        return ['success' => true, 'message' => 'Libro agregado al carrito'];
    }
    
    public function eliminarDelCarrito($idLibro) {
        if (!isset($_SESSION['carrito_reservas'])) {
            return false;
        }
        
        foreach ($_SESSION['carrito_reservas'] as $index => $item) {
            if ($item['id'] == $idLibro) {
                array_splice($_SESSION['carrito_reservas'], $index, 1);
                return true;
            }
        }
        return false;
    }
    
    public function vaciarCarrito() {
        $_SESSION['carrito_reservas'] = [];
        return true;
    }
    
    public function confirmarReserva($usuarioId) {
        error_log("Confirmando reserva para usuario: $usuarioId");
        
        if (!isset($_SESSION['carrito_reservas']) || empty($_SESSION['carrito_reservas'])) {
            error_log("Carrito vacío");
            return ['success' => false, 'message' => 'El carrito está vacío'];
        }
        
        error_log("Libros en carrito: " . count($_SESSION['carrito_reservas']));
        
        $fecha_reserva = date('Y-m-d H:i:s');
        $fecha_limite = date('Y-m-d', strtotime('+15 days'));
        
        try {
            $this->conexion->beginTransaction();
            
            foreach ($_SESSION['carrito_reservas'] as $libro) {
                error_log("Reservando libro: " . $libro['id'] . " - " . $libro['nombre']);
                
                // Insertar reserva
                $sentencia = $this->conexion->prepare(
                    "INSERT INTO reservas (usuario_id, libro_id, fecha_reserva, fecha_limite, estado) 
                     VALUES (:usuario_id, :libro_id, :fecha_reserva, :fecha_limite, 'pendiente')"
                );
                $sentencia->bindParam(':usuario_id', $usuarioId);
                $sentencia->bindParam(':libro_id', $libro['id']);
                $sentencia->bindParam(':fecha_reserva', $fecha_reserva);
                $sentencia->bindParam(':fecha_limite', $fecha_limite);
                $sentencia->execute();
                
                // Actualizar stock
                $sentencia = $this->conexion->prepare(
                    "UPDATE libros SET stock = stock - 1 WHERE id = :libro_id"
                );
                $sentencia->bindParam(':libro_id', $libro['id']);
                $sentencia->execute();
            }
            
            $this->conexion->commit();
            
            // Guardar datos para mostrar confirmación
            $reservaConfirmada = $_SESSION['carrito_reservas'];
            $_SESSION['carrito_reservas'] = [];
            
            error_log("Reserva confirmada exitosamente");
            
            return [
                'success' => true, 
                'message' => 'Reserva confirmada exitosamente',
                'data' => [
                    'libros' => $reservaConfirmada,
                    'fecha_reserva' => $fecha_reserva,
                    'fecha_limite' => $fecha_limite
                ]
            ];
            
        } catch (Exception $e) {
            $this->conexion->rollBack();
            error_log("Error en reserva: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al confirmar la reserva: ' . $e->getMessage()];
        }
    }
    
    public function obtenerCarrito() {
        return $_SESSION['carrito_reservas'] ?? [];
    }
}
?>