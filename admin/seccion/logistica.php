<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : ""; 
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : ""; 
$txtIMG = (isset($_FILES['txtIMG']['name'])) ? $_FILES['txtIMG']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
$txtfecha = (isset($_POST['txtfecha'])) ? $_POST['txtfecha'] : ""; 
$txtAutor = (isset($_POST['txtAutor'])) ? $_POST['txtAutor'] : "";
$txtCat = (isset($_POST['txtCat'])) ? $_POST['txtCat'] : "";
$txtStock = (isset($_POST['txtStock'])) ? $_POST['txtStock'] : ""; 

$txtDesc = (isset($_POST['txtDesc'])) ? $_POST['txtDesc'] : ""; 

include("bd.php");

// Función para redireccionar
function redirect($url) {
    echo "<script>window.location.href = '$url';</script>";
    exit();
}

switch($accion) {
    case 'Agregar':
        $sentencia = $conexion->prepare("INSERT INTO `libros` (nombre, fecha, autor, categoria, stock, descripcion, imagen) VALUES (:nombre, :fecha, :autor, :categoria, :stock, :descripcion, :imagen);");
        
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':fecha', $txtfecha);
        $sentencia->bindParam(':autor', $txtAutor);
             $sentencia->bindParam(':categoria', $txtCat); // Nueva categoría
        $sentencia->bindParam(':stock', $txtStock); 
        $sentencia->bindParam(':descripcion', $txtDesc); 
   
        
        $fecha = new DateTime(); 
        $nombreArchivo = ($txtIMG != "")? $fecha->getTimestamp() . "_" . $_FILES['txtIMG']['name'] : "imagen.jpg";
        $tmpImagen = $_FILES['txtIMG']['tmp_name']; 
        
        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../images/" . $nombreArchivo); 
        }
        
        $sentencia->bindParam(':imagen', $nombreArchivo);
        $sentencia->execute();        
        redirect("productos.php?mensaje=¡Libro agregado exitosamente!");
        break;
        
    case 'Modificar':
      
        $sentencia = $conexion->prepare("UPDATE libros SET nombre=:nombre, fecha=:fecha, autor=:autor, stock=:stock, descripcion=:descripcion, categoria=:categoria WHERE id=:id");
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':fecha', $txtfecha);
        $sentencia->bindParam(':autor', $txtAutor);
        $sentencia->bindParam(':stock', $txtStock);
        $sentencia->bindParam(':descripcion', $txtDesc);
        $sentencia->bindParam(':categoria', $txtCat); 
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();

        // Si se subió una imagen nueva
        if ($txtIMG != "") {
            // Generar nombre único para la imagen
            $fecha = new DateTime();
            $nombreArchivo = $fecha->getTimestamp() . "_" . $_FILES['txtIMG']['name'];

            // Mover la imagen al servidor
            $tmpImagen = $_FILES['txtIMG']['tmp_name'];
            if ($tmpImagen != "") {
                move_uploaded_file($tmpImagen, "../../images/" . $nombreArchivo);
            }
            // Actualizar el nombre de la imagen en la base de datos
            $sentencia = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
            $sentencia->bindParam(':imagen', $nombreArchivo);
            $sentencia->bindParam(':id', $txtID);
            $sentencia->execute();
        }
        redirect("productos.php?mensaje2=Libro modificado");
        break;

    case 'Cancelar':
        redirect("productos.php");
        break;
        
    case 'Seleccionar':
        $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $libro = $sentencia->fetch(PDO::FETCH_LAZY);

        $_SESSION['libroSeleccionado'] = [
            'id' => $libro['id'],
            'nombre' => $libro['nombre'],
            'imagen' => $libro['imagen'],
            'fecha' => $libro['fecha'],
            'autor' => $libro['autor'],
            'categoria' => $libro['categoria'],
            'stock' => $libro['stock'],
            'descripcion' => $libro['descripcion']
            // Nueva categoría
        ];

        redirect("productos.php?mensaje1=Libro seleccionado");
        break;

    case 'Borrar':
        // Buscar la imagen actual
        $sentencia = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $libro = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($libro["imagen"]) && $libro["imagen"] != "imagen.jpg") {
            $rutaImagen = "../../images/" . $libro["imagen"];
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
        
        $sentencia = $conexion->prepare("DELETE FROM libros WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute(); 

        redirect("productos.php?mensaje3=Libro borrado");
        break;
}

// Cargar datos del libro seleccionado si existe
if (isset($_SESSION['libroSeleccionado'])) {
    $txtID = $_SESSION['libroSeleccionado']['id'];
    $txtNombre = $_SESSION['libroSeleccionado']['nombre'];
    $txtIMG = $_SESSION['libroSeleccionado']['imagen'];
    $txtfecha = $_SESSION['libroSeleccionado']['fecha'];
    $txtAutor = $_SESSION['libroSeleccionado']['autor'];
    $txtCat = $_SESSION['libroSeleccionado']['categoria'];
    $txtStock = $_SESSION['libroSeleccionado']['stock'];
    $txtDesc = $_SESSION['libroSeleccionado']['descripcion'];
     // Nueva categoría
    unset($_SESSION['libroSeleccionado']);
} 

// Obtener lista de libros
$sentencia = $conexion->prepare("SELECT * FROM libros ORDER BY id DESC");
$sentencia->execute();
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>