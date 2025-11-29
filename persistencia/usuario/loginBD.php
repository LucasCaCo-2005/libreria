<?php
include_once "../../persistencia/admin/bd.php";

class loginBD extends Conexion {
    
    // Método para verificar credenciales
    public function verificarCredenciales($correo, $contrasena) {
        error_log("=== VERIFICANDO CREDENCIALES ===");
        
        $conexion = $this->Conectar();
        if (!$conexion) {
            error_log("❌ No hay conexión a BD");
            return false;
        }
        
        try {
            // Buscar usuario por correo
            $sql = "SELECT id, nombre, apellidos, contrasena, estado, telefono, domicilio, correo, socio, cedula FROM socios WHERE correo = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario) {
                error_log("✅ Usuario encontrado: " . $usuario['nombre']);
                error_log("📝 Estado del usuario: " . $usuario['estado']);
                
                // Verificar contraseña
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    error_log("✅ Contraseña correcta");
                    
                    // VERIFICAR ESTADO DEL USUARIO - ACEPTAR ACTIVOS, PENDIENTES Y ADMINS
                    if ($usuario['estado'] === 'activo' || $usuario['estado'] === 'pendiente' || $usuario['estado'] === 'admin') {
                        error_log("✅ Usuario " . $usuario['estado'] . " - Login permitido");
                        
                        // Devolver todos los datos del usuario incluyendo el estado
                        return [
                            'id' => $usuario['id'],
                            'nombre' => $usuario['nombre'],
                            'apellidos' => $usuario['apellidos'],
                            'correo' => $usuario['correo'],
                            'estado' => $usuario['estado'],
                            'telefono' => $usuario['telefono'] ?? '',
                            'domicilio' => $usuario['domicilio'] ?? '',
                            'socio' => $usuario['socio'] ?? '',
                            'cedula' => $usuario['cedula'] ?? ''
                        ];
                    } else {
                        error_log("❌ Usuario con estado no permitido: " . $usuario['estado']);
                        return 'estado_no_permitido';
                    }
                } else {
                    error_log("❌ Contraseña incorrecta");
                    return false;
                }
            } else {
                error_log("❌ Usuario no encontrado");
                return false;
            }
            
        } catch (PDOException $e) {
            error_log("❌ Error PDO en login: " . $e->getMessage());
            return false;
        }
    }
    
    // Método para verificar si un usuario puede acceder (incluye admin)
    public function usuarioPuedeAcceder($correo) {
        $conexion = $this->Conectar();
        if (!$conexion) return false;
        
        try {
            $sql = "SELECT estado FROM socios WHERE correo = ? AND estado IN ('activo', 'pendiente', 'admin')";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error verificando acceso: " . $e->getMessage());
            return false;
        }
    }
    
    // Método para verificar si un usuario es administrador
    public function esAdministrador($correo) {
        $conexion = $this->Conectar();
        if (!$conexion) return false;
        
        try {
            $sql = "SELECT estado FROM socios WHERE correo = ? AND estado = 'admin'";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error verificando admin: " . $e->getMessage());
            return false;
        }
    }
    
    // Método adicional para obtener información completa del usuario
    public function obtenerUsuario($correo) {
        $conexion = $this->Conectar();
        if (!$conexion) return false;
        
        try {
            $sql = "SELECT * FROM socios WHERE correo = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error obteniendo usuario: " . $e->getMessage());
            return false;
        }
    }
    
    // Método para probar la conexión
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