<?php

include_once("persona.php");
include_once("bd.php");

class autoridadesBD extends Conexion {

  public function CargarAutoridades($cedula, $nombre, $cargo, $fecha_inicio, $fecha_fin, $foto, $estado) {
    try {
        $conn = $this->Conectar(); 

        $sql = "INSERT INTO autoridades (cedula, nombre, cargo, fecha_inicio, fecha_fin, foto, estado)
                VALUES (:cedula, :nombre, :cargo, :fecha_inicio, :fecha_fin, :foto, :estado)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':cargo', $cargo);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':estado', $estado);
        $stmt->execute();

        echo "<script>alert('Autoridad agregada correctamente');</script>";

    } catch (PDOException $e) {
        echo "Error al insertar autoridad: " . $e->getMessage();
    }
}


    public function ListarAutoridades() {
        $con = $this->Conectar();
        $sql = "SELECT * FROM autoridades";
        $stmt = $con->prepare($sql);

        if (!$stmt) die("Error preparando consulta: " . $con->errorInfo()[2]);

        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $ListaAutoridades = [];
        foreach ($resultado as $fila) {
            $autoridad = new Autoridades();
            $autoridad->setId($fila['id']);
            $autoridad->setCedula($fila['cedula']);
            $autoridad->setNombre($fila['nombre']);
            $autoridad->setCargo($fila['cargo']);
            $autoridad->setFecha_inicio($fila['fecha_inicio']);
            $autoridad->setFecha_fin($fila['fecha_fin']);
            $autoridad->setFoto($fila['foto']);
            $autoridad->setEstado($fila['estado']);
            $ListaAutoridades[] = $autoridad;
        }

        return $ListaAutoridades;
    }
}


class Autoridades extends Conexion {
    private $id;
    private $cedula;
    private $nombre;
    private $cargo;
    private $fecha_inicio;
    private $fecha_fin;
    private $foto;
    private $estado;

    // ID
    public function setId($id){ $this->id = $id; }
    public function getId(){ return $this->id; }

    // Cédula
    public function setCedula($cedula){ $this->cedula = $cedula; }
    public function getCedula(){ return $this->cedula; }

    // Nombre
    public function setNombre($nombre){ $this->nombre = $nombre; }
    public function getNombre(){ return $this->nombre; }

    // Cargo
    public function setCargo($cargo){ $this->cargo = $cargo; }
    public function getCargo(){ return $this->cargo; }

    // Fechas
    public function setFecha_inicio($fecha_inicio){ $this->fecha_inicio = $fecha_inicio; }
    public function getFecha_inicio(){ return $this->fecha_inicio; }

    public function setFecha_fin($fecha_fin){ $this->fecha_fin = $fecha_fin; }
    public function getFecha_fin(){ return $this->fecha_fin; }

    // Foto
    public function setFoto($foto){ $this->foto = $foto; }
    public function getFoto(){ return $this->foto; }

    // Estado
    public function setEstado($estado){ $this->estado = $estado; }
    public function getEstado(){ return $this->estado; }

    // Operaciones
    public function ListarAutoridades() {
        $autoridadesBD = new autoridadesBD();
        return $autoridadesBD->ListarAutoridades();
    }

    public function CargarAutoridades() {
    $autoridadesBD = new autoridadesBD();
    return $autoridadesBD->CargarAutoridades(
        $this->cedula,
        $this->nombre,
        $this->cargo,
        $this->fecha_inicio,
        $this->fecha_fin,
        $this->foto,
        $this->estado
    );
}


}


$txtID           = $_POST['id'] ?? "";
$txtCedula       = $_POST['cedula'] ?? "";
$txtNombre       = $_POST['nombre'] ?? "";
$txtCargo        = $_POST['cargo'] ?? "";
$txtFecha_inicio = $_POST['fecha_inicio'] ?? "";
$txtFecha_fin    = $_POST['fecha_fin'] ?? "";
$txtestado       = $_POST['estado'] ?? "";

// ------------------ AGREGAR ------------------
if (isset($_POST['agregar'])) {
    $autoridad = new Autoridades();
    $autoridad->setCedula($txtCedula);
    $autoridad->setNombre($txtNombre); 
    $autoridad->setCargo($txtCargo);
    $autoridad->setFecha_inicio($txtFecha_inicio);
    $autoridad->setFecha_fin($txtFecha_fin);
    $autoridad->setEstado($txtestado ?: "activo");

    // Subir imagen si se seleccionó
    if (!empty($_FILES['image']['name'])) {
        include_once "../cargarimagen.php";
        $foto = CargarFoto();
        if ($foto) {
            $autoridad->setFoto($foto);
        }
    }

    // Insertar en la base
    try {
        $autoridad->CargarAutoridades();
    } catch (PDOException $e) {
        echo "Error al insertar autoridad: " . $e->getMessage();
    }
}

// ------------------ LISTAR ------------------
if (isset($_POST['ListarAutoridades'])) {
    $autoridad = new Autoridades();
    $resultados = $autoridad->ListarAutoridades();
}

// ------------------ BUSCAR ------------------
if (isset($_POST['BuscarAutoridades'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("SELECT * FROM autoridades WHERE Id = ?");
    $stmt->execute([$id]);
    $autoridadSeleccionado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Rellenar variables para mostrar en el formulario
    if ($autoridadSeleccionado) {
        $txtID           = $autoridadSeleccionado['Id'];
        $txtCedula       = $autoridadSeleccionado['cedula'];
        $txtNombre       = $autoridadSeleccionado['nombre'];
        $txtCargo        = $autoridadSeleccionado['cargo'];
        $txtFecha_inicio = $autoridadSeleccionado['fecha_inicio'];
        $txtFecha_fin    = $autoridadSeleccionado['fecha_fin'];
        $txtestado       = $autoridadSeleccionado['estado'];
    }
}

// ------------------ MODIFICAR ------------------
if (isset($_POST['Modificar'])) {
    $id = intval($_POST['id']);
    if ($id > 0) {
        $sql = "UPDATE autoridades 
                SET cedula = ?, nombre = ?, cargo = ?, fecha_inicio = ?, fecha_fin = ?, estado = ? 
                WHERE Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$txtCedula, $txtNombre, $txtCargo, $txtFecha_inicio, $txtFecha_fin, $txtestado, $id]);

        // Si se subió una nueva imagen, actualizarla
        if (!empty($_FILES['image']['name'])) {
            include_once "../cargarimagen.php";
            $foto = CargarFoto();
            if ($foto) {
                $stmtFoto = $conn->prepare("UPDATE autoridades SET foto = ? WHERE Id = ?");
                $stmtFoto->execute([$foto, $id]);
            }
        }
        echo "<script>alert('Autoridad modificada correctamente');</script>";
    } else {
        echo "<script>alert('Seleccione una autoridad antes de modificar');</script>";
    }
}

// ------------------ LIMPIAR ------------------
if (isset($_POST['Limpiar'])) {
    $txtID = $txtCedula = $txtNombre = $txtCargo = $txtFecha_inicio = $txtFecha_fin = $txtestado = "";
    $autoridadSeleccionado = null;
}






?>


