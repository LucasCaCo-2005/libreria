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
 <link rel="stylesheet" href="css/autoridades.css">
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
</style>
</head>
<body>

<?php include_once 'template/cabecera.php'; ?>
<?php include_once './users/loginBanner.php'; ?>

<div class="contenido">
  
    <section>
   <h2 class="titulo-autoridades">Autoridades</h2> <!-- Título centrado -->

    <?php if (!empty($listaAutoridades)): ?>
        <?php 
            // Filtramos Presidente y otros cargos
            $presidentes = array_filter($listaAutoridades, fn($a) => strtolower($a->getCargo()) === 'presidente');
            $otros = array_filter($listaAutoridades, fn($a) => strtolower($a->getCargo()) !== 'presidente');
        ?>

       <!-- Sección del Presidente -->
<?php if (!empty($presidentes)): ?>
    <div class="organigrama-presidente">
        <?php foreach ($presidentes as $autoridad): ?>
            <div class="card presidente">
                <img src="images/<?= htmlspecialchars($autoridad->getFoto() ?? '') ?>" alt="Foto de <?= htmlspecialchars($autoridad->getCargo() ?? '') ?>">
                <div class="card-content">
                    <p><strong><?= htmlspecialchars($autoridad->getNombre() ?? '') ?></strong></p>
                    <p><strong><?= htmlspecialchars($autoridad->getCargo() ?? '') ?></strong></p>
                    <p><strong>Desde:</strong> <?= htmlspecialchars($autoridad->getFecha_inicio() ?? '') ?></p>
                    <p><strong>Hasta:</strong> <?= htmlspecialchars($autoridad->getFecha_fin() ?? '') ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Sección del resto de autoridades -->
<div class="organigrama-otros">
    <?php foreach ($otros as $autoridad): ?>
        <div class="card">
            <img src="images/<?= htmlspecialchars($autoridad->getFoto() ?? '') ?>" alt="Foto de <?= htmlspecialchars($autoridad->getCargo() ?? '') ?>">
            <div class="card-content">
                <p><strong><?= htmlspecialchars($autoridad->getNombre() ?? '') ?></strong></p>
                <p><strong><?= htmlspecialchars($autoridad->getCargo() ?? '') ?></strong></p>
                <p><strong>Desde:</strong> <?= htmlspecialchars($autoridad->getFecha_inicio() ?? '') ?></p>
                <p><strong>Hasta:</strong> <?= htmlspecialchars($autoridad->getFecha_fin() ?? '') ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
    <?php else: ?>
        <p style="text-align:center;">Próximamente publicaremos las nuevas Autoridades.</p>
    <?php endif; ?>
</section>


</div>

</body>

</html>
