<?php
include_once __DIR__ . "/../admin/seccion/bd.php";
include_once __DIR__ . "/../admin/seccion/users.php";

class socioBD extends Conexion {
public function RegistrarSocio($cedula, $nombre, $apellidos, $domicilio, $telefono, $correo, $contrasena, $estado) {
    try {
        // ✅ Conectarse con la misma clase que vos usás
        $db = new Conexion();
        $con = $db->Conectar();

        // Hashear contraseña por seguridad (opcional)
        // $contrasena = password_hash($contrasena, PASSWORD_BCRYPT);

        // Preparar consulta
        $sql = "INSERT INTO socios (cedula, Nombre, Apellidos, Domicilio, Telefono, Correo, contrasena, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        // Ejecutar con parámetros
        $resultado = $stmt->execute([
            $cedula, 
            $nombre, 
            $apellidos, 
            $domicilio, 
            $telefono, 
            $correo, 
            $contrasena, 
            $estado
        ]);

        if ($resultado) {
            return true;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        // Mostrar el error real
        echo "<script>alert('Error al registrar socio: " . $e->getMessage() . "');</script>";
        return false;
    }
}
}