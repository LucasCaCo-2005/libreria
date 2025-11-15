<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
<<<<<<<< HEAD:presentacion/usuario/talleres.php
include_once __DIR__ . '/../../logica/admin/Talleres.php';
include_once __DIR__ . '/../../persistencia/admin/TalleresBD.php';
include_once __DIR__ . '/../../logica/admin/bd.php';
========
include_once __DIR__ . '/../../Logica/Admin/bd.php';
include_once __DIR__ . '/../../Logica/Admin/talleres.php';
>>>>>>>> 72a969d9b84989c8325ef25b7bf44b91d1c94b1a:Presentacion/Usuario/talleres.php


// Obtener lista de talleres y filtrar solo los activos
$talleresBD = new TalleresBD();
$todosTalleres = $talleresBD->ListarTalleres();
$listaTalleres = array_filter($todosTalleres, function($taller) {
    return $taller->getEstado() === 'activo';
});
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Talleres - Biblioteca Digital</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<<<<<<<< HEAD:presentacion/usuario/talleres.php
<link rel="stylesheet" href="../../css/usuario/talleres.css">
========
<link rel="stylesheet" href="../css/Usuario/talleres.css">
>>>>>>>> 72a969d9b84989c8325ef25b7bf44b91d1c94b1a:Presentacion/Usuario/talleres.php
<style>
  
</style>
</head>
<body>

<?php include_once 'cabecera.php'; ?>

<div class="pagina-talleres">
    <section class="hero-talleres">
        <h1>Nuestros Talleres</h1>
        <p class="descripcion">
            Descubre experiencias únicas de aprendizaje y desarrollo personal. 
            Únete a nuestra comunidad y expande tus horizontes.
        </p>
    </section>

    <section class="seccion-talleres">
        <h2 class="titulo-seccion">Talleres Activos</h2>
        
        <div class="grid-talleres">
            <?php if (!empty($listaTalleres)): ?>
                <?php foreach ($listaTalleres as $taller): ?>
                    <div class="card-taller">
                        <img src="../../imagenes/<?= htmlspecialchars($taller->getFoto()) ?>" 
                             alt="Taller de <?= htmlspecialchars($taller->getNombre()) ?>" 
                             class="imagen-taller">
                        
                        <div class="contenido-taller">
                            <h3 class="nombre-taller"><?= htmlspecialchars($taller->getNombre()) ?></h3>
                            
                            <div class="info-taller">
                                <div class="detalle-taller">
                                    <span class="icono">📅</span>
                                    <strong>Día:</strong> <?= htmlspecialchars($taller->getDia()) ?>
                                </div>
                                <div class="detalle-taller">
                                    <span class="icono">⏰</span>
                                    <strong>Horario:</strong> <?= htmlspecialchars($taller->getHorario()) ?>
                                </div>
                            </div>
                            
                            <div class="costo-taller">
                                <?= htmlspecialchars($taller->getCosto()) ?>
                            </div>
                            
                            <a href="inscripcion.php?id=<?= $taller->getId() ?>" class="">
                                Ver mas
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="mensaje-vacio">
                    <i>🎨</i>
                    <p>No hay talleres disponibles en este momento.</p>
                    <p style="margin-top: 10px; font-size: 0.9rem;">
                        Vuelve pronto para conocer nuestras próximas actividades.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="beneficios">
        <h3>¿Por qué unirte a nuestros talleres?</h3>
        <div class="lista-beneficios">
            <div class="beneficio">
                <i>👥</i>
                <h4>Comunidad</h4>
                <p>Conecta con personas que comparten tus intereses</p>
            </div>
            <div class="beneficio">
                <i>🎯</i>
                <h4>Entretenimiento</h4>
                <p>Necesario para una buena vida</p>
            </div>
            <div class="beneficio">
                <i>💡</i>
                <h4>Piensa libre</h4>
                <p>Distraete de las cosas malas de la vida aqui </p>
            </div>
        </div>
    </section>
</div>

<?php include_once 'pie.php'; ?>
</body>
</html>