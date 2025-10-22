
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>

      h1, h2 {
    color: #111;
    text-align: center;
}
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
    margin: 20px 0;
}
.card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
.card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}
.card-content {
    padding: 12px 16px;
}
.card-content h3 {
    margin: 0;
    font-size: 1.2em;
    color: #004a85;
}
.card-content p {
    margin: 4px 0;
    font-size: 0.95em;
}
.btn {
    display: inline-block;
    padding: 6px 10px;
    background: #0057a0;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-size: 0.9em;
}
.btn:hover {
    background: #003d70;
}
  
</style>

</head>
<body>

<?php include_once 'template/cabecera.php'; ?>

<?php   
include_once ("admin/seccion/bd.php");

$sentencia = $conexion->prepare("SELECT * FROM libros");
$sentencia->execute();
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>
<section>
  <h2>Libros disponibles</h2>
  <div class="grid">
    <?php if (!empty($listaLibros)): ?>
      <?php foreach ($listaLibros as $libro): ?>
        <div class="card">
          <img src="/images/<?= htmlspecialchars($libro['imagen']) ?>" alt="<?= htmlspecialchars($libro['nombre']) ?>">
          <div class="card-content">
            <h3><?= htmlspecialchars($libro['nombre']) ?></h3>
            <p><strong>Autor:</strong> <?= htmlspecialchars($libro['autor']) ?></p>
             <a class="btn btn-sm btn-primary" href="mas.php?id=<?php echo $libro['id'];?>" role="button">Ver más</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center;">No hay libros cargados en este momento.</p>
    <?php endif; ?>
  </div>
</section>
<?php include_once 'template/pie.php'; ?>

</body>
</html>