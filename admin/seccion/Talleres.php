<?php
include_once "bd.php";


class Talleres {
    private $idTaller;
    private $nombre;
    private $dia;
    private $horario;
    private $foto;
    private $descripcion;
    private $costo;
    private $estado;
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

      //Costo

    
    public function setCosto($costo){ $this->costo = $costo; }
    public function getCosto(){ return $this->costo; }


    // Estado
    public function setEstado($estado){ $this->estado = $estado; }
    public function getEstado(){ return $this->estado; }

  
    // Operaciones
    public function ListarTalleres(){
        $talleresBD = new TalleresBD();
        return $talleresBD->ListarTalleres();
    } 

    public function CargarTalleres(){
        $talleresBD = new TalleresBD();
        return $talleresBD->CargarTalleres($this->nombre, $this->dia, $this->horario, $this->foto, $this->idTaller, $this->descripcion, $this->costo  ,$this->estado);
    }
}

class TalleresBD extends Conexion {

    // 📋 Listar talleres
    public function ListarTalleres(){
        $con = $this->Conectar();
        $sql = "SELECT * FROM talleres";
        $stmt = $con->prepare($sql);
        if (!$stmt) die("Error preparando consulta: " . $con->errorInfo()[2]);

        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $ListaTalleres = [];
        foreach ($resultado as $fila) {
            $taller = new Talleres();
            $taller->setId($fila['Id']);
            $taller->setNombre($fila['nombre']);
            $taller->setDia($fila['dia']);
            $taller->setHorario($fila['horario']);
            $taller->setFoto($fila['foto']);
            $taller->setDescripcion($fila['descripcion']);
            $taller->setCosto($fila['costo']);
            $taller->setEstado($fila['estado']);
            $ListaTalleres[] = $taller;
        }

        return $ListaTalleres;
    }

    // 🆕 Insertar taller
    public function CargarTalleres($nombre, $dia, $horario, $foto, $idTaller, $descripcion, $costo, $estado){
        $con = $this->Conectar();
        $sql = "INSERT INTO talleres (nombre, dia, horario, foto, descripcion, costo, estado)
                VALUES (:nombre, :dia, :horario, :foto, :descripcion, :costo, :estado)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':dia', $dia);
        $stmt->bindParam(':horario', $horario);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':estado', $estado);

        if ($stmt->execute()) {
            echo "<script>alert('Taller agregado correctamente');</script>";
            return true;
        } else {
            echo "<script>alert('Error al agregar taller');</script>";
            return false;
        }
    }
}

?>