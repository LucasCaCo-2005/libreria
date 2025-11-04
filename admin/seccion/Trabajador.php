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

// Variable para controlar mensajes
$mostrarMensaje = "";

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
        // Validar que los campos requeridos no estén vacíos
        if (!empty($txtNombre) && !empty($txtCedula) && !empty($txtpuesto)) {
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
            
            if ($sentencia->execute()) {
                // Limpiar formulario después de agregar exitosamente
                $txtID = $txtNombre = $txtCedula = $txtDomicilio = $txtTelefono = "";
                $txtpuesto = $txtestado = "";
                $mostrarMensaje = "success|Trabajador agregado correctamente";
            } else {
                $mostrarMensaje = "error|Error al agregar el trabajador";
            }
        } else {
            $mostrarMensaje = "error|Por favor complete todos los campos requeridos";
        }
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
            $mostrarMensaje = "info|Trabajador seleccionado para edición: {$Trab['nombre']}";
        } else {
            $mostrarMensaje = "error|Error: No se encontró el trabajador";
        }
        break;

    case "Modificar": // update de datos
        if (!empty($txtID)) {
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
            
            if ($sentencia->execute()) {
                // Limpiar formulario después de modificar exitosamente
                $txtID = $txtNombre = $txtCedula = $txtDomicilio = $txtTelefono = "";
                $txtpuesto = $txtestado = "";
                $mostrarMensaje = "success|Trabajador modificado correctamente";
            } else {
                $mostrarMensaje = "error|Error al modificar el trabajador";
            }
        } else {
            $mostrarMensaje = "error|Seleccione un trabajador antes de modificar";
        }
        break;

    case "Cancelar":
        // Limpiar todo sin mostrar mensaje
        $txtID = $txtNombre = $txtCedula = $txtDomicilio = $txtTelefono = "";
        $txtpuesto = $txtestado = "";
        // NO mostrar mensaje para Cancelar
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