<?php include_once 'template/cabecera.php'; ?>
<?php
include_once ("seccion/bd.php");

$libro = null;
if(isset($_GET['id'])){
    $idLibro = $_GET['id'];

    $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
    $sentencia->bindParam(":id", $idLibro);
    $sentencia->execute();
    $libro = $sentencia->fetch(PDO::FETCH_ASSOC);
}
if($_POST){
    $idLibro = $_POST['libro_id'];
    $nombrePersona = $_POST['persona'];
    $fechaPrestamo = $_POST['prestamo'];
    $fechaDevolucion = $_POST['devolucion'];
    $sentencia = $conexion->prepare("INSERT INTO prestamos (libro_id, persona, prestamo, devolucion) 
                                     VALUES (:libro_id, :persona, :prestamo, :devolucion)");
    $sentencia->bindParam(":libro_id", $idLibro);
    $sentencia->bindParam(":persona", $nombrePersona);
    $sentencia->bindParam(":prestamo", $fechaPrestamo);
    $sentencia->bindParam(":devolucion", $fechaDevolucion);
    $sentencia->execute();
    echo "<script>alert('Préstamo registrado correctamente');window.location='prest.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Préstamo</title>

    <style>




        body {
            font-family: Arial, sans-serif;
            
        }
        h2 {
            text-align: justify;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }

        img {
            max-width: 340px;
            height: auto;
            display: block;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px;
            text-align: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <br>
    
    <br>
    <br>
    <?php if($libro){ ?>
        <br>

        <div style="text-align:center; border: 1px solid #ccc; padding: 15px; max-width: 300px; margin: 0 auto;"> Registrar Préstamo
        <br>
        <p><strong>Libro:</strong> <?php echo $libro['nombre']; ?> (<?php echo $libro['autor']; ?>) </p>
        <br>
        <form method="post">
            <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
            <label>Nombre de la persona:</label><br>
            <input type="text" name="persona" required><br><br>
            <label>Fecha de préstamo:</label><br>
            <input type="date" name="prestamo" required><br><br>
            <label>Fecha de devolución:</label><br>
            <input type="date" name="devolucion" required><br><br>
            <button type="submit">Guardar</button>
        </form> </div>

 <div style=" border: 1px solid #ccc; padding: 20px; max-width: 300px; margin: 0 auto;"  >      <h1>caratula</h1>
  <img class="card-img-top" src="../../images/<?php echo $libro['imagen']; ?>" alt="">
</div> 
      
    <?php } else { ?>
        <p>No se encontró el libro.</p>
    <?php } ?>
</body>
</html>
<?php include_once 'template/pie.php'; ?>
