<?php

class Reserva {
    private $ci;
    private $libro_id;
    private $prestamo;
    private $devolucion;
    private $devuelto;

    public function setCi($ci) {
        $this->ci = $ci;
    }

    public function setId_mascota($libro_id) {
        $this->libro_id = $libro_id;
    }

    public function setPrestamo($prestamo) {
        $this->prestamo = $prestamo;
    }

    public function setDevolucion($devolucion) {
        $this->devolucion = $devolucion;
    }

    

    public function Reservar() {
        $conexion = new conexion();
        $conn = $conexion->Conectar();

        $sql = "INSERT INTO prestamos (ci, libro_id, prestamo, devolucion, devuelto) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("iisss", $this->ci, $this->libro_id, $this->prestamo, $this->devolucion, $this->devuelto);
        return $stmt->execute();
    }
}

?>
