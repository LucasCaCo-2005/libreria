<?php
// --- Captura de datos del formulario ---
$txtID        = isset($_POST['txtID']) ? $_POST['txtID'] : "";
$txtNombre    = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : "";
$txtCedula    = isset($_POST['txtCedula']) ? $_POST['txtCedula'] : "";
$txtDomicilio = isset($_POST['txtDomicilio']) ? $_POST['txtDomicilio'] : "";
$txtTelefono  = isset($_POST['txtTelefono']) ? $_POST['txtTelefono'] : "";
$txtpuesto    = isset($_POST['txtpuesto']) ? $_POST['txtpuesto'] : "";
$txtestado    = isset($_POST['txtestado']) ? $_POST['txtestado'] : "";
$accion       = isset($_POST['accion']) ? $_POST['accion'] : "";

include("bd.php");

// --- Listar todos los trabajadores (siempre se carga al entrar en la página) ---
$sentencia = $conexion->prepare("SELECT * FROM trabajadores");
$sentencia->execute();
$listaTrabajadores = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// --- Procesar acciones del formulario ---
switch($accion) {

    case "Agregar":
        $sentencia = $conexion->prepare("
            INSERT INTO trabajadores (nombre, cedula, domicilio, telefono, puesto, estado)
            VALUES (:nombre, :cedula, :domicilio, :telefono, :puesto, :estado)
        ");
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':cedula', $txtCedula);
        $sentencia->bindParam(':domicilio', $txtDomicilio);
        $sentencia->bindParam(':telefono', $txtTelefono);
        $sentencia->bindParam(':puesto', $txtpuesto);
        $sentencia->bindParam(':estado', $txtestado);
        $sentencia->execute();

        header("Location: Trab.php");
        break;


    case "Seleccionar":
        $sentencia = $conexion->prepare("SELECT * FROM trabajadores WHERE id = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $Trab = $sentencia->fetch(PDO::FETCH_ASSOC);

        if($Trab){
            $txtNombre    = $Trab['nombre'];
            $txtCedula    = $Trab['cedula'];
            $txtDomicilio = $Trab['domicilio'];
            $txtTelefono  = $Trab['telefono'];
            $txtpuesto    = $Trab['puesto'];
            $txtestado    = $Trab['estado'];
        }
        break;


    case "Modificar":
        $sentencia = $conexion->prepare("
            UPDATE trabajadores SET
                nombre = :nombre,
                cedula = :cedula,
                domicilio = :domicilio,
                telefono = :telefono,
                puesto = :puesto,
                estado = :estado
            WHERE id = :id
        ");
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':cedula', $txtCedula);
        $sentencia->bindParam(':domicilio', $txtDomicilio);
        $sentencia->bindParam(':telefono', $txtTelefono);
        $sentencia->bindParam(':puesto', $txtpuesto);
        $sentencia->bindParam(':estado', $txtestado);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();

        header("Location: Trab.php");
        break;


    case "Cancelar":
        header("Location: Trab.php");
        break;
}

// Consultar el médico activo
$sentencia = $conexion->prepare("SELECT * FROM trabajadores WHERE puesto = 'Medico' AND estado = 'activo' LIMIT 1");
$sentencia->execute();
$medico = $sentencia->fetch(PDO::FETCH_ASSOC);

// Consultar el podólogo activo
$sentencia = $conexion->prepare("SELECT * FROM trabajadores WHERE puesto = 'Podologo' AND estado = 'activo' LIMIT 1");
$sentencia->execute();
$podologo = $sentencia->fetch(PDO::FETCH_ASSOC);

?>
