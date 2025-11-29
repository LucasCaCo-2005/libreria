<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Recupera datos enviados por POST, maneja texto e imagenes.
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : ""; 
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : ""; 
$txtIMG = (isset($_FILES['txtIMG']['name'])) ? $_FILES['txtIMG']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
$txtfecha = (isset($_POST['txtfecha'])) ? $_POST['txtfecha'] : ""; 
$txtAutor = (isset($_POST['txtAutor'])) ? $_POST['txtAutor'] : "";
$txtCat = (isset($_POST['txtCat'])) ? $_POST['txtCat'] : "";
$txtStock = (isset($_POST['txtStock'])) ? $_POST['txtStock'] : ""; 

$txtDesc = (isset($_POST['txtDesc'])) ? $_POST['txtDesc'] : ""; 

include("bd.php"); // conexion a base de datos

// Función para redireccionar usando java script
function redirect($url) {
    echo "<script>window.location.href = '$url';</script>";
    exit();
}

switch($accion) { // CRUD
    case 'Agregar': //Prepara insert para nuevos libros
        $sentencia = $conexion->prepare("INSERT INTO `libros` (nombre, fecha, autor, categoria, stock, descripcion, imagen) VALUES (:nombre, :fecha, :autor, :categoria, :stock, :descripcion, :imagen);");
        
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':fecha', $txtfecha);
        $sentencia->bindParam(':autor', $txtAutor);
             $sentencia->bindParam(':categoria', $txtCat); 
        $sentencia->bindParam(':stock', $txtStock); 
        $sentencia->bindParam(':descripcion', $txtDesc); 
   
        
        $fecha = new DateTime(); 
        $nombreArchivo = ($txtIMG != "")? $fecha->getTimestamp() . "_" . $_FILES['txtIMG']['name'] : "imagen.jpg";
        $tmpImagen = $_FILES['txtIMG']['tmp_name']; // genera un unico nombre para la imagen en base con timestap
        
        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../imagenes/Lib" . $nombreArchivo); // sube las imagenes a una carpeta
        }
        
        $sentencia->bindParam(':imagen', $nombreArchivo);
        $sentencia->execute();        
        redirect("productos.php?mensaje=¡Libro agregado exitosamente!");
        break;
        
    case 'Modificar': //Update de los datos del libro
      
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
                move_uploaded_file($tmpImagen, "../../imagenes/Lib" . $nombreArchivo);
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
        redirect("productos.php"); // redirije a la pagina, es para vaciar el formulario
        break;
        
    case 'Seleccionar': // Busca un libro en base a su ID
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
            
        ];

        redirect("productos.php?mensaje1=Libro seleccionado");
        break;

    case 'Borrar':
        // Hace un delete de un libro y la imagen,primero busca ambas cosas y las borra despues
        $sentencia = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $libro = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($libro["imagen"]) && $libro["imagen"] != "imagen.jpg") {
            $rutaImagen = "../../imagenes/Lib" . $libro["imagen"];
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
    unset($_SESSION['libroSeleccionado']);
} 

// Obtener lista de libros
$sentencia = $conexion->prepare("SELECT * FROM libros ORDER BY id DESC limit 5");
$sentencia->execute();
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>