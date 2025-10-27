<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/admin/seccion/bd.php';
include_once __DIR__ . '/admin/seccion/Talleres.php';

// Obtener lista de talleres
$talleresBD = new TalleresBD();
$listaTalleres = $talleresBD->ListarTalleres();



?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Index - Talleres y Libros</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body {
    font-family: Arial, sans-serif;
    color: #222;
    background: #f5f5f5;
    margin: 0; /* elimina margen del body */
}

.contenido {
    max-width: 1000px;
    margin: 40px auto;
}

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

<div class="contenido">
    <h1>Actividades</h1>

    <h6>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laudantium sapiente qui dolor explicabo facere velit esse nemo, recusandae molestiae consequatur fugit unde ad, delectus asperiores quod voluptate optio reiciendis sequi!</h6>

    <section>
      <h2>Talleres activos</h2>
      <div class="grid">
        <?php if (!empty($listaTalleres)): ?>
          <?php foreach ($listaTalleres as $taller): ?>
            <div class="card">
              <img src="images/<?= htmlspecialchars($taller->getFoto()) ?>" alt="Foto de <?= htmlspecialchars($taller->getNombre()) ?>">
              <div class="card-content">
                <h3><?= htmlspecialchars($taller->getNombre()) ?></h3>
                <p><strong>Día:</strong> <?= htmlspecialchars($taller->getDia()) ?></p>
                <p><strong>Horario:</strong> <?= htmlspecialchars($taller->getHorario()) ?></p>
                <p><strong>Costo:</strong> <?= htmlspecialchars($taller->getCosto()) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="text-align:center;">No hay talleres disponibles por ahora.</p>
        <?php endif; ?>
      </div>
    </section>


</div>

</body>

</html>
