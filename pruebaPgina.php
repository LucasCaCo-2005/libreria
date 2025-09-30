<?php
$afichesDir = '../Asociacion/images/afiches/';
$archivos = scandir($afichesDir);
$afiches = array_filter($archivos, function ($archivo) {
    return preg_match('/\.(jpg|jpeg|png|gif)$/i', $archivo);
});
sort($afiches);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Página con Banner</title>
    <link rel="stylesheet" href="../estilos/styleIndex.css">
    <style>
        /* AÑADIMOS AJUSTES DIRECTOS PARA ASEGURARNOS DE QUE FUNCIONE */
        .vertical-banner {
            position: fixed;
            top: 220px;           /* Ajustado al alto del header */
            bottom: 120px;        /* Ajustado al alto del footer */
            left: 0;
            width: 120px;
            background-color: #004080;
            padding: 10px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            border-radius: 0 8px 8px 0;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.3);
            z-index: 999;
            transition: left 0.3s ease;
        }

        .toggle-banner-btn {
            position: fixed;
            top: 240px;
            left: 120px;
            width: 30px;
            height: 30px;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            z-index: 1001;
        }

        .vertical-banner button {
            background-color: #0073e6;
            color: white;
            border: none;
            margin: 5px 0;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .vertical-banner button:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<header>
    <div class="header-content">
        <div class="flag">
            <img src="../images/bandera.png" alt="Bandera">
        </div>
        <div class="logo-header">
            <img src="../images/Logo.png" alt="Logo">
        </div>
        <div class="login-button">
            <button onclick="openModal()">Iniciar sesión</button>
        </div>
    </div>
</header>

<!-- BOTÓN DE TOGGLE -->
<button id="toggleBannerBtn" class="toggle-banner-btn">☰</button>

<!-- BANNER VERTICAL -->
<div class="vertical-banner" id="verticalBanner">
    <button onclick="window.location.href='institucion.html'">Institución</button>
    <button onclick="window.location.href='#autoridades'">Autoridades</button>
    <button onclick="window.location.href='#talleres'">Talleres</button>
    <button onclick="window.location.href='#secretaria'">Secretaría</button>
</div>

<!-- CARRUSEL DE AFICHES -->
<div class="container">
    <div class="banner">
        <?php foreach ($afiches as $index => $afiche): ?>
            <img src="<?= $afichesDir . $afiche ?>" class="slide <?= $index === 0 ? 'active' : '' ?>">
        <?php endforeach; ?>

        <div class="banner-controls">
            <button onclick="prevSlide()">❮</button>
            <button onclick="nextSlide()">❯</button>
        </div>
    </div>
</div>

<!-- MODAL DE LOGIN -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Iniciar Sesión</h2>
        <form>
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario">
            <label for="clave">Contraseña:</label>
            <input type="password" id="clave" name="clave">
            <button type="submit">Entrar</button>
            <a href="registro.php">¿No tienes cuenta? Regístrate aquí</a>
        </form>
    </div>
</div>

<!-- FOOTER FIJO -->
<div class="banner-inferior">
    <div class="scroll-text">
        ASOCIACION DE JUBILADOS Y PENSIONISTAS DE DURAZNO &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
        Luis Alberto de Herrera 1037 &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 43628063
    </div>
</div>

<!-- SCRIPTS -->
<script>
    // CARRUSEL DE AFICHES
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === index) slide.classList.add('active');
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    setInterval(nextSlide, 5000);

    // MODAL LOGIN
    function openModal() {
        document.getElementById('loginModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('loginModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('loginModal');
        if (event.target === modal) {
            closeModal();
        }
    };

    // BOTÓN TOGGLE DEL BANNER
    const banner = document.getElementById('verticalBanner');
    const toggleBtn = document.getElementById('toggleBannerBtn');

    toggleBtn.addEventListener('click', () => {
        if (banner.style.left === '0px' || banner.style.left === '') {
            banner.style.left = '-130px';  // ocultar
            toggleBtn.style.left = '0px';
        } else {
            banner.style.left = '0px';     // mostrar
            toggleBtn.style.left = '120px';
        }
    });

    // LOGO AMPLIABLE
    const logoImg = document.querySelector('.logo-header img');
    logoImg.addEventListener('click', () => {
        logoImg.classList.toggle('enlarged');
    });
</script>

</body>
</html>
