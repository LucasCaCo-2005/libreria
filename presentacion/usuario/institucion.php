<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - Asociación de Jubilados y Pensionistas de Durazno</title>
    <link rel="stylesheet" href="css/carrusel.css">
     <link rel="stylesheet" href="../../css/usuario/institucion.css">

    <?php include_once 'cabecera.php'; ?>
 
   <style>
         
   <?php include_once 'css/institucion.css'; ?> 
    
    </style>
</head>
<body>
    

<header>
      <h1>
            <img src="./images/bandera.png" alt="Bandera" height="120" class="image-thumbnail" id="bandera">
            Asociación de Jubilados y Pensionistas de Durazno
            <img src="./images/Logo.png" alt="Logo" height="120" class="image-thumbnail" id="logo">
        </h1>
    </header>

    <!-- Modal -->
    <div id="imageModal" class="modal">
        <span class="close" id="closeModal">&times;</span>
        <img class="modal-content" id="modalImage">
        <div id="caption"></div>
    </div>

    <script src="js/logoBandera.js"></script>
</header>
    
    
    <section class="carrusel-section">
        <div class="container">
            <h2 class="titulo-carrusel">Nuestras Actividades</h2>
            
            <div class="carrusel">
                <div class="carrusel-inner">
                    <div class="carrusel-item active">
                        <img src="images/Carrusel/Fachada.jpeg" alt="Fachada de la institución">
                    </div>
                    <div class="carrusel-item">
                        <img src="images/Carrusel/CoroTv.jpg" alt="Coro en televisión">
                    </div>
                    <div class="carrusel-item">
                        <img src="images/Carrusel/EdilAdultoMayor.jpg" alt="Actividad con adultos mayores">
                    </div>
                    <div class="carrusel-item">
                        <img src="images/Carrusel/CoroBiblioteca.jpg" alt="Coro en la biblioteca">
                    </div>
                    <div class="carrusel-item">
                        <img src="images/Carrusel/Reunion.jpg" alt="Reunión de la asociación">
                    </div>
                    <div class="carrusel-item">
                        <img src="images/Carrusel/19dejunio.jpg" alt="Evento del 19 de junio">
                    </div>
                </div>

                <!-- Botones de control -->
                <button class="carrusel-btn prev">&#10094;</button>
                <button class="carrusel-btn next">&#10095;</button>
            </div>
        </div>
    </section>
    
    <section class="sobre-nosotros">
        <div class="container">
            <h2 class="titulo-carrusel">Sobre Nosotros</h2>
            
            <div class="historia">
                <div class="historia-texto">
                    <p>Nuestra Institución fue fundada en <strong>1946</strong> con el objetivo de brindar apoyo a los jubilados y pensionistas del Departamento de Durazno. A lo largo de los años, la institución ha consolidado su rol no solo como un referente en la defensa de los derechos de los adultos mayores, sino también como un espacio cultural y recreativo clave para la integración y el fortalecimiento del sentido de pertenencia de sus miembros.</p>
                    
                    <p>Como organización de tipo sindical y gremial, la Asociación se dedica a una amplia gama de áreas de trabajo enfocadas en la inclusión social, la salud y el fomento de ideas culturales y tiempo libre.</p>
                </div>
                <div class="historia-imagen">
                    <img src="https://via.placeholder.com/600x400/4a6491/ffffff?text=Historia+de+Nuestra+Institución" alt="Historia de nuestra institución">
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
    
   
    
    <script src="../../css/usuario/carrusel.js"></script>
</body>
</html>