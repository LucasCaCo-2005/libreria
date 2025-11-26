<?php
include_once "../../persistencia/admin/bd.php";

class socioBD extends Conexion {
    
    public function registrarUsuarioCompleto($nombre, $apellidos, $telefono, $correo, $contrasena) {
        error_log("=== INICIANDO REGISTRO COMPLETO ===");
        
        $conexion = $this->Conectar();
        if (!$conexion) {
            error_log("❌ No hay conexión a BD");
            return false;
        }
        
        try {
            // Generar datos para los campos obligatorios
            $cedula = "SOC" . uniqid();
            $socio = $nombre . " " . $apellidos;
            $domicilio = "Por definir";
            $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $estado = 'Pendiente';
            
            error_log("Datos a insertar:");
            error_log("- Socio: $socio");
            error_log("- Nombre: $nombre");
            error_log("- Apellidos: $apellidos");
            error_log("- Teléfono: $telefono");
            error_log("- Correo: $correo");
            error_log("- Cédula: $cedula");
            error_log("- Estado: $estado");
            
            // INSERT con todos los campos
            $sql = "INSERT INTO socios (socio, nombre, apellidos, cedula, domicilio, telefono, correo, contrasena, estado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            error_log("SQL: $sql");
            
            $stmt = $conexion->prepare($sql);
            
            if ($stmt->execute([$socio, $nombre, $apellidos, $cedula, $domicilio, $telefono, $correo, $contrasena_hash, $estado])) {
                error_log("✅ Registro COMPLETO EXITOSO");
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("❌ Error en execute: " . $errorInfo[2]);
                return false;
            }
            
        } catch (PDOException $e) {
            error_log("❌ Error PDO: " . $e->getMessage());
            error_log("❌ Código error: " . $e->getCode());
            return false;
        }
    }
    
    public function correoExiste($correo) {
        $conexion = $this->Conectar();
        if (!$conexion) return false;
        
        try {
            $sql = "SELECT id FROM socios WHERE correo = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            $existe = $stmt->rowCount() > 0;
            error_log("Correo '$correo' existe: " . ($existe ? 'SI' : 'NO'));
            return $existe;
        } catch (PDOException $e) {
            error_log("Error verificando correo: " . $e->getMessage());
            return false;
        }
    }
    
    public function probarConexion() {
        try {
            $conexion = $this->Conectar();
            return $conexion !== null;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>