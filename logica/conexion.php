<?php
class conexion {
    private $nombreservidor = "localhost";
    private $usuario = "root";
    private $pass = "abc123";
    private $base = "asociacion";
    private $conexion;

    public function Conectar() {
        $this->conexion = new mysqli($this->nombreservidor, $this->usuario, $this->pass, $this->base);

        if ($this->conexion->connect_error) {
            echo "error" . $this->conexion->connect_error;
        } else {
            return $this->conexion;
        }
    }

    public function Desconectar() {
        $this->conexion->close();
    }
}
?>