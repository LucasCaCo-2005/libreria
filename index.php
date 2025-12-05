<?php  
include_once __DIR__ . '/Logica/Admin/bd.php';
// __DIR__ . '/admin/seccion/Talleres.php';
include_once __DIR__ . '/Logica/Admin/Talleres.php';
?>
<?php
// Aviso activo
$sql = "SELECT titulo, contenido FROM avisos WHERE activo = 1 LIMIT 1";
$resultado = $conexion->query($sql);
$mensaje = ($resultado && $resultado->rowCount() > 0) ? $resultado->fetch(PDO::FETCH_ASSOC) : null;

// Talleres
$talleresBD = new TalleresBD();
$listaTalleres = $talleresBD->ListarTalleres();

?>
<!-- Avisos -->
<?php if ($mensaje): ?>
    <?php include 'presentacion/usuario/modalIndex.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const avisoModal = new bootstrap.Modal(document.getElementById('mensajeModal'));
            avisoModal.show();
        });
    </script>
<?php endif; ?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - Asociación de Jubilados y Pensionistas de Durazno</title>
    <link rel="stylesheet" href="css/Usuario/institucion.css">
    <link rel="stylesheet" href="css/Usuario/carrusel.css">
    <?php include_once 'cabecera.php'; ?>
    <style>
     
    </style>
</head>
<body>
    
    <header>
        <h1>
            <img src="imagenes/bandera.png" alt="Bandera" height="120" class="image-thumbnail" id="bandera">
            Asociación de Jubilados y Pensionistas de Durazno
            <img src="imagenes/Logo.png" alt="Logo" height="120" class="image-thumbnail" id="logo">
        </h1>
    </header>

    <div id="imageModal" class="modal">
        <span class="close" id="closeModal">&times;</span>
        <img class="modal-content" id="modalImage">
        <div id="caption"></div>
    </div>

    <script src="logoBandera.js"></script>
    
    <section class="carrusel-section">
        <div class="container">
            <h2 class="titulo-carrusel">Nuestras Actividades</h2>
            
            <div class="carrusel">
                <div class="carrusel-inner">
                    <div class="carrusel-item active">
                        <img src="imagenes/Carrusel/Fachada.jpeg" alt="Fachada de la institución">
                    </div>
                    <div class="carrusel-item">
                        <img src="imagenes/Carrusel/CoroTv.jpg" alt="Coro en televisión">
                    </div>
                    <div class="carrusel-item">
                        <img src="imagenes/Carrusel/EdilAdultoMayor.jpg" alt="Actividad con adultos mayores">
                    </div>
                    <div class="carrusel-item">
                        <img src="imagenes/Carrusel/CoroBiblioteca.jpg" alt="Coro en la biblioteca">
                    </div>
                    <div class="carrusel-item">
                        <img src="imagenes/Carrusel/Reunion.jpg" alt="Reunión de la asociación">
                    </div>
                    <div class="carrusel-item">
                        <img src="imagenes/Carrusel/19dejunio.jpg" alt="Evento del 19 de junio">
                    </div>
                </div>

                <button class="carrusel-btn prev">&#10094;</button>
                <button class="carrusel-btn next">&#10095;</button>
            </div>
        </div>
    </section>
    
    <section class="sobre-nosotros">
        <div class="container">
            <h2 class="titulo-carrusel">Sobre Nosotros</h2>
            
            <div class="historia-completa">
                <div class="historia">
                    <div class="historia-texto">
                        <p>Nuestra Institución fue fundada en <strong>1946</strong> con el objetivo de brindar apoyo a los jubilados y pensionistas del Departamento de Durazno. A lo largo de los años, la institución ha consolidado su rol no solo como un referente en la defensa de los derechos de los adultos mayores, sino también como un espacio cultural y recreativo clave para la integración y el fortalecimiento del sentido de pertenencia de sus miembros.</p>
                        
                        <p>Como organización de tipo sindical y gremial, la Asociación se dedica a una amplia gama de áreas de trabajo enfocadas en la inclusión social, la salud y el fomento de ideas culturales y tiempo libre.</p>
                    </div>
                 
                </div>
                
             
                <div class="video-section">
                    <div class="video-container">
                        <div class="video-wrapper">
                            <video id="institucionVideo" src="imagenes/videos/Talleres.mp4" controls autoplay muted playsinline>
                                Tu navegador no soporta el elemento de video.
                            </video>
                            <div class="video-controls-overlay">
                                <button class="control-btn" onclick="togglePlay()">Reproducir/Pausar</button>
                                <button class="control-btn" onclick="toggleMute()">Silenciar/Activar</button>
                            </div>
                        </div>
                        <div class="video-info">
                            <h3>Conoce Nuestros Talleres</h3>
                            <p>En este video podrás ver algunas de las actividades y talleres que realizamos regularmente en nuestra institución. Desde talleres creativos hasta actividades recreativas, siempre buscamos enriquecer la vida de nuestros asociados.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="areas-trabajo">
                <h3 class="titulo-carrusel">Nuestras Áreas de Trabajo</h3>
                
                <div class="areas-grid">
                    <div class="area-card">
                        <div class="area-icon">👵</div>
                        <h4 class="area-title">Personas Adultas Mayores</h4>
                        <p>Promoviendo la integración, la participación activa y el bienestar de los adultos mayores en la sociedad.</p>
                    </div>
                    
                    <div class="area-card">
                        <div class="area-icon">🏥</div>
                        <h4 class="area-title">Atención Médica</h4>
                        <p>Ofreciendo servicios de salud y bienestar a los asociados, garantizando un acceso adecuado a la atención médica.</p>
                    </div>
                    
                    <div class="area-card">
                        <div class="area-icon">🎭</div>
                        <h4 class="area-title">Actividades Recreativas</h4>
                        <p>Desarrollando propuestas de recreación y esparcimiento que contribuyen a la calidad de vida de nuestros miembros.</p>
                    </div>
                    
                    <div class="area-card">
                        <div class="area-icon">🎨</div>
                        <h4 class="area-title">Arte y Cultura Popular</h4>
                        <p>Impulsando actividades que fomentan la creatividad y expresión cultural, promoviendo la participación en eventos locales.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="valores">
        <div class="container">
            <h2 class="titulo-carrusel">Nuestros Valores</h2>
            
            <div class="valores-grid">
                <div class="valor-item">
                    <div class="valor-icon">🤝</div>
                    <h3>Solidaridad</h3>
                    <p>Apoyamos mutuamente a nuestros miembros en todas las circunstancias.</p>
                </div>
                
                <div class="valor-item">
                    <div class="valor-icon">💪</div>
                    <h3>Resiliencia</h3>
                    <p>Superamos juntos los desafíos con fortaleza y determinación.</p>
                </div>
                
                <div class="valor-item">
                    <div class="valor-icon">❤️</div>
                    <h3>Compromiso</h3>
                    <p>Trabajamos incansablemente por el bienestar de nuestros asociados.</p>
                </div>
                
                <div class="valor-item">
                    <div class="valor-icon">🎯</div>
                    <h3>Trayectoria</h3>
                    <p>Más de 75 años de experiencia nos avalan.</p>
                </div>
            </div>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="css/carrusel.js"></script>
    
    <script>
        // Controladores para el video
        const video = document.getElementById('institucionVideo');
        
        function togglePlay() {
            if (video.paused || video.ended) {
                video.play();
            } else {
                video.pause();
            }
        }
        
        function toggleMute() {
            video.muted = !video.muted;
        }
        
        // Autoplay con mute por defecto 
        video.muted = true;
        
        // Pausar video cuando no está visible
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                video.pause();
            }
        });
    </script>

    <?php include_once 'presentacion/usuario/pie.php' ?>
</body>
</html>