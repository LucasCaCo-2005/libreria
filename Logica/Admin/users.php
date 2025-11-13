<?php

// Recupera todos los valores enviados por POST con operador ternario para evitar errores
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtsocio = (isset($_POST['txtsocio'])) ? $_POST['txtsocio'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtApellido = (isset($_POST['txtApellido'])) ? $_POST['txtApellido'] : "";
$txtCedula = (isset($_POST['txtCedula'])) ? $_POST['txtCedula'] : "";
$txtDomicilio = (isset($_POST['txtDomicilio'])) ? $_POST['txtDomicilio'] : "";
$txtTelefono = (isset($_POST['txtTelefono'])) ? $_POST['txtTelefono'] : "";
$txtCorreo = (isset($_POST['txtCorreo'])) ? $_POST['txtCorreo'] : "";
$txtcon = (isset($_POST['txtcon'])) ? $_POST['txtcon'] : "";
$txtestado = (isset($_POST['txtestado'])) ? $_POST['txtestado'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : ""; 

// Incluir archivo de conexión a base de datos
include("bd.php");
// Obtener la lista de usuarios
$sentencia = $conexion->prepare("SELECT * FROM socios"); $sentencia->execute(); $listaSocios = $sentencia->fetchAll(PDO::FETCH_ASSOC); switch($accion){
case "Agregar":// insertar socio nuevo
    $sentencia = $conexion->prepare("INSERT INTO socios 
        (socio, nombre, apellidos, cedula, domicilio, telefono, correo, contrasena, estado) 
        VALUES (:socio, :nombre, :apellidos, :cedula, :domicilio, :telefono, :correo, :contrasena, :estado)");
         // Vincular todos los parámetros para prevenir inyección SQL
        $sentencia->bindParam(':socio', $txtsocio);
    $sentencia->bindParam(':nombre', $txtNombre);
    $sentencia->bindParam(':apellidos', $txtApellido);
    $sentencia->bindParam(':cedula', $txtCedula);
    $sentencia->bindParam(':domicilio', $txtDomicilio);
    $sentencia->bindParam(':telefono', $txtTelefono);
    $sentencia->bindParam(':correo', $txtCorreo);
    $sentencia->bindParam(':contrasena', $txtcon);
    $sentencia->bindParam(':estado', $txtestado);

    $sentencia->execute();
    header("Location: socios.php");
    break;
// eliminar socio
    case "Eliminar":
        $sentencia = $conexion->prepare("DELETE FROM socios WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        header("Location: socios.php");
        break;

    case "Seleccionar":
        // seleccionar socio
        $sentencia = $conexion->prepare("SELECT * FROM socios WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $socio = $sentencia->fetch(PDO::FETCH_ASSOC);
         // Cargar datos del socio en variables para pre-llenar formulario
        $txtsocio = $socio['socio'];
        $txtNombre = $socio['nombre'];
        $txtApellido = $socio['apellidos'];
        $txtCedula = $socio['cedula'];
        $txtDomicilio = $socio['domicilio'];
        $txtTelefono = $socio['telefono'];
        $txtCorreo = $socio['correo'];
        $txtcon = $socio['contrasena'];
        $txtestado = $socio['estado'];
        break;

  case "Modificar": // update de los datos del socio
    $sentencia = $conexion->prepare("UPDATE socios 
        SET socio=:socio,
        nombre=:nombre, 
            apellidos=:apellidos, 
            cedula=:cedula, 
            domicilio=:domicilio, 
            telefono=:telefono, 
            correo=:correo, 
            contrasena=:contrasena
            , estado=:estado
        WHERE id=:id");
// Vincular parámetros incluyendo ID para la cláusula WHERE
$sentencia->bindParam(':socio', $txtsocio);
    $sentencia->bindParam(':nombre', $txtNombre);
    $sentencia->bindParam(':apellidos', $txtApellido);
    $sentencia->bindParam(':cedula', $txtCedula);
    $sentencia->bindParam(':domicilio', $txtDomicilio);
    $sentencia->bindParam(':telefono', $txtTelefono);
    $sentencia->bindParam(':correo', $txtCorreo);
    $sentencia->bindParam(':contrasena', $txtcon);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->bindParam(':estado', $txtestado);
    $sentencia->execute();
    header("Location: socios.php");
    break;

    case "Cancelar":
        header("Location: socios.php"); // vacia el formulario
        break;

}
//  sistema de filttado por estado
$filtro = "";
$parametros = [];
// Verificar si se aplicó filtro por estado
if (isset($_GET['filtroEstado']) && $_GET['filtroEstado'] != "") {
    $filtro = " WHERE estado = :estado ";
    $parametros[':estado'] = $_GET['filtroEstado'];
}
$sentenciaSQL = $conexion->prepare("SELECT * FROM socios $filtro");
$sentenciaSQL->execute($parametros);
$listaSocios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
// Consultas específicas según el filtro seleccionado
$filtroSeleccionado = isset($_GET['filtroEstado']) ? $_GET['filtroEstado'] : "activo";
if ($filtroSeleccionado == "inactivo") {
    $sentencia = $conexion->prepare("SELECT * FROM socios WHERE estado='inactivo'");
} elseif ($filtroSeleccionado == "pendiente") {
    $sentencia = $conexion->prepare("SELECT * FROM socios WHERE estado='pendiente'");
} else { // Por defecto muestra socios activos
    $sentencia = $conexion->prepare("SELECT * FROM socios WHERE estado='activo'");
}

$sentencia->execute();
$listaSocios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
// Obtener el mes actual
$mesActual = date("F Y");

// Consultar pagos del mes actual con información del socio
$sentenciaPagos = $conexion->prepare("SELECT p.*, s.nombre, s.apellidos 
                                      FROM pagos p
                                      INNER JOIN socios s ON p.socio_id = s.id
                                      WHERE p.mes_pagado = :mes");
$sentenciaPagos->bindParam(':mes', $mesActual);
$sentenciaPagos->execute();
$listaPagos = $sentenciaPagos->fetchAll(PDO::FETCH_ASSOC);
// Contar total de pagos del mes actual
$sentenciaContador = $conexion->prepare("SELECT COUNT(*) as total FROM pagos WHERE mes_pagado = :mes");
$sentenciaContador->bindParam(':mes', $mesActual);
$sentenciaContador->execute();
$totalPagos = $sentenciaContador->fetch(PDO::FETCH_ASSOC)['total'];
 //Clase que representa la entidad socio
class socios{
    private $id;
    private $socio;
    private $nombre;
    private $apellidos;
    private $cedula;
    private $domicilio;
    private $telefono;
    private $correo;
    private $contrasena;
    private $estado;
// setter y getters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

      public function getsocio() {
        return $this->socio;
    }

    public function setsocio($socio) {
        $this->socio = $socio;
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

public function RegistrarSocio($cedula, $nombre, $apellidos, $domicilio, $telefono, $correo, $contrasena, $estado) {
    try {
        // 
        $db = new Conexion();
        $con = $db->Conectar();

        // Preparar consulta
        $sql = "INSERT INTO socios (cedula, Nombre, Apellidos, Domicilio, Telefono, Correo, contrasena, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        // Ejecutar con parámetros
        $resultado = $stmt->execute([
            $cedula, 
            $nombre, 
            $apellidos, 
            $domicilio, 
            $telefono, 
            $correo, 
            $contrasena, 
            $estado
        ]);

        if ($resultado) {
            return true;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        // Mostrar el error real
        echo "<script>alert('Error al registrar socio: " . $e->getMessage() . "');</script>";
        return false;
    }
}



    //metodo para el login 
public function login($cedula, $contrasena) {
    // Creamos la conexión usando la clase Conexion
    $conexion = new Conexion(); // instancia de la clase Conexion
    $con = $conexion->Conectar(); // método que devuelve el PDO

    // Preparar la consulta
    $sql = "SELECT * FROM socios WHERE cedula = :cedula AND contrasena = :contrasena";
    $stmt = $con->prepare($sql);

    // Usar los parámetros para obtener cedula y contraseña
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':contrasena', $contrasena);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve la fila encontrada o false
}



    }
    if (isset($_POST['socio_id'], $_POST['nuevo_estado'])) {
    $socio_id = $_POST['socio_id'];
    $nuevo_estado = $_POST['nuevo_estado'];
 // Actualizar estado del socio
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
        $txtsocio = $socio['socio'];
        $txtNombre = $socio['nombre'];
        $txtApellido = $socio['apellidos'];
        $txtCedula = $socio['cedula'];
        $txtDomicilio = $socio['domicilio'];
        $txtTelefono = $socio['telefono'];
        $txtCorreo = $socio['correo'];
        $txtestado = $socio['estado'];
    } else {
        // Si el ID no existe, inicializamos vacíos
        $txtID = $txtsocio = $txtNombre = $txtApellido = $txtCedula = $txtDomicilio = $txtTelefono = $txtCorreo = $txtestado = "";
    }
} else {
    // Si no hay socio_id, el formulario está vacío 
    $txtID = $txtsocio = $txtNombre = $txtApellido = $txtCedula = $txtDomicilio = $txtTelefono = $txtCorreo = $txtestado = "";
}









?>



