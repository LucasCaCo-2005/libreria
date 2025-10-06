<?php

// include_once "persona.php"; 

include_once "persona.php";
include_once ("config/bd.php");
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
        return $talleresBD->CargarTalleres($this->nombre, $this->dia, $this->horario, $this->foto, $this->idTaller, $this->descripcion, $this->estado);
    }

    public function CambiarTalleres(){
        $talleresBD = new TalleresBD();
        return $talleresBD->CambiarTalleres($this->idTaller, $this->nombre, $this->dia, $this->horario);
    }

    public function BuscarTalleres(){
        $talleresBD = new TalleresBD();
        return $talleresBD->BuscarTalleres($this->idTaller, $this->nombre, $this->dia, $this->horario, $this->descripcion, $this->estado);
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
            $taller->setEstado($fila['estado']);
            $ListaTalleres[] = $taller;
        }
        return $ListaTalleres;
    }

    public function CargarTalleres($nombre, $dia, $horario, $foto, $idTaller, $descripcion) {
        $con = $this->Conectar();
        $sql = "INSERT INTO talleres (nombre, dia, horario, foto, Id, descripcion, estado ) VALUES (?,?,?,?,?,?, 'activo')";
        $stmt = $con->prepare($sql);
        if (!$stmt) die("Error preparando consulta: " . $con->error);
        $stmt->bind_param("ssssis", $nombre, $dia, $horario, $foto, $idTaller, $descripcion );
        return $stmt->execute();
    }

    public function CambiarTalleres($idTaller, $nombre, $dia, $horario, $descripcion, $estado) {
        $con = $this->Conectar();
        $sql = "UPDATE talleres SET nombre = ?, dia = ?, horario = ?, descripcion = ?, estado = ?, WHERE Id = ?";
        $stmt = $con->prepare($sql);
        if (!$stmt) die("Error preparando consulta: " . $con->error);
        $stmt->bind_param("sssiss", $nombre, $dia, $horario, $idTaller, $descripcion, $estado);
        return $stmt->execute();
    }

public function BuscarTalleres($idTaller, $nombre, $dia, $horario, $descripcion, $estado) {
        $con = $this->Conectar();
        $sql = "SELECT * FROM talleres WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($idTaller)) { $sql .= " AND Id = ?"; $params[] = $idTaller; $types .= "i"; } //
        if (!empty($nombre)) { $sql .= " AND nombre LIKE ?"; $params[] = "%".$nombre."%"; $types .= "s"; } 
        if (!empty($dia)) { $sql .= " AND dia LIKE ?"; $params[] = "%".$dia."%"; $types .= "s"; }
        if (!empty($horario)) { $sql .= " AND horario LIKE ?"; $params[] = "%".$horario."%"; $types .= "s"; }
        if (!empty($descripcion)) { $sql .= " AND descripcion LIKE ?"; $params[] = "%".$descripcion."%"; $types .= "s"; }
        if (!empty($estado)) { $sql .= " AND estado = ?"; $params[] = $estado; $types .= "s"; }
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
            $taller->setEstado($fila['estado']);
            $buscarTalleres[] = $taller;
        }
        return $buscarTalleres;
    }
}

$accion = isset($_POST['accion']) ? $_POST['accion'] : "";
$txtID  = isset($_POST['id']) ? intval($_POST['id']) : 0;


if ($accion == "deshabilitar" && $txtID > 0) {
    $stmt = $conexion->prepare("UPDATE talleres SET estado='inactivo' WHERE Id = ?");
    $stmt->execute([$txtID]);

    header("Location: vistaT.php");
    exit();
}

if ($accion == "habilitar" && $txtID > 0) {
    $stmt = $conexion->prepare("UPDATE talleres SET estado='activo' WHERE Id = ?");
    $stmt->execute([$txtID]);

    header("Location: vistaT.php");
    exit();
}

if ($accion == "BuscarT" ) {
    $buscarTermino = isset($_POST['search']) ? $_POST['search'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM talleres WHERE nombre LIKE :termino OR descripcion LIKE :termino");
    $sentencia->bindValue(':termino', '%' . $buscarTermino . '%');
    $sentencia->execute();
    $listaTalleres = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}



$filtro = "";
$parametros = [];


if (isset($_GET['filtroEstado']) && $_GET['filtroEstado'] != "") {
    $filtro = " WHERE estado = :estado ";
    $parametros[':estado'] = $_GET['filtroEstado'];
}
$sentenciaSQL = $conexion->prepare("SELECT * FROM talleres $filtro");
$sentenciaSQL->execute($parametros);
$listaSocios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$filtroSeleccionado = isset($_GET['filtroEstado']) ? $_GET['filtroEstado'] : "activo";
if ($filtroSeleccionado == "inactivo") {
    $sentencia = $conexion->prepare("SELECT * FROM talleres WHERE estado='inactivo'");
} else {
    $sentencia = $conexion->prepare("SELECT * FROM talleres WHERE estado='activo'");
}
$sentencia->execute();
$listaTalleres = $sentencia->fetchAll(PDO::FETCH_ASSOC);


?>