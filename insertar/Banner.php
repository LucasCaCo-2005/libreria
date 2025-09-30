
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Página con Banner</title>
    <link rel="stylesheet" href="../estilos/Index.css"> 
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
            <button onclick="window.location.href='login.php'">Iniciar sesión</button>
        </div>
    </header>

    <!-- BANNER INFERIOR -->
    <div class="banner-inferior">
        <div class="scroll-text">
            ASOCIACION DE JUBILADOS Y PENSIONISTAS DE DURAZNO &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
            Luis Alberto de Herrera 1037 &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 43628063
        </div>
    </div>

    <!-- BOTÓN PARA MOSTRAR/OCULTAR BANNER VERTICAL -->
    <button id="toggleBannerBtn" class="toggle-banner-btn">☰</button>

    <!-- BANNER VERTICAL -->
    <div class="vertical-banner" id="verticalBanner">
        <button onclick="window.location.href='institucion.html'">Institución</button>
        <button onclick="window.location.href='#autoridades'">Autoridades</button>
        <button onclick="window.location.href='#talleres'">Talleres</button>
        <button onclick="window.location.href='#secretaria'">Secretaría</button>
    </div>

    <!-- JS -->
    <script>


        // Toggle banner vertical
        const toggleBtn = document.getElementById('toggleBannerBtn');
        const verticalBanner = document.getElementById('verticalBanner');

        toggleBtn.addEventListener('click', () => {
            if (verticalBanner.style.display === 'none') {
                verticalBanner.style.display = 'flex';
            } else {
                verticalBanner.style.display = 'none';
            }
        });

        // Mostrar por defecto
        verticalBanner.style.display = 'flex';

        // Logo animación opcional
        const logoImg = document.querySelector('.logo-header img');
        if (logoImg) {
            logoImg.addEventListener('click', () => {
                logoImg.classList.toggle('enlarged');
            });
        }
    </script>
 

    <div id="imageOverlay" class="image-overlay">
    <span class="close-overlay" onclick="closeImageOverlay()">&times;</span>
    <img id="overlayImage" src="" alt="Imagen ampliada">
</div>



<script>
    function showImageOverlay(src) {
        const overlay = document.getElementById('imageOverlay');
        const overlayImage = document.getElementById('overlayImage');
        overlayImage.src = src;
        overlay.style.display = 'flex';
    }

    function closeImageOverlay() {
        const overlay = document.getElementById('imageOverlay');
        overlay.style.display = 'none';
        document.getElementById('overlayImage').src = '';
    }

    // Asignar evento a las imágenes
    document.addEventListener('DOMContentLoaded', function () {
        const logo = document.querySelector('.logo-header img');
        const bandera = document.querySelector('.flag img');

        if (logo) {
            logo.style.cursor = 'pointer';
            logo.addEventListener('click', () => {
                showImageOverlay(logo.src);
            });
        }

        if (bandera) {
            bandera.style.cursor = 'pointer';
            bandera.addEventListener('click', () => {
                showImageOverlay(bandera.src);
            });
        }
    });
</script>




</body>
</html>
