<?php include_once 'template/cabecera.php'; ?>
<?php
include_once ("seccion/bd.php");
$taller = null;
if(isset($_GET['id'])){
    $idTaller = $_GET['id']; // minusculas

    $sentencia = $conexion->prepare("SELECT * FROM talleres WHERE Id=:Id");
    $sentencia->bindParam(":Id", $idTaller);
    $sentencia->execute();
    $taller = $sentencia->fetch(PDO::FETCH_ASSOC);
}
if(!$taller){
    echo "<h2>Taller no encontrado</h2>";
    exit;
}
?> <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del taller</title>
    <style> 
.foto {
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
<img src="../images/<?php echo $taller['foto']; ?>"  alt="" style="width:200px; height:300px; object-fit:cover;"><br>
Nombre: <?php echo $taller['nombre']; ?><br>
Horario: <?php echo $taller['horario']; ?><br>
Costo: <?php echo $taller['costo']; ?><br>
Descripcion: <?php echo $taller['descripcion']; ?><br>



</div>
<br>
<div  class="bboton" style="text-align:center;">
 <a class="boton" href="vistaT.php?id=<?php echo $taller['Id']; ?>">Volver</a>
</div>

</body>