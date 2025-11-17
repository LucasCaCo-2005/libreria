<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

 include_once '../../logica/admin/bd.php'; 
 include_once '../../logica/admin/autoridades.php'; 


// Obtener lista de Autoridades como ARRAY
$autoridadesBD = new AutoridadesBD();
$listaAutoridadesObjects = $autoridadesBD->ListarAutoridades();

// Convertir objetos a arrays para facilitar el uso
$listaAutoridades = [];
foreach ($listaAutoridadesObjects as $autoridad) {
    $listaAutoridades[] = [
        'id' => $autoridad->getId(),
        'cedula' => $autoridad->getCedula(),
        'nombre' => $autoridad->getNombre(),
        'cargo' => $autoridad->getCargo(),
        'fecha_inicio' => $autoridad->getFecha_inicio(),
        'fecha_fin' => $autoridad->getFecha_fin(),
        'foto' => $autoridad->getFoto(),
        'estado' => $autoridad->getEstado()
    ];
}

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Index - Autoridades</title>
 <link rel="stylesheet" href="./../css/usuario/autoridades.css">
¡
</head>
<body>

<?php include_once 'cabecera.php'; ?>

<div class="contenido">
    <section>
        <h2 class="titulo-autoridades">Autoridades</h2>

        <?php if (!empty($listaAutoridades)): ?>
            <?php 
                // Filtramos Presidente y otros cargos
                $presidentes = array_filter($listaAutoridades, fn($a) => strtolower($a['cargo']) === 'presidente');
                $otros = array_filter($listaAutoridades, fn($a) => strtolower($a['cargo']) !== 'presidente');
            ?>

            <!-- Sección del Presidente -->
            <?php if (!empty($presidentes)): ?>
                <div class="organigrama-presidente">
                    <?php foreach ($presidentes as $autoridad): ?>
                        <div class="card presidente">
                            <img src="images/<?= htmlspecialchars($autoridad['foto']) ?>" 
                                 alt="Foto de <?= htmlspecialchars($autoridad['cargo']) ?>"
                                 onerror="this.src='images/default-avatar.jpg'">
                            <div class="card-content">
                                <p><strong><?= htmlspecialchars($autoridad['nombre']) ?></strong></p>
                                <p><strong><?= htmlspecialchars($autoridad['cargo']) ?></strong></p>
                                <p><strong>Desde:</strong> <?= htmlspecialchars($autoridad['fecha_inicio']) ?></p>
                                <p><strong>Hasta:</strong> <?= htmlspecialchars($autoridad['fecha_fin']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Sección del resto de autoridades -->
            <div class="organigrama-otros">
                <?php foreach ($otros as $autoridad): ?>
                    <div class="card">
                        <img src="../../imagenes/<?= htmlspecialchars($autoridad['foto']) ?>" 
                             alt="Foto de <?= htmlspecialchars($autoridad['cargo']) ?>"
                             onerror="this.src='images/default-avatar.jpg'">
                        <div class="card-content">
                            <p><strong><?= htmlspecialchars($autoridad['nombre']) ?></strong></p>
                            <p><strong><?= htmlspecialchars($autoridad['cargo']) ?></strong></p>
                            <p><strong>Desde:</strong> <?= htmlspecialchars($autoridad['fecha_inicio']) ?></p>
                            <p><strong>Hasta:</strong> <?= htmlspecialchars($autoridad['fecha_fin']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-autoridades">
                <p>Próximamente publicaremos las nuevas Autoridades.</p>
            </div>
        <?php endif; ?>
    </section>
</div>

</body>
</html>