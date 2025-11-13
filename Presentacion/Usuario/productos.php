<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Biblioteca Digital</title>
     <link rel="stylesheet" href="../css/Usuario/productos.css"> 
</head>


<?php include_once 'cabecera.php'; ?>
<?php include_once '../../Logica/Admin/bd.php'; ?>

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

// Lista de categorias disponibles
$categorias = [
  "Fantasia", "Terror", "Drama", "Misterio", "Historico",
  "Ficcion", "Romantico", "Biografia", "Autoayuda", "Nacional", "Otros"
];
?>

<div class="contenedor-principal">
  <h1 class="titulo-pagina">Nuestra Colección de Libros</h1>

  <!-- Filtro de categorías -->
  <div class="contenedor-botones">
    <a href="?categoria=" class="btn-filtro <?php if($categoriaSeleccionada == '') echo 'btn-activo'; ?>">
      Todos los Libros
    </a>
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
        <div class="carta-libro">
          <img src=../../imagenes//<?php echo $libro['imagen']; ?>" alt="Portada de <?php echo $libro['nombre']; ?>">
          <div class="card-body">
            <h3 class="card-title"><?php echo $libro['nombre']; ?></h3>
            <p class="card-autor"><?php echo $libro['autor']; ?></p>
            <span class="card-categoria"><?php echo $libro['categoria']; ?></span>
            <div class="contenedor-botones-card">
              <a class="btn btn-ver" href="mas.php?id=<?php echo $libro['id']; ?>">Ver más</a>
              <a class="btn btn-reservar" href="mas.php?id=<?php echo $libro['id']; ?>">Reservar</a>
            </div>
          </div> 
        </div> 
      <?php } ?>
    <?php else: ?>
      <div class="mensaje-vacio">
        <i>📚</i>
        <p>No hay libros disponibles en esta categoría.</p>
        <p style="margin-top: 10px; font-size: 0.9rem;">Prueba con otra categoría o vuelve más tarde.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include_once 'pie.php'; ?>
</body>
</html>