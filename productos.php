<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Libros</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      color: #222;
      background: #f5f5f5;
      margin: 0;
    }

    .contenedor-botones {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      margin: 20px 0;
    }

    .btn-filtro {
      background-color: #ceabab;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
      color: white;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-filtro:hover {
      background-color: #b98c8c;
    }

    .btn-activo {
      background-color: #8b6b6b;
    }

    .contenedor-libros {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-bottom: 50px;
    }

    .carta-chica {
      width: 400px;
      border: 1px solid #ceabab;
      border-radius: 5px;
      box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
      background-color: white;
      overflow: hidden;
    }

    .carta-chica img {
      width: 100%;
      height: 250px;
      object-fit: cover;
    }

    .card-body {
      padding: 10px;
    }

    .card-title {
      margin: 5px 0;
    }

    .btn {
      background-color: #ceabab;
      border: none;
      color: white;
      padding: 6px 10px;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      margin-right: 5px;
    }

    .btn:hover {
      background-color: #b98c8c;
    }
  </style>
</head>
<body>

<?php include_once 'template/cabecera.php'; ?>
<?php include_once 'admin/seccion/bd.php'; ?>

<?php
// Obtener categoría seleccionada desde la URL (GET)
$categoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : '';

// Consulta con filtro si se seleccionó una categoría
if ($categoriaSeleccionada) {
  $sentencia = $conexion->prepare("SELECT * FROM libros WHERE categoria = :categoria");
  $sentencia->bindParam(':categoria', $categoriaSeleccionada);
} else {
  $sentencia = $conexion->prepare("SELECT * FROM libros");
}
$sentencia->execute();
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Lista de categorías disponibles
$categorias = [
  "Fantasia", "Terror", "Drama", "Misterio", "Historico",
  "Ficcion", "Romantico", "Biografia", "Autoayuda", "Nacional", "Otros"
];
?>

<!-- Filtro de categorías -->
<div class="contenedor-botones">
  <a href="?categoria=" class="btn-filtro <?php if($categoriaSeleccionada == '') echo 'btn-activo'; ?>">Todos</a>
  <?php foreach ($categorias as $cat): ?>
    <a href="?categoria=<?php echo $cat; ?>" 
       class="btn-filtro <?php if($categoriaSeleccionada == $cat) echo 'btn-activo'; ?>">
       <?php echo $cat; ?>
    </a>
  <?php endforeach; ?>
</div>

<!-- Listado de libros -->
<div class="contenedor-libros">
  <?php if (count($listaLibros) > 0): ?>
    <?php foreach($listaLibros as $libro){ ?> 
      <div class="card carta-chica">
        <img src="/images/<?php echo $libro['imagen']; ?>" alt="Imagen del libro">
        <div class="card-body">
          <h6 class="card-title"><strong><?php echo $libro['nombre']; ?></strong></h6>
          <h6 class="card-title"><?php echo $libro['autor']; ?></h6>
          <h6 class="card-title"><?php echo $libro['categoria']; ?></h6>
          <a class="btn" href="mas.php?id=<?php echo $libro['id']; ?>">Ver más</a>
          <a class="btn" href="mas.php?id=<?php echo $libro['id']; ?>">Reservar</a>
        </div> 
      </div> 
    <?php } ?>
  <?php else: ?>
    <p style="text-align:center; color:#555;">No hay libros en esta categoría.</p>
  <?php endif; ?>
</div>

<?php include_once 'template/pie.php'; ?>
</body>
</html>
