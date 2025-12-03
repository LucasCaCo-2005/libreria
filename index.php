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
      
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
       
        header {

            color: black ;
            padding: 2rem 0;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .tagline {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 300;
        }
        
       
        .carrusel-section {
            padding: 3rem 0;
            background-color: white;
        }
        
        .titulo-carrusel {
            text-align: center;
            margin-bottom: 2rem;
            color: #2c3e50;
            font-size: 2.2rem;
            position: relative;
        }
        
        .titulo-carrusel::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: #e67e22;
            margin: 0.5rem auto;
            border-radius: 2px;
        }
        
        .sobre-nosotros {
            padding: 4rem 0;
            background-color: white;
        }
        
        .historia {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            align-items: center;
            margin-bottom: 3rem;
        }
        
        .historia-texto {
            flex: 1;
            min-width: 300px;
        }
        
        .historia-imagen {
            flex: 1;
            min-width: 300px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .historia-imagen img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.5s ease;
        }
        
        .historia-imagen:hover img {
            transform: scale(1.05);
        }
        
        .areas-trabajo {
            margin-top: 3rem;
        }
        
        .areas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .area-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 4px solid #e67e22;
        }
        
        .area-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .area-icon {
            font-size: 2.5rem;
            color: #e67e22;
            margin-bottom: 1rem;
        }
        
        .area-title {
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            color: #2c3e50;
        }
        
  
        .valores {
            background-color: #f5f7fa;
            padding: 4rem 0;
            text-align: center;
        }
        
        .valores-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .valor-item {
            padding: 1.5rem;
        }
        
        .valor-icon {
            font-size: 2.5rem;
            color: #3498db;
            margin-bottom: 1rem;
        }
        
    
     
        @media (max-width: 768px) {
            .historia {
                flex-direction: column;
            }
            
            .historia-texto, .historia-imagen {
                width: 100%;
            }
            
            .titulo-carrusel {
                font-size: 1.8rem;
            }
        }
    
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

    <!-- Modal -->
    <div id="imageModal" class="modal">
        <span class="close" id="closeModal">&times;</span>
        <img class="modal-content" id="modalImage">
        <div id="caption"></div>
    </div>

    <script src="logoBandera.js"></script>
</header>
    
    
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script src="css/carrusel.js"></script>

<?php include_once 'presentacion/usuario/pie.php' ?>
</body>
</html>