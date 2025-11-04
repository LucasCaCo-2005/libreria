<?php

include_once __DIR__ . "/../admin/seccion/bd.php";  // Incluye la clase de conexión

class socioBD extends Conexion {
    // Método para registrar un socio
    public function RegistrarSocio($cedula, $nombre, $apellidos, $domicilio, $telefono, $correo, $contrasena, $estado) {
        try {
            // Conectar a la base de datos
            $con = $this->Conectar();  // Uso de $this para acceder a la conexión

            // Hashear contraseña por seguridad (opcional)
            // $contrasena = password_hash($contrasena, PASSWORD_BCRYPT);

            // Preparar consulta SQL para insertar el socio
            $sql = "INSERT INTO socios (cedula, Nombre, Apellidos, Domicilio, Telefono, Correo, contrasena, estado)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);

            // Ejecutar la consulta
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

            // Retorna el resultado de la operación
            return $resultado ? true : false;

        } catch (PDOException $e) {
            // Captura y muestra el error en caso de fallar
            echo "<script>alert('Error al registrar socio: " . $e->getMessage() . "');</script>";
            return false;
        }
    }

    // Método para actualizar datos de un socio
    public function ActualizarSocio($id, $nombre, $apellidos, $domicilio, $telefono, $correo) {
        try {
            // Conectar a la base de datos
            $con = $this->Conectar();  // Uso de $this para acceder a la conexión

            // Preparar la consulta SQL para actualizar los datos
            $sql = "UPDATE socios SET nombre = ?, apellidos = ?, correo = ?, domicilio = ?, telefono = ? WHERE id = ?";
            $stmt = $con->prepare($sql);

            // Ejecutar la consulta con los datos proporcionados
            $stmt->execute([$nombre, $apellidos, $correo, $domicilio, $telefono, $id]);

            // Verificar si se actualizó alguna fila
            if ($stmt->rowCount() > 0) {
                // Actualizar los datos en la sesión si fue exitoso
                $_SESSION['socios']['nombre'] = $nombre;
                $_SESSION['socios']['apellidos'] = $apellidos;
                $_SESSION['socios']['correo'] = $correo;
                $_SESSION['socios']['domicilio'] = $domicilio;
                $_SESSION['socios']['telefono'] = $telefono;
                return "Datos personales actualizados correctamente.";
            } else {
                return "No se realizaron cambios o algo salió mal.";
            }
        } catch (PDOException $e) {
            return "Error al actualizar los datos: " . $e->getMessage();
        }
    }



    /*public function ActualizarContrasena($id, $contrasena) {
    try {
        // Conectar a la base de datos
        $con = $this->Conectar();

        // Hashear la contraseña
    //    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
        $contrasena = trim($_POST['password_nueva']);
        // Preparar la consulta SQL para actualizar la contraseña
        $sql = "UPDATE socios SET contrasena = ? WHERE id = ?";
        $stmt = $con->prepare($sql);

        // Ejecutar la consulta con los datos proporcionados
        $stmt->execute([$contrasena, $id]);

        // Verificar si se actualizó alguna fila
        if ($stmt->rowCount() > 0) {
            // Recuperar el nombre del usuario (si es necesario)
            $sql = "SELECT nombre FROM socios WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->execute([$id]);

            // Recuperamos el nombre
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Actualizar los datos en la sesión
            $_SESSION['socios']['nombre'] = $usuario['nombre'];

            return "Contraseña actualizada correctamente";  // Mensaje de éxito
        } else {
            return "No se realizaron cambios o algo salió mal.";  // Mensaje de error
        }
    } catch (PDOException $e) {
        return "Error al actualizar los datos: " . $e->getMessage();  // Mensaje de error
    }
*/
}
    


?>
