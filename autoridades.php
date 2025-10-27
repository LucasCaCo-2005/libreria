<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/admin/seccion/bd.php';
include_once __DIR__ . '/admin/seccion/Autoridades.php';

// Obtener lista de Autoridades
$autoridadesBD = new AutoridadesBD();
$listaAutoridades = $autoridadesBD->ListarAutoridades();



?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Index - Autoridades</title>
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
    <h1>Autoridades</h1>

  

    <section>
      <h2>Autoridades</h2>
      <div class="grid">
        <?php if (!empty($listaAutoridades)): ?>
          <?php foreach ($listaAutoridades as $autoridad): ?>
            <div class="card">
              <img src="images/<?= htmlspecialchars($autoridad->getFoto()) ?>" alt="Foto de <?= htmlspecialchars($autoridad->getCargo()) ?>">
              <div class="card-content">
                <p><strong>Desde:</strong> <?= htmlspecialchars($autoridad->getFecha_inicio()) ?></p>
                <p><strong>Hasta:</strong> <?= htmlspecialchars($autoridad->getFecha_fin()) ?></p>
              
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="text-align:center;">Proximamente publicaremos las nuevas Autoridades.</p>
        <?php endif; ?>
      </div>
    </section>


</div>

</body>

</html>
