<?php
include_once __DIR__ . "/../admin/seccion/bd.php";

class personaBD extends Conexion {
    public function RegistrarPersona($cedula, $nombre, $apellidos, $domicilio, $telefono, $correo, $contrasena, $tipo) {
        $con = $this->Conectar();

        if ($con === null) {
            die("No se pudo conectar a la base de datos.");
        }

               $stmt = $con->prepare("INSERT INTO personas (cedula, Nombre, Apellidos, Domicilio, Telefono, Correo, contrasena, Tipo)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$cedula, $nombre, $apellidos, $domicilio, $telefono, $correo, $contrasena, $tipo]);
    }
}

        
//class personaBD extends Conexion {
  
//}
?>