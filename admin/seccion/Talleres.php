<?php

// include_once "persona.php"; 

include_once "persona.php";
//////////////////////
// CLASE TALLERES
//////////////////////
class Talleres {
    private $idTaller;
    private $nombre;
    private $dia;
    private $horario;
    private $foto;
    private $descripcion;

    // ID
    public function setId($idTaller){ $this->idTaller = $idTaller; }
    public function getId(){ return $this->idTaller; }

    // Nombre
    public function setNombre($nombre){ $this->nombre = $nombre; }
    public function getNombre(){ return $this->nombre; }

    // Dia
    public function setDia($dia){ $this->dia = $dia; }
    public function getDia(){ return $this->dia; }

    // Horario
    public function setHorario($horario){ $this->horario = $horario; }
    public function getHorario(){ return $this->horario; }

    // Foto
    public function setFoto($foto){ $this->foto = $foto; }
    public function getFoto(){ return $this->foto; }

    // Descripcion
    public function setDescripcion($descripcion){ $this->descripcion = $descripcion; }
    public function getDescripcion(){ return $this->descripcion; }


    // Operaciones
    public function ListarTalleres(){
        $talleresBD = new TalleresBD();
        return $talleresBD->ListarTalleres();
    }

    public function CargarTalleres(){
        $talleresBD = new TalleresBD();
        return $talleresBD->CargarTalleres($this->nombre, $this->dia, $this->horario, $this->foto, $this->idTaller, $this->descripcion);
    }

    public function CambiarTalleres(){
        $talleresBD = new TalleresBD();
        return $talleresBD->CambiarTalleres($this->idTaller, $this->nombre, $this->dia, $this->horario);
    }

    public function BuscarTalleres(){
        $talleresBD = new TalleresBD();
        return $talleresBD->BuscarTalleres($this->idTaller, $this->nombre, $this->dia, $this->horario, $this->descripcion);
    }
}

//////////////////////
// CLASE TALLERESBD
//////////////////////
class TalleresBD extends conexion {

    public function ListarTalleres() {
        $con = $this->Conectar();
        $sql = "SELECT * FROM talleres";
        $stmt = $con->prepare($sql);

        if (!$stmt) die("Error preparando consulta: " . $con->error);

        $stmt->execute();
        $resultado = $stmt->get_result();
        $ListaTalleres = []; 

        while ($fila = $resultado->fetch_assoc()) {
            $taller = new Talleres();
            $taller->setId($fila['Id']);
            $taller->setNombre($fila['nombre']);
            $taller->setDia($fila['dia']);
            $taller->setHorario($fila['horario']);
            $taller->setFoto($fila['foto']);
            $taller->setDescripcion($fila['descripcion']);
            $ListaTalleres[] = $taller;
        }
        return $ListaTalleres;
    }

    public function CargarTalleres($nombre, $dia, $horario, $foto, $idTaller, $descripcion) {
        $con = $this->Conectar();
        $sql = "INSERT INTO talleres (nombre, dia, horario, foto, Id, descripcion ) VALUES (?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        if (!$stmt) die("Error preparando consulta: " . $con->error);
        $stmt->bind_param("ssssss", $nombre, $dia, $horario, $foto, $idTaller, $descripcion );
        return $stmt->execute();
    }

    public function CambiarTalleres($idTaller, $nombre, $dia, $horario, $descripcion) {
        $con = $this->Conectar();
        $sql = "UPDATE talleres SET nombre = ?, dia = ?, horario = ?, descripcion = ? WHERE Id = ?";
        $stmt = $con->prepare($sql);
        if (!$stmt) die("Error preparando consulta: " . $con->error);
        $stmt->bind_param("sssis", $nombre, $dia, $horario, $idTaller, $descripcion);
        return $stmt->execute();
    }

public function BuscarTalleres($idTaller, $nombre, $dia, $horario, $descripcion) {
        $con = $this->Conectar();
        $sql = "SELECT * FROM talleres WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($idTaller)) { $sql .= " AND Id = ?"; $params[] = $idTaller; $types .= "i"; }
        if (!empty($nombre)) { $sql .= " AND nombre LIKE ?"; $params[] = "%".$nombre."%"; $types .= "s"; }
        if (!empty($dia)) { $sql .= " AND dia LIKE ?"; $params[] = "%".$dia."%"; $types .= "s"; }
        if (!empty($horario)) { $sql .= " AND horario LIKE ?"; $params[] = "%".$horario."%"; $types .= "s"; }
        if (!empty($descripcion)) { $sql .= " AND descripcion LIKE ?"; $params[] = "%".$descripcion."%"; $types .= "s"; }

        $stmt = $con->prepare($sql);
        if (!$stmt) die("Error preparando consulta: " . $con->error);
        if (!empty($params)) $stmt->bind_param($types, ...$params);

        $stmt->execute();
        $resultado = $stmt->get_result();
        $buscarTalleres = [];

        while ($fila = $resultado->fetch_assoc()) {
            $taller = new Talleres();
            $taller->setId($fila['Id']);
            $taller->setNombre($fila['nombre']);
            $taller->setDia($fila['dia']);
            $taller->setHorario($fila['horario']);
            $taller->setFoto($fila['foto']);
            $taller->setDescripcion($fila['descripcion']);
            $buscarTalleres[] = $taller;
        }
        return $buscarTalleres;
    }
}
?>
