<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtApellido = (isset($_POST['txtApellido'])) ? $_POST['txtApellido'] : "";
$txtCedula = (isset($_POST['txtCedula'])) ? $_POST['txtCedula'] : "";
$txtDomicilio = (isset($_POST['txtDomicilio'])) ? $_POST['txtDomicilio'] : "";
$txtTelefono = (isset($_POST['txtTelefono'])) ? $_POST['txtTelefono'] : "";
$txtCorreo = (isset($_POST['txtCorreo'])) ? $_POST['txtCorreo'] : "";
$txtContraseña = (isset($_POST['txtContraseña'])) ? $_POST['txtContraseña'] : "";
$txtestado = (isset($_POST['txtestado'])) ? $_POST['txtestado'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : ""; 

include("bd.php");
// Obtener la lista de usuarios
$sentencia = $conexion->prepare("SELECT * FROM socios"); $sentencia->execute(); $listaSocios = $sentencia->fetchAll(PDO::FETCH_ASSOC); switch($accion){
case "Agregar":
    $sentencia = $conexion->prepare("INSERT INTO socios 
        (nombre, apellidos, cedula, domicilio, telefono, correo, contrasena, estado) 
        VALUES (:nombre, :apellidos, :cedula, :domicilio, :telefono, :correo, :contrasena, :estado)");
    $sentencia->bindParam(':nombre', $txtNombre);
    $sentencia->bindParam(':apellidos', $txtApellido);
    $sentencia->bindParam(':cedula', $txtCedula);
    $sentencia->bindParam(':domicilio', $txtDomicilio);
    $sentencia->bindParam(':telefono', $txtTelefono);
    $sentencia->bindParam(':correo', $txtCorreo);
    $sentencia->bindParam(':contrasena', $txtContraseña);
    $sentencia->bindParam(':estado', $txtestado);

    $sentencia->execute();
    header("Location: socios.php");
    break;

    case "Eliminar":
        $sentencia = $conexion->prepare("DELETE FROM socios WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        header("Location: socios.php");
        break;

    case "Seleccionar":
        $sentencia = $conexion->prepare("SELECT * FROM socios WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $socio = $sentencia->fetch(PDO::FETCH_ASSOC);
        $txtNombre = $socio['nombre'];
        $txtApellido = $socio['apellidos'];
        $txtCedula = $socio['cedula'];
        $txtDomicilio = $socio['domicilio'];
        $txtTelefono = $socio['telefono'];
        $txtCorreo = $socio['correo'];
        $txtContraseña = $socio['contrasena'];
        $txtestado = $socio['estado'];
        break;

  case "Modificar": 
    $sentencia = $conexion->prepare("UPDATE socios 
        SET nombre=:nombre, 
            apellidos=:apellidos, 
            cedula=:cedula, 
            domicilio=:domicilio, 
            telefono=:telefono, 
            correo=:correo, 
            contrasena=:contrasena
            , estado=:estado
        WHERE id=:id");

    $sentencia->bindParam(':nombre', $txtNombre);
    $sentencia->bindParam(':apellidos', $txtApellido);
    $sentencia->bindParam(':cedula', $txtCedula);
    $sentencia->bindParam(':domicilio', $txtDomicilio);
    $sentencia->bindParam(':telefono', $txtTelefono);
    $sentencia->bindParam(':correo', $txtCorreo);
    $sentencia->bindParam(':contrasena', $txtContraseña);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->bindParam(':estado', $txtestado);
    $sentencia->execute();
    header("Location: socios.php");
    break;

    case "Cancelar":
        header("Location: socios.php");
        break;

}
$filtro = "";
$parametros = [];

if (isset($_GET['filtroEstado']) && $_GET['filtroEstado'] != "") {
    $filtro = " WHERE estado = :estado ";
    $parametros[':estado'] = $_GET['filtroEstado'];
}
$sentenciaSQL = $conexion->prepare("SELECT * FROM socios $filtro");
$sentenciaSQL->execute($parametros);
$listaSocios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$filtroSeleccionado = isset($_GET['filtroEstado']) ? $_GET['filtroEstado'] : "activo";
if ($filtroSeleccionado == "inactivo") {
    $sentencia = $conexion->prepare("SELECT * FROM socios WHERE estado='inactivo'");
} else {
    $sentencia = $conexion->prepare("SELECT * FROM socios WHERE estado='activo'");
}
$sentencia->execute();
$listaSocios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$mesActual = date("F Y");
$sentenciaPagos = $conexion->prepare("SELECT p.*, s.nombre, s.apellidos 
                                      FROM pagos p
                                      INNER JOIN socios s ON p.socio_id = s.id
                                      WHERE p.mes_pagado = :mes");
$sentenciaPagos->bindParam(':mes', $mesActual);
$sentenciaPagos->execute();
$listaPagos = $sentenciaPagos->fetchAll(PDO::FETCH_ASSOC);

$sentenciaContador = $conexion->prepare("SELECT COUNT(*) as total FROM pagos WHERE mes_pagado = :mes");
$sentenciaContador->bindParam(':mes', $mesActual);
$sentenciaContador->execute();
$totalPagos = $sentenciaContador->fetch(PDO::FETCH_ASSOC)['total'];

class socios{
    private $id;
    private $nombre;
    private $apellidos;
    private $cedula;
    private $domicilio;
    private $telefono;
    private $correo;
    private $contrasena;
    private $estado;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    public function getDomicilio() {
        return $this->domicilio;
    }

    public function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
    }
    if (isset($_POST['socio_id'], $_POST['nuevo_estado'])) {
    $socio_id = $_POST['socio_id'];
    $nuevo_estado = $_POST['nuevo_estado'];

    $stmt = $conexion->prepare("UPDATE socios SET estado = ? WHERE id = ?");
    $stmt->execute([$nuevo_estado, $socio_id]);

    header("Location: SociosT.php");
    exit();
}
// Verificamos si viene el socio_id por GET
if (isset($_GET['socio_id'])) {
    $socio_id = $_GET['socio_id'];
   // Consultamos el socio en la base de datos
    $stmt = $conexion->prepare("SELECT * FROM socios WHERE id = ?");
    $stmt->execute([$socio_id]);
    $socio = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($socio) {
        // Llenamos las variables con los datos del socio
        $txtID = $socio['id'];
        $txtNombre = $socio['nombre'];
        $txtApellido = $socio['apellidos'];
        $txtCedula = $socio['cedula'];
        $txtDomicilio = $socio['domicilio'];
        $txtTelefono = $socio['telefono'];
        $txtCorreo = $socio['correo'];
        $txtestado = $socio['estado'];
    } else {
        // Si el ID no existe, inicializamos vacíos
        $txtID = $txtNombre = $txtApellido = $txtCedula = $txtDomicilio = $txtTelefono = $txtCorreo = $txtestado = "";
    }
} else {
    // Si no hay socio_id, el formulario está vacío (modo agregar)
    $txtID = $txtNombre = $txtApellido = $txtCedula = $txtDomicilio = $txtTelefono = $txtCorreo = $txtestado = "";
}









?>



