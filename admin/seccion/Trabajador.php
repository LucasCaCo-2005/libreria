<?php
// Recupera los valores enviados por POST usando operador ternario para evitar errores si no existen
$txtID        = isset($_POST['txtID']) ? $_POST['txtID'] : "";
$txtNombre    = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : "";
$txtCedula    = isset($_POST['txtCedula']) ? $_POST['txtCedula'] : "";
$txtDomicilio = isset($_POST['txtDomicilio']) ? $_POST['txtDomicilio'] : "";
$txtTelefono  = isset($_POST['txtTelefono']) ? $_POST['txtTelefono'] : "";
$txtpuesto    = isset($_POST['txtpuesto']) ? $_POST['txtpuesto'] : "";
$txtestado    = isset($_POST['txtestado']) ? $_POST['txtestado'] : "";
$accion       = isset($_POST['accion']) ? $_POST['accion'] : "";


// Incluir archivo de conexión a la base de datos
include("bd.php");

// Lista a todos los trabajadores, esta consulta se ejecuta siempre al cargar la pagina.
$sentencia = $conexion->prepare("SELECT * FROM trabajadores");
$sentencia->execute();
// Obtiene todos los registros como array asociativo
$listaTrabajadores = $sentencia->fetchAll(PDO::FETCH_ASSOC);
// Switch que maneja las diferentes operaciones CRUD basadas en la acción recibida
switch($accion) {

    case "Agregar": // hace insert de un nuevo trabajador
        $sentencia = $conexion->prepare("
            INSERT INTO trabajadores (nombre, cedula, domicilio, telefono, puesto, estado)
            VALUES (:nombre, :cedula, :domicilio, :telefono, :puesto, :estado)
        ");
      // Vincula parámetros para prevenir inyección SQL
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':cedula', $txtCedula);
        $sentencia->bindParam(':domicilio', $txtDomicilio);
        $sentencia->bindParam(':telefono', $txtTelefono);
        $sentencia->bindParam(':puesto', $txtpuesto);
        $sentencia->bindParam(':estado', $txtestado);
        $sentencia->execute();
 // Redirigir para evitar reenvío del formulario
        header("Location: Trab.php");
        break;


    case "Seleccionar": // selecciona un trabajador
        $sentencia = $conexion->prepare("SELECT * FROM trabajadores WHERE id = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
         // Obtener un solo registro
        $Trab = $sentencia->fetch(PDO::FETCH_ASSOC);
 // Si se encontró el trabajador, cargar sus datos en las variables del formulario
        if($Trab){
            $txtNombre    = $Trab['nombre'];
            $txtCedula    = $Trab['cedula'];
            $txtDomicilio = $Trab['domicilio'];
            $txtTelefono  = $Trab['telefono'];
            $txtpuesto    = $Trab['puesto'];
            $txtestado    = $Trab['estado'];
        }
        break;


    case "Modificar": // update de datos
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
        // Vincular todos los parámetros incluyendo el ID para la cláusula WHERE
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':cedula', $txtCedula);
        $sentencia->bindParam(':domicilio', $txtDomicilio);
        $sentencia->bindParam(':telefono', $txtTelefono);
        $sentencia->bindParam(':puesto', $txtpuesto);
        $sentencia->bindParam(':estado', $txtestado);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
// Redirigir para actualizar la vista
        header("Location: Trab.php");
        break;
   // Simplemente redirige sin guardar cambios

    case "Cancelar":
        header("Location: Trab.php");
        break;
}

// Busca un trabajador con puesto "Medico" y estado "activo"
$sentencia = $conexion->prepare("SELECT * FROM trabajadores WHERE puesto = 'Medico' AND estado = 'activo' LIMIT 1");
$sentencia->execute();
// Obtiene el primer médico activo encontrado
$medico = $sentencia->fetch(PDO::FETCH_ASSOC);

// Busca un trabajador con puesto "Podologo" y estado "activo"
$sentencia = $conexion->prepare("SELECT * FROM trabajadores WHERE puesto = 'Podologo' AND estado = 'activo' LIMIT 1");
$sentencia->execute();
// Obtiene el primer podólogo activo encontrado
$podologo = $sentencia->fetch(PDO::FETCH_ASSOC);

?>
