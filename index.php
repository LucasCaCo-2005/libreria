<?php
//Garantizo que haya una sesión activa y creo la sesion.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/admin/seccion/bd.php';
include_once __DIR__ . '/admin/seccion/Talleres.php';

// Aviso activo
$sql = "SELECT titulo, contenido FROM avisos WHERE activo = 1 LIMIT 1";
$resultado = $conexion->query($sql);
$mensaje = ($resultado && $resultado->rowCount() > 0) ? $resultado->fetch(PDO::FETCH_ASSOC) : null;

// Talleres
$talleresBD = new TalleresBD();
$listaTalleres = $talleresBD->ListarTalleres();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AJUPEN Durazno</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS PERSONALIZADO -->
    <link rel="stylesheet" href="./estilos/index.css">
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body>

<header class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <img src="./images/bandera.png" alt="Bandera" height="60">
        <img src="./images/Logo.png" alt="Logo" height="60">
    </div>
  <!--  <button id="loginButton" class="btn btn-primary" onclick="openLoginModal()">Iniciar sesión</button> -->

       <!-- Incluyo el archivo que contiene el usuario logueado y el boton cerrar cesión -->
<?php include_once './incluidos/loginBanner.php'; ?>
</header>

<!-- Modal de Login -->
<div id="loginModal" class="custom-login-modal">
  <div class="modal-content">
    <span class="close" onclick="closeLoginModal()">&times;</span>
  <iframe id="loginIframe" src="login.php" frameborder="0"
        style="width:100%; height:300px; border-radius:10px; overflow:hidden;"></iframe>
  </div>
</div>

<!-- Lista de Talleres -->
<main class="container my-5">
    <h2 class="text-center mb-4">Nuestros Talleres</h2>
    <div class="row g-4">
        <?php if ($listaTalleres && is_array($listaTalleres)): ?>
            <?php foreach ($listaTalleres as $taller): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="./images/<?= htmlspecialchars($taller->getFoto()) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($taller->getNombre()) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($taller->getNombre()) ?></h5>
                            <p>Día: <?= htmlspecialchars($taller->getDia()) ?></p>
                            <p>Horario: <?= htmlspecialchars($taller->getHorario()) ?></p>
                            <p>Costo: <?= htmlspecialchars($taller->getCosto()) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No hay cursos disponibles por ahora.</p>
        <?php endif; ?>
    </div>
</main>

<!-- Avisos -->
<?php if ($mensaje): ?>
    <?php include 'modalIndex.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const avisoModal = new bootstrap.Modal(document.getElementById('mensajeModal'));
            avisoModal.show();
        });
    </script>
<?php endif; ?>

<!-- Banner inferior -->
<footer class="banner-inferior">
    <div class="scroll-text">
        ASOCIACIÓN DE JUBILADOS Y PENSIONISTAS DE DURAZNO &nbsp;|&nbsp;
        Luis Alberto de Herrera 1037 &nbsp;|&nbsp; Tel: 43628063
    </div>
</footer>

<!-- Banner lateral -->
<aside class="vertical-banner" id="verticalBanner">
    <button onclick="window.location.href='institucion.html'">Institución</button>
    <button onclick="window.location.href='autoridades.php'">Autoridades</button>
   
    <button onclick="window.location.href='talleres.php'">Talleres</button>
    <button onclick="window.location.href='./admin/index.php'">Admin</button>
    <button onclick="window.location.href='productos.php'">Productos</button>
</aside>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function openLoginModal() {
    const modal = document.getElementById("loginModal");
    const iframe = document.getElementById("loginIframe");
    iframe.src = "login.php";
    modal.classList.add("active");
}

function closeLoginModal() {
    const modal = document.getElementById("loginModal");
    modal.classList.remove("active");
    setTimeout(() => { modal.style.display = "none"; }, 300);
}

window.onclick = function(event) {
    const modal = document.getElementById("loginModal");
    if (event.target === modal) {
        closeLoginModal();
    }
};

window.addEventListener("message", function(event) {
    if (event.data === "loginExitoso") {
        closeLoginModal();
        window.location.href = "index.php";
    }
});
</script>
</body>
</html>
