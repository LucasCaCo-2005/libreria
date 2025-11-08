<?php include_once 'template/cabecera.php'; ?>
<?php
include_once("seccion/bd.php");

$libro = null;

// Obtener datos del libro seleccionado con get
if (isset($_GET['id'])) {
    $idLibro = $_GET['id'];

    $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id = :id");
    $sentencia->bindParam(":id", $idLibro);
    $sentencia->execute();
    $libro = $sentencia->fetch(PDO::FETCH_ASSOC);
}

// Captura datos del formulario
if ($_POST) {
    $idLibro = $_POST['libro_id'];
    $nombrePersona = trim($_POST['persona']);
    $fechaPrestamo = $_POST['fecha_prestamo'];
    $fechaDevolucion = $_POST['fecha_devolucion'];

    try {
        $sentencia = $conexion->prepare("
            INSERT INTO prestamos (libro_id, persona, fecha_prestamo, fecha_devolucion, estado) 
            VALUES (:libro_id, :persona, :fecha_prestamo, :fecha_devolucion, 'prestado')
        ");
        $sentencia->bindParam(":libro_id", $idLibro);
        $sentencia->bindParam(":persona", $nombrePersona);
        $sentencia->bindParam(":fecha_prestamo", $fechaPrestamo);
        $sentencia->bindParam(":fecha_devolucion", $fechaDevolucion);
        $sentencia->execute();

        echo "<script>alert('✅ Préstamo registrado correctamente');window.location='prest.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('❌ Error al registrar el préstamo: " . $e->getMessage() . "');</script>";
    }
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
            text-align: center;
            margin-bottom: 10px;
        }
        label {
            display: block;
            margin-bottom: 6px;
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
        .card {
            border: 1px solid #ccc;
            padding: 15px;
            max-width: 350px;
            margin: 20px auto;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        img {
            max-width: 280px;
            height: auto;
            border-radius: 6px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <br><br><br>

    <?php if ($libro) { ?>
        <div class="card">
            <h2>Registrar Préstamo</h2>
            <p><strong>Libro:</strong> <?php echo htmlspecialchars($libro['nombre']); ?> <br>
            <small><em><?php echo htmlspecialchars($libro['autor']); ?></em></small></p>
            <form method="post">
                <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">

                <label>Nombre de la persona:</label>
                <input type="text" name="persona" required>

               <label>Fecha de préstamo:</label>
<input type="date" name="fecha_prestamo" required>

<label>Fecha de devolución:</label>
<input type="date" name="fecha_devolucion" required>


                <button type="submit">Guardar préstamo</button>
            </form>
        </div>

        <div class="card">
            <h2>Carátula del Libro</h2>
            <img src=/../images/<?php echo htmlspecialchars($libro['imagen']); ?> " alt="Imagen del libro">
        </div>
    <?php } else { ?>
        <p style="text-align:center;">No se encontró el libro seleccionado.</p>
    <?php } ?>
</body>
</html>
<?php include_once 'template/pie.php'; ?>
