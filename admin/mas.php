<?php include_once 'template/cabecera.php'; ?>
<?php
include_once ("config/bd.php");

$libro = null;
if(isset($_GET['id'])){
    $idLibro = $_GET['id'];

    $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
    $sentencia->bindParam(":id", $idLibro);
    $sentencia->execute();
    $libro = $sentencia->fetch(PDO::FETCH_ASSOC);
}
if(!$libro){
    echo "<h2>Libro no encontrado</h2>";
    exit;
}
?> <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Libro</title>
    <style> 
.imagen {
    border: 1px solid #ceababff;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
}
.boton {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
.libro-detalle {
    border: 1px solid #ceababff;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0,0,
0,0.1);
    padding: 20px;
    max-width: 300px;
    margin: 0 auto;
    background-color: #f9f9f9;
}

.bboton {
    margin-bottom: 20px;
    text-align: center;
}

    </style>
</head>

<body>

<div   class="libro-detalle" style="text-align:center;">
     <br>
<img class= "imagen"src="../img/<?php echo $libro['imagen']; ?>" alt="" style="width:200px; height:300px; object-fit:cover;"><br>
Nombre: <?php echo $libro['nombre']; ?><br>
Autor: <?php echo $libro['autor']; ?><br>
</div>
<br>

<div  class="bboton" style="text-align:center;">
 <a class="boton" href="Vistalibros.php?id=<?php echo $libro['id']; ?>">Volver</a>
</div>



</body>