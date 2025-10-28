<?php

include_once __DIR__ . "/bd.php";
//include_once __DIR__ . "/../logica/personaBD.php";
//include_once __DIR__ . "/logica/persona/personaBD.php";
class personaBD extends Conexion {
    public function RegistrarPersona($cedula, $nombre, $telefono, $correo, $contrasena, $tipo) {
        $con = $this->Conectar();

        if ($con === null) {
            die("No se pudo conectar a la base de datos.");
        }

               $stmt = $con->prepare("INSERT INTO personas (cedula, Nombre, Telefono, Correo, contrasena, Tipo)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$cedula, $nombre, $telefono, $correo, $contrasena, $tipo]);
    }
}

class Persona {

    private $Cedula;
    private $Nombre;
    private $Telefono;
    private $Correo;
    private $Contrasena;
    private $Tipo;

    public function getCedula() {
        return $this->Cedula;
    }

    public function getContrasena() {
        return $this->Contrasena;
    }

    public function setCedula($Cedula) { $this->Cedula = $Cedula; }
    public function setNombre($Nombre) { $this->Nombre = $Nombre; }
    public function setTelefono($Telefono) { $this->Telefono = $Telefono; }
    public function setCorreo($Correo) { $this->Correo = $Correo; }
    public function setContrasena($Contrasena) { $this->Contrasena = $Contrasena; }
    public function setTipo($Tipo) { $this->Tipo = $Tipo; }

    public function CargarPersonas() { 
        // Aquí registramos a la persona
        $registro = new personaBD();
        $registro->RegistrarPersona(
            $this->Cedula,
            $this->Nombre,
            $this->Telefono,  
            $this->Correo,
            $this->Contrasena,
            $this->Tipo
        );
    }
 public function login($cedula, $contrasena) {
    // Creamos la conexión usando la clase Conexion
    $conexion = new Conexion(); // instancia de la clase Conexion
    $con = $conexion->Conectar(); // método que devuelve el PDO

    // Preparar la consulta
    $sql = "SELECT * FROM personas WHERE cedula = :cedula AND contrasena = :contrasena";
    $stmt = $con->prepare($sql);

    // Usar los parámetros correctos
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':contrasena', $contrasena);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve la fila encontrada o false
}
}