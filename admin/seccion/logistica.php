<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : ""; 
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : ""; 
$txtIMG = (isset($_FILES['txtIMG']['name'])) ? $_FILES['txtIMG']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : ""; //Agregar, Modificar, Cancelar, Seleccionar, Borrar
$txtfecha = (isset($_POST['txtfecha'])) ? $_POST['txtfecha'] : ""; 
$txtAutor = (isset($_POST['txtAutor'])) ? $_POST['txtAutor'] : "";
$txtCat = (isset($_POST['txtCat'])) ? $_POST['txtCat'] : "";
$txtStock = (isset($_POST['txtStock'])) ? $_POST['txtStock'] : ""; 
$txtDesc = (isset($_POST['txtDesc'])) ? $_POST['txtDesc'] : ""; 
include("bd.php");
switch($accion) {
       case 'Agregar':
        $sentencia = $conexion->prepare("INSERT INTO `libros` (nombre, fecha, autor, categoria, stock, descripcion, imagen) VALUES (:nombre, :fecha, :autor, :categoria, :stock, :descripcion, :imagen);"); //Ajuste en la consulta SQL
        // Asignar los valores a los parámetros
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':fecha', $txtfecha);
        $sentencia->bindParam(':autor', $txtAutor);
         $sentencia->bindParam(':categoria', $txtCat);
        $sentencia->bindParam(':stock', $txtStock); 
         $sentencia->bindParam(':descripcion', $txtDesc); 
        // Generar nombre único para el archivo de imagen
       $fecha = new DateTime(); 
        $nombreArchivo = ($txtIMG != "")? $fecha->getTimestamp() . "_" . $_FILES['txtIMG']['name'] : "imagen.jpg";
        $tmpImagen = $_FILES['txtIMG']['tmp_name']; 
        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../images/" . $nombreArchivo); 
        }
        // Guardar el nombre correcto en la base de datos
        $sentencia->bindParam(':imagen', $nombreArchivo);
        $sentencia->execute();        
        header("Location: productos.php?mensaje=¡Libro agregado exitosamente!");
        exit();
        break;
 case 'Modificar':
    // Actualizar el nombre
    $sentencia = $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
    $sentencia->bindParam(':nombre', $txtNombre);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();

$sentencia = $conexion->prepare("UPDATE libros SET fecha=:fecha WHERE id=:id");
    $sentencia->bindParam(':fecha', $txtfecha);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();

    $sentencia = $conexion->prepare("UPDATE libros SET autor=:autor WHERE id=:id");
    $sentencia->bindParam(':autor', $txtAutor);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();

     $sentencia = $conexion->prepare("UPDATE libros SET categoria=:categoria WHERE id=:id");
    $sentencia->bindParam(':categoria', $txtCat);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();


    $sentencia = $conexion->prepare("UPDATE libros SET stock=:stock WHERE id=:id");
    $sentencia->bindParam(':stock', $txtStock);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();

     $sentencia = $conexion->prepare("UPDATE libros SET descripcion=:descripcion WHERE id=:id");
    $sentencia->bindParam(':descripcion', $txtDesc);
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
      header("Location: productos.php?mensaje2=Libro modificado");
    exit();
    break;

        break;
    case 'Cancelar':
header("Location: productos.php");

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
    ];

    header("Location: productos.php?mensaje1=Libro seleccionado");
    exit();
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
            unlink($rutaImagen); // Eliminar la imagen del servidor
        }
    }
    // Borrar el libro de la base de datos
    $sentencia = $conexion->prepare("DELETE FROM libros WHERE id=:id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute(); 

       header("Location: productos.php?mensaje3=Libro borrado");
    exit();
    break;

}

$sentencia = $conexion->prepare("SELECT * FROM libros");
$sentencia->execute();
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>