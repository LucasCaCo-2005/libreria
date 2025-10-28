<?php
if (!class_exists('Conexion')) {
    class Conexion {
        private $host = "localhost";
        private $bd = "asociacion";
        private $usuario = "root";
        private $contraseña = "abc123";
        private $conexion;

        public function Conectar() {
            try {
                $this->conexion = new PDO(
                    "mysql:host=$this->host;dbname=$this->bd;charset=utf8",
                    $this->usuario,
                    $this->contraseña
                );
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->conexion;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return null;
            }
        }
    }
}
if (!isset($conexion)) {
    $conexion = (new Conexion())->Conectar();
}
?>
