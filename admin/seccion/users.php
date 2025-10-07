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

include("config/bd.php");
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

    
        case "Pagar":
    $mesActual = date("F Y");
    $fechaHoy = date("Y-m-d");

    $sentencia = $conexion->prepare("INSERT INTO pagos (socio_id, fecha_pago, mes_pagado) 
                                     VALUES (:socio_id, :fecha_pago, :mes_pagado)");
    $sentencia->bindParam(':socio_id', $txtID);
    $sentencia->bindParam(':fecha_pago', $fechaHoy);
    $sentencia->bindParam(':mes_pagado', $mesActual);
    $sentencia->execute();
    break;

    case "QuitarPago":
        $sentencia = $conexion->prepare("DELETE FROM pagos WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
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


    



?>
