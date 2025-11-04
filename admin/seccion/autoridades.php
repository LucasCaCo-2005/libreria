<?php
// Inicializar variables
$txtID = $txtCedula = $txtNombre = $txtCargo = $txtFecha_inicio = $txtFecha_fin = $txtEstado = "";
$foto_actual = "";
$listaAutoridades = [];

// Recuperar valores del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $txtID = $_POST['txtID'] ?? "";
    $txtCedula = $_POST['txtCedula'] ?? "";
    $txtNombre = $_POST['txtNombre'] ?? "";
    $txtCargo = $_POST['txtCargo'] ?? "";
    $txtFecha_inicio = $_POST['txtFecha_inicio'] ?? "";
    $txtFecha_fin = $_POST['txtFecha_fin'] ?? "";
    $txtEstado = $_POST['txtEstado'] ?? "activo";
    $accion = $_POST['accion'] ?? "";
} else {
    $accion = "Listar"; // Acción por defecto al cargar la página
}

// Incluir archivo de conexión
include("bd.php");

// Función para cargar imagen
function cargarImagen() {
    if (!empty($_FILES['image']['name'])) {
        $directorio = "../images/";
        $archivo = $directorio . basename($_FILES['image']['name']);
        $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        
        // Validar que es una imagen
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            return null;
        }
        
        // Generar nombre único
        $nombreArchivo = uniqid() . '.' . $tipoArchivo;
        $archivoDestino = $directorio . $nombreArchivo;
        
        // Mover archivo
        if (move_uploaded_file($_FILES['image']['tmp_name'], $archivoDestino)) {
            return $nombreArchivo;
        }
    }
    return null;
}

// Procesar acciones
switch($accion) {
    case "Agregar":
        $foto = cargarImagen();
        
        $sentencia = $conexion->prepare("
            INSERT INTO autoridades (cedula, nombre, cargo, fecha_inicio, fecha_fin, foto, estado)
            VALUES (:cedula, :nombre, :cargo, :fecha_inicio, :fecha_fin, :foto, :estado)
        ");
        
        $sentencia->bindParam(':cedula', $txtCedula);
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':cargo', $txtCargo);
        $sentencia->bindParam(':fecha_inicio', $txtFecha_inicio);
        $sentencia->bindParam(':fecha_fin', $txtFecha_fin);
        $sentencia->bindParam(':foto', $foto);
        $sentencia->bindParam(':estado', $txtEstado);
        
        if ($sentencia->execute()) {
            // Limpiar formulario después de agregar
            $txtID = $txtCedula = $txtNombre = $txtCargo = $txtFecha_inicio = $txtFecha_fin = "";
            $txtEstado = "activo";
            echo "<script>alert('Autoridad agregada correctamente');</script>";
        } else {
            echo "<script>alert('Error al agregar la autoridad');</script>";
        }
        break;

    case "Seleccionar":
        $sentencia = $conexion->prepare("SELECT * FROM autoridades WHERE id = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $autoridad = $sentencia->fetch(PDO::FETCH_ASSOC);
        
        if ($autoridad) {
            $txtCedula = $autoridad['cedula'];
            $txtNombre = $autoridad['nombre'];
            $txtCargo = $autoridad['cargo'];
            $txtFecha_inicio = $autoridad['fecha_inicio'];
            $txtFecha_fin = $autoridad['fecha_fin'];
            $txtEstado = $autoridad['estado'];
            $foto_actual = $autoridad['foto'];
            
            echo "<script>alert('Autoridad seleccionada para edición: {$autoridad['nombre']}');</script>";
        } else {
            echo "<script>alert('Error: No se encontró la autoridad');</script>";
        }
        break;

    case "Modificar":
        if (!empty($txtID)) {
            // Si hay nueva imagen, cargarla
            $nueva_foto = cargarImagen();
            
            if ($nueva_foto) {
                // Actualizar con nueva foto
                $sentencia = $conexion->prepare("
                    UPDATE autoridades SET
                        cedula = :cedula,
                        nombre = :nombre,
                        cargo = :cargo,
                        fecha_inicio = :fecha_inicio,
                        fecha_fin = :fecha_fin,
                        foto = :foto,
                        estado = :estado
                    WHERE id = :id
                ");
                $sentencia->bindParam(':foto', $nueva_foto);
            } else {
                // Mantener foto actual
                $sentencia = $conexion->prepare("
                    UPDATE autoridades SET
                        cedula = :cedula,
                        nombre = :nombre,
                        cargo = :cargo,
                        fecha_inicio = :fecha_inicio,
                        fecha_fin = :fecha_fin,
                        estado = :estado
                    WHERE id = :id
                ");
            }
            
            $sentencia->bindParam(':cedula', $txtCedula);
            $sentencia->bindParam(':nombre', $txtNombre);
            $sentencia->bindParam(':cargo', $txtCargo);
            $sentencia->bindParam(':fecha_inicio', $txtFecha_inicio);
            $sentencia->bindParam(':fecha_fin', $txtFecha_fin);
            $sentencia->bindParam(':estado', $txtEstado);
            $sentencia->bindParam(':id', $txtID);
            
            if ($sentencia->execute()) {
                // Limpiar formulario después de modificar
                $txtID = $txtCedula = $txtNombre = $txtCargo = $txtFecha_inicio = $txtFecha_fin = "";
                $txtEstado = "activo";
                $foto_actual = "";
                echo "<script>alert('Autoridad modificada correctamente');</script>";
            } else {
                echo "<script>alert('Error al modificar la autoridad');</script>";
            }
        }
        break;

    case "Eliminar":
        if (!empty($txtID)) {
            $sentencia = $conexion->prepare("DELETE FROM autoridades WHERE id = :id");
            $sentencia->bindParam(':id', $txtID);
            
            if ($sentencia->execute()) {
                echo "<script>alert('Autoridad eliminada correctamente');</script>";
            } else {
                echo "<script>alert('Error al eliminar la autoridad');</script>";
            }
        }
        break;

    case "Cancelar":
        // Limpiar todo
        $txtID = $txtCedula = $txtNombre = $txtCargo = $txtFecha_inicio = $txtFecha_fin = "";
        $txtEstado = "activo";
        $foto_actual = "";
        break;
        
}

// Siempre listar las autoridades (excepto en redirecciones)
if ($accion !== "Agregar" && $accion !== "Modificar" && $accion !== "Eliminar") {
    $sentencia = $conexion->prepare("SELECT * FROM autoridades ORDER BY cargo, nombre");
    $sentencia->execute();
    $listaAutoridades = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}
?>