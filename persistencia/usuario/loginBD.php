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
            $sql = "SELECT id, nombre, apellidos, contrasena, estado FROM socios WHERE correo = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario) {
                error_log("✅ Usuario encontrado: " . $usuario['nombre']);
                
                // Verificar contraseña
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    error_log("✅ Contraseña correcta");
                    
                    // Verificar estado del usuario
                    if ($usuario['estado'] === 'activo') {
                        error_log("✅ Usuario activo - Login exitoso");
                        return [
                            'id' => $usuario['id'],
                            'nombre' => $usuario['nombre'],
                            'apellidos' => $usuario['apellidos'],
                            'correo' => $correo
                        ];
                    } else {
                        error_log("❌ Usuario inactivo");
                        return 'inactivo';
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