<?php
// include_once "persona.php"; 
include_once ("persona.php");
include_once ("bd.php");

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
            $taller->setCosto($fila['costo']);
            $taller->setEstado($fila['estado']);
            $ListaTalleres[] = $taller;
        }
        return $ListaTalleres;
    }

    public function CargarTalleres($nombre, $dia, $horario, $foto, $idTaller, $costo, $descripcion) {
        $con = $this->Conectar();
        $sql = "INSERT INTO talleres (nombre, dia, horario, foto, Id, descripcion, costo, estado ) VALUES (?,?,?,?,?,?,?, 'activo')";
        $stmt = $con->prepare($sql);
        if (!$stmt) die("Error preparando consulta: " . $con->error);
        $stmt->bind_param("ssssiss", $nombre, $dia, $horario, $foto, $idTaller, $costo, $descripcion );
        return $stmt->execute();
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
    $sentencia = $conexion->prepare("SELECT * FROM talleres WHERE estado='activo'");}
$sentencia->execute();
$listaTalleres = $sentencia->fetchAll(PDO::FETCH_ASSOC);

//  if (empty($listaTalleres)) {
//     echo "<p style='text-align:center;'>No hay talleres en este estado.</p>";
//     exit();
// } 
?>