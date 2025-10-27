<?php
$host="localhost";
$bd="asociacion";
$usuario="root";
$contraseña="abc123";

try { 
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contraseña);  
    if($conexion) { 
        echo "";
    } else {
        echo "Error al conectar a la base de datos.";
    }
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

class Conexion {
    private $host = "localhost";
    private $bd = "asociacion";
    private $usuario = "root";
    private $contraseña = "abc123";
    private $conexion;

    public function Conectar() {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->bd", $this->usuario, $this->contraseña);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}

?>
