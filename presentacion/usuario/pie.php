<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pie de página mejorado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #598ec4ff;
            --secondary-color: #418abbff;
            --accent-color: #e74c3c;
            --text-light: #ecf0f1;
            --bg-dark: #588296ff;
        }
        
        body {
            min-height: 120vh;
            display: flex;
            flex-direction: column;
        }
        
        .main-content {
            flex: 1;
        }
        
        .custom-footer {
            background: linear-gradient(135deg, var(--primary-color), var(--bg-dark));
            color: var(--text-light);
            padding: 10rem 0 1rem;
            margin-top: auto;
            position: relative;
            overflow: hidden;
        }
        
        .custom-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        }
        
        .footer-section {
            margin-bottom: 4rem;
        }
        
        .footer-title {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 1.2rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--accent-color);
        }
        
        .contact-info, .address-info {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .contact-icon, .address-icon {
           background-color: rgba(255, 255, 255, 1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
            color: var(--secondary-color);
        }
        
        .whatsapp-link {
            display: inline-flex;
            align-items: center;
            background-color: #25D366;
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 5px;
        }
        
        .whatsapp-link:hover {
            background-color: #128C7E;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .social-links {
            display: flex;
            gap: 12px;
            margin-top: 1rem;
        }
        
        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-light);
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }
        
        .map-placeholder {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .user-exclusive {
            background-color: var(--accent-color);
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        .quick-links {
            list-style: none;
            padding: 0;
        }
        
        .quick-links li {
            margin-bottom: 0.5rem;
        }
        
        .quick-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .quick-links a:hover {
            color: var(--secondary-color);
        }
        
        .quick-links i {
            margin-right: 8px;
            font-size: 0.8rem;
            width: 16px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .footer-section {
                text-align: center;
            }
            
            .footer-title::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .contact-info, .address-info {
                justify-content: center;
            }
        }
    </style>
</head>
<body>


    <footer class="custom-footer">
        <div class="container">
            <div class="row">
               
               
                <div class="col-md-4 footer-section">
                    <h5 class="footer-title">Dirección</h5>
                    
                    <div class="address-info">
                        <div class="address-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                           
                            <p class="mb-0">Luis Alberto de Herrera <br>1037<br>Durazno</p>
                        </div>
                    </div>
                    
                    <div class="address-info">
                        <div class="address-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <p class="mb-1">Horario de atención</p>
                            <p class="mb-0">Lunes a Viernes: 9:00 - 12:00 (Verano)</p>
                            <p class="mb-0">Lunes a Viernes: 14:00 - 17:00 (Invierno)</p>
                        </div>
                    </div>
                    

                </div>

                 <div class="col-md-4 footer-section">
              
                    <h5 class="footer-title">Contacto</h5>
                    <div class="contact-info">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <p class="mb-1">Teléfono</p>
                            <p class="mb-0 fw-bold">43628063</p>
                            <a href="https://wa.me/598092749714" class="whatsapp-link mt-2">
                                <i class="fab fa-whatsapp me-2"></i> Escribir por WhatsApp
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-info">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p class="mb-2">Email</p>
                            <p class="mb-1 ">ajupendurazno@adinet.com.uy</p>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                  
                    </div>
                </div>
                
                
                <!-- Enlaces rápidos y área de usuarios -->
                <div class="col-md-4 footer-section">
              
                    <div class="mt-4">
                        <h6 class="footer-title">Soporte al Usuario</h6>
                        <ul class="quick-links">
                            <li><a href="#"><i class="fas fa-question-circle"></i> Centro de Ayuda</a></li>
                            <li><a href="#"><i class="fas fa-file-alt"></i> Políticas de Privacidad</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6 text-md-start">
                        <p>&copy; 2025 AJUPEN. Todos los derechos reservados.</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</body>
</html>