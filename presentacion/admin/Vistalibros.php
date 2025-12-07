<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros - AJUPEN</title>
    <style>
        .carta-chica { 
            width: 250px; 
            border: 1px solid #ceababff;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
            margin: 5px;
            display: inline-block;
            vertical-align: top;
            transition: transform 0.2s;
        }
        .carta-chica:hover {
            transform: translateY(-5px);
            box-shadow: 4px 4px 10px rgba(0,0,0,0.2);
        }
        .carta-chica img {
            height: 150px;
            object-fit: cover;
            margin-bottom: 15px;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }
        .contenedor-libros {
            display: flex;
            flex-wrap: wrap;   
            justify-content: center; 
            gap: 20px; 
        }
        .btn-group-card {
            display: flex;
            gap: 5px;
            margin-top: 10px;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>
<?php include_once 'cabecera.php'; ?>
<?php   
include_once (__DIR__ ."/../../Logica/Admin/logistica.php");
include_once (__DIR__ ."/../../Logica/Admin/bd.php");
$sentencia = $conexion->prepare("SELECT * FROM libros");
$sentencia->execute();
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
 
<div class="contenedor-libros">
    <?php foreach($listaLibros as $libro): ?> 
        <div class="card carta-chica">
            <img class="card-img-top" src="../../imagenes/lib<?php echo $libro['imagen']; ?>" alt="">
            <div class="card-body">
                <h6 class="card-title"><?php echo $libro['nombre']; ?></h6>
                <p class="card-text"><strong>Autor:</strong> <?php echo $libro['autor']; ?></p>
                <p class="card-text"><small class="text-muted">Categoría: <?php echo $libro['categoria']; ?></small></p>
                <div class="btn-group-card">
                    <a class="btn btn-sm btn-primary" href="mas.php?id=<?php echo $libro['id']; ?>" role="button">Ver más</a>
                    <a class="btn btn-sm btn-warning" href="prestamos.php?id=<?php echo $libro['id']; ?>">Prestar</a>
                    <a class="btn btn-sm btn-success" href="Productos.php?id=<?php echo $libro['id']; ?>" 
                       title="Editar libro">
                        Editar
                    </a>
                </div>
            </div> 
        </div> 
    <?php endforeach; ?>
</div> 

<?php include_once 'pie.php'; ?>
</body>
</html>