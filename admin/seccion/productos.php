 <?php  include("../template/cabecera.php") ?>

<?php

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtIMG = (isset($_FILES['txtIMG']['name'])) ? $_FILES['txtIMG']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
$txtprecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtcategoria = (isset($_POST['txtcategoria'])) ? $_POST['txtcategoria'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";

include("../config/bd.php");

switch($accion) {
       case 'Agregar':
        // INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'php', 'imagen.jpg');

        $sentencia = $conexion->prepare("INSERT INTO `libros` (nombre, precio, categoria, descripcion, imagen) VALUES (:nombre, :precio, :categoria, :descripcion, :imagen);");
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':precio', $txtprecio);
        $sentencia->bindParam(':categoria', $txtcategoria); 
        $sentencia->bindParam(':descripcion', $txtDescripcion);
    

        // Generar nombre único para el archivo de imagen
        $fecha = new DateTime();
        $nombreArchivo = ($txtIMG != "") ? $fecha->getTimestamp() . "_" . $_FILES['txtIMG']['name'] : "imagen.jpg";

        $tmpImagen = $_FILES['txtIMG']['tmp_name'];
        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
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

        // Actualizar el precio
        $sentencia = $conexion->prepare("UPDATE libros SET precio=:precio WHERE id=:id");
        $sentencia->bindParam(':precio', $txtprecio);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();


        // Actualizar la categoría
        $sentencia = $conexion->prepare("UPDATE libros SET categoria=:categoria WHERE id=:id");
        $sentencia->bindParam(':categoria', $txtcategoria);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();

        // Actualizar la descripción
        $sentencia = $conexion->prepare("UPDATE libros SET descripcion=:descripcion WHERE id=:id");
        $sentencia->bindParam(':descripcion', $txtDescripcion);
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
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }
        // Actualizar el nombre de la imagen en la base de datos
        $sentencia = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
        $sentencia->bindParam(':imagen', $nombreArchivo);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
    }
       header("Location: productos.php");

    break;

        break;
    case 'Cancelar':
header("Location: productos.php");

        break;

         case 'Seleccionar':
            
$sentencia = $conexion->prepare("SELECT * FROM libros where id=:id");
$sentencia->bindParam(':id', $txtID);
$sentencia->execute();
$libro = $sentencia->fetch(PDO::FETCH_LAZY);

$txtNombre = $libro['nombre'];
$txtIMG = $libro['imagen'];
$txtcategoria = $libro['categoria'];
$txtprecio = $libro['precio'];
$txtDescripcion = $libro['descripcion'];

$mensaje1="Libro seleccionado";
        
        break;

case 'Borrar':
    // Buscar la imagen actual
    $sentencia = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $libro = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($libro["imagen"]) && $libro["imagen"] != "imagen.jpg") {
        $rutaImagen = "../../img/" . $libro["imagen"];
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
    }
    // Borrar el libro de la base de datos
    $sentencia = $conexion->prepare("DELETE FROM libros WHERE id=:id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();

       header("Location: productos.php");

    break;

        break;
}

$sentencia = $conexion->prepare("SELECT * FROM libros");
$sentencia->execute();
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">

<div class="card">
    <div class="card-header">
        Datos
    </div>

    <div class="card-body">

<?php if (!empty($_GET['mensaje'])): ?>
    <div class="alert alert-success" role="alert">
        <?php echo htmlspecialchars($_GET['mensaje']); ?>
    </div>
<?php elseif (!empty($mensaje1)): ?>
    <div class="alert alert-info" role="alert">
        <?php echo htmlspecialchars($mensaje1); ?>
    </div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
<div class = "form-group">
<label hidden for="txtID">Id:</label>
<input  required readonly  hidden   type="text" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID; ?>" placeholder="Enter ID" >
</div>

<div class = "form-group">
<label for="txtNombre">Nombre:</label>
<input type="text" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $txtNombre; ?>" placeholder="Enter Name" required>
</div>

<div class = "form-group">
<label for="txtPrecio">Precio:</label>
<input type="text" class="form-control" name="txtPrecio" id="txtPrecio" value="<?php echo $txtprecio; ?>" placeholder="Enter Prize" required>
</div>

<div class="form-group">
    <label for="txtcategoria" class="form-control">Categoria:</label>
    <select name="txtcategoria" id="txtcategoria" required>
        <option value="" disabled>Seleccione</option>
        <option value="Fantasia" <?php if($txtcategoria == 'Fantasia') echo 'selected'; ?>>Fantasia</option>
        <option value="Terror" <?php if($txtcategoria == 'Terror') echo 'selected'; ?>>Terror</option>
        <option value="Drama" <?php if($txtcategoria == 'Drama') echo 'selected'; ?>>Drama</option>
    </select>
</div>

<div class = "form-group">
<label for="descripcion">descripcion:</label>
<input type="text" class="form-control" name="txtDescripcion" id="txtDescripcion" value="<?php echo $txtDescripcion; ?>" placeholder="Enter Description" required>
</div>

<div class = "form-group">

<label for="txtIMG">Imagen</label>
<br>

<?php if ($txtIMG != "") { ?>

    <img src="../../img/<?php echo $txtIMG; ?>" width="100" alt=""> <?php } ?>

<input type="file" class="form-control" name="txtIMG" id="txtIMG" value="" placeholder="Enter IMG" >
</div>

<div class="btn-group" role="group" aria-label="">
    <button type="submit" name="accion"  <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
    <button type="submit" name="accion"   value="Modificar" class="btn btn-warning">Modificar</button>
    <button type="submit" name="accion"   value="Cancelar" class="btn btn-info">Cancelar</button> 
</div> 

</form>
    </div>
 
</div>

</div>
<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoria</th>
                <th>Descripcion</th>
                <th>Imagen</th>
                 <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach($listaLibros as $libro) { 
             ?>
            <tr>
                <td><?php echo  $libro['id']  ?> </td>
                <td><?php echo  $libro['nombre']  ?> </td>
                 <td><?php echo  $libro['precio']  ?> </td>               
                <td><?php echo  $libro['categoria']  ?> </td>
                <td><?php echo  $libro['descripcion']  ?> </td>

       <td>
                    <img src="../../img/<?php echo $libro['imagen']; ?>" width="100" alt="">

</td>
                <td>
           
<form action="" method="post">

<input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">
<input type="submit" value="Seleccionar" name="accion" class="btn btn-primary" >
<input type="submit" value="Borrar" name="accion" class="btn btn-danger">

</form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    
</div>

<?php  include("../template/pie.php") ?>