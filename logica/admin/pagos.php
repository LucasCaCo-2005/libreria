<?php
class GestorPagos {
    private $conexion;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    
    /**
     * Registrar un pago para un socio
     */
    public function registrarPago($socio_id, $tipo_pago) {
        $mesActual = date("F Y");
        $fechaHoy = date("Y-m-d");
        
        // Definir tipos de pago
        $tipos = [
            "pago1" => 100.00,
            "pago2" => 50.00
        ];
        
        if (!array_key_exists($tipo_pago, $tipos)) {
            return [
                'success' => false,
                'message' => 'Tipo de pago no válido'
            ];
        }
        
        $monto = $tipos[$tipo_pago];
        
        // Verificar si ya existe el pago
        $check = $this->conexion->prepare("
            SELECT COUNT(*) 
            FROM pagos 
            WHERE socio_id = :socio_id 
              AND mes_pagado = :mes 
              AND tipo_pago = :tipo_pago
        ");
        $check->bindParam(':socio_id', $socio_id, PDO::PARAM_INT);
        $check->bindParam(':mes', $mesActual, PDO::PARAM_STR);
        $check->bindParam(':tipo_pago', $tipo_pago, PDO::PARAM_STR);
        $check->execute();
        
        if ($check->fetchColumn() > 0) {
            return [
                'success' => false,
                'message' => "Este socio ya realizó este pago en $mesActual"
            ];
        }
        
        // Registrar el pago
        $insert = $this->conexion->prepare("
            INSERT INTO pagos (socio_id, fecha_pago, mes_pagado, tipo_pago, monto)
            VALUES (:socio_id, :fecha_pago, :mes_pagado, :tipo_pago, :monto)
        ");
        $insert->bindParam(':socio_id', $socio_id, PDO::PARAM_INT);
        $insert->bindParam(':fecha_pago', $fechaHoy, PDO::PARAM_STR);
        $insert->bindParam(':mes_pagado', $mesActual, PDO::PARAM_STR);
        $insert->bindParam(':tipo_pago', $tipo_pago, PDO::PARAM_STR);
        $insert->bindParam(':monto', $monto);
        
        if ($insert->execute()) {
            return [
                'success' => true,
                'message' => 'Pago registrado correctamente',
                'data' => [
                    'id' => $this->conexion->lastInsertId(),
                    'socio_id' => $socio_id,
                    'fecha_pago' => $fechaHoy,
                    'mes_pagado' => $mesActual,
                    'tipo_pago' => $tipo_pago,
                    'monto' => $monto
                ]
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Error al registrar el pago'
        ];
    }
    
    /**
     * Eliminar un pago específico
     */
    public function eliminarPago($pago_id) {
        $delete = $this->conexion->prepare("DELETE FROM pagos WHERE id = :id");
        $delete->bindParam(':id', $pago_id, PDO::PARAM_INT);
        
        if ($delete->execute()) {
            return [
                'success' => true,
                'message' => 'Pago eliminado correctamente'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Error al eliminar el pago'
        ];
    }
    
    /**
     * Obtener historial de pagos de un socio
     */
    public function obtenerHistorialSocio($socio_id, $limite = 10) {
        $sentencia = $this->conexion->prepare("
            SELECT * FROM pagos 
            WHERE socio_id = :socio_id 
            ORDER BY fecha_pago DESC 
            LIMIT :limite
        ");
        $sentencia->bindParam(':socio_id', $socio_id, PDO::PARAM_INT);
        $sentencia->bindParam(':limite', $limite, PDO::PARAM_INT);
        $sentencia->execute();
        
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener pagos del mes actual con información del socio
     */
    public function obtenerPagosMesActual() {
        $mesActual = date("F Y");
        
        $sentencia = $this->conexion->prepare("
            SELECT p.*, s.nombre, s.socio as numero_socio
            FROM pagos p
            INNER JOIN socios s ON p.socio_id = s.id
            WHERE p.mes_pagado = :mes
            ORDER BY p.fecha_pago DESC
        ");
        $sentencia->bindParam(':mes', $mesActual, PDO::PARAM_STR);
        $sentencia->execute();
        
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener estadísticas de pagos del mes actual
     */
    public function obtenerEstadisticasMesActual() {
        $mesActual = date("F Y");
        
        $estadisticas = [];
        
        // Total de socios que pagaron
        $sentencia = $this->conexion->prepare("
            SELECT COUNT(DISTINCT socio_id) as total 
            FROM pagos 
            WHERE mes_pagado = :mes
        ");
        $sentencia->bindParam(':mes', $mesActual, PDO::PARAM_STR);
        $sentencia->execute();
        $estadisticas['total_socios_pagaron'] = $sentencia->fetchColumn();
        
        // Total recaudado
        $sentencia = $this->conexion->prepare("
            SELECT SUM(monto) as total_recaudado 
            FROM pagos 
            WHERE mes_pagado = :mes
        ");
        $sentencia->bindParam(':mes', $mesActual, PDO::PARAM_STR);
        $sentencia->execute();
        $estadisticas['total_recaudado'] = $sentencia->fetchColumn() ?? 0;
        
        // Cantidad por tipo de pago
        $sentencia = $this->conexion->prepare("
            SELECT tipo_pago, COUNT(*) as cantidad 
            FROM pagos 
            WHERE mes_pagado = :mes
            GROUP BY tipo_pago
        ");
        $sentencia->bindParam(':mes', $mesActual, PDO::PARAM_STR);
        $sentencia->execute();
        $estadisticas['por_tipo'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        
        $estadisticas['mes_actual'] = $mesActual;
        
        return $estadisticas;
    }
    
    /**
     * Verificar si un socio puede realizar un pago
     */
    public function socioPuedePagar($socio_id) {
        $sentencia = $this->conexion->prepare("
            SELECT estado FROM socios WHERE id = :id
        ");
        $sentencia->bindParam(':id', $socio_id, PDO::PARAM_INT);
        $sentencia->execute();
        
        $estado = $sentencia->fetchColumn();
        
        return $estado === 'activo';
    }
    
    /**
     * Obtener información del socio
     */
    public function obtenerInfoSocio($socio_id) {
        $sentencia = $this->conexion->prepare("
            SELECT id, nombre, socio, correo, estado 
            FROM socios 
            WHERE id = :id
        ");
        $sentencia->bindParam(':id', $socio_id, PDO::PARAM_INT);
        $sentencia->execute();
        
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
}
?>