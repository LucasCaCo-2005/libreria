<?php
// Recupera valores enviados por POST
$txtID = $_POST['txtID'] ?? "";
$txtsocio = $_POST['txtsocio'] ?? "";
$txtNombre = $_POST['txtNombre'] ?? "";
$txtCedula = $_POST['txtCedula'] ?? "";
$txtDomicilio = $_POST['txtDomicilio'] ?? "";
$txtTelefono = $_POST['txtTelefono'] ?? "";
$txtCorreo = $_POST['txtCorreo'] ?? "";
$txtcon = $_POST['txtcon'] ?? "";
$txtestado = $_POST['txtestado'] ?? "";
$accion = $_POST['accion'] ?? "";

include("bd.php");
// Sistema de filtrado por estado
$filtro = "";
$parametros = [];
$limit = "";

if (isset($_GET['filtroEstado']) && $_GET['filtroEstado'] != "") {
    $filtro = " WHERE estado = :estado ";
    $parametros[':estado'] = $_GET['filtroEstado'];
    $limit = " LIMIT 12"; // Solo limitar cuando hay filtro
}

$sql = "SELECT * FROM socios $filtro ORDER BY id DESC $limit";
$sentencia = $conexion->prepare($sql);
$sentencia->execute($parametros);
$listaSocios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

switch($accion) {
    case "Agregar":
        $sentencia = $conexion->prepare("INSERT INTO socios 
            (socio, nombre, cedula, domicilio, telefono, correo, contrasena, estado) 
            VALUES (:socio, :nombre, :cedula, :domicilio, :telefono, :correo, :contrasena, :estado)");
        
        $sentencia->bindParam(':socio', $txtsocio);
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':cedula', $txtCedula);
        $sentencia->bindParam(':domicilio', $txtDomicilio);
        $sentencia->bindParam(':telefono', $txtTelefono);
        $sentencia->bindParam(':correo', $txtCorreo);
        $sentencia->bindParam(':contrasena', $txtcon);
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
        
        if ($socio) {
            $txtsocio = $socio['socio'];
            $txtNombre = $socio['nombre'];
            $txtCedula = $socio['cedula'];
            $txtDomicilio = $socio['domicilio'];
            $txtTelefono = $socio['telefono'];
            $txtCorreo = $socio['correo'];
            $txtcon = $socio['contrasena'];
            $txtestado = $socio['estado'];
        }
        break;
        
    case "Modificar":
        $sentencia = $conexion->prepare("UPDATE socios 
            SET socio=:socio,
                nombre=:nombre, 
                cedula=:cedula, 
                domicilio=:domicilio, 
                telefono=:telefono, 
                correo=:correo, 
                contrasena=:contrasena,
                estado=:estado
            WHERE id=:id");
        
        $sentencia->bindParam(':socio', $txtsocio);
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':cedula', $txtCedula);
        $sentencia->bindParam(':domicilio', $txtDomicilio);
        $sentencia->bindParam(':telefono', $txtTelefono);
        $sentencia->bindParam(':correo', $txtCorreo);
        $sentencia->bindParam(':contrasena', $txtcon);
        $sentencia->bindParam(':estado', $txtestado);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        
        header("Location: socios.php");
        break;
        
    case "Cancelar":
        header("Location: socios.php");
        break;
}

// Actualización de estado desde sociosT.php
if (isset($_POST['socio_id'], $_POST['nuevo_estado'])) {
    $socio_id = $_POST['socio_id'];
    $nuevo_estado = $_POST['nuevo_estado'];
    
    $stmt = $conexion->prepare("UPDATE socios SET estado = ? WHERE id = ?");
    $stmt->execute([$nuevo_estado, $socio_id]);
    
    header("Location: SociosT.php");
    exit();
}
?>