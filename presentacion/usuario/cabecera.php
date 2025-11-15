<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Verificar el contenido de la sesión
if (isset($_SESSION['id'])) {
    echo "ID de usuario en la sesión: " . $_SESSION['id'];
} else {
    echo "No se encuentra el ID del usuario en la sesión.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" contnt="width=device-width, initial-scale=1.0"> 
  <title>Biblioteca</title>
   <!-- ✅ Bootstrap 5 CSS -->
  <link rel="stylesheet" href="./estilos/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 
  <style>
    :root {
      --primary-color: #2c5aa0;
      --secondary-color: #35c4f3;
      --accent-color: #ff6b6b;
      --light-color: #f8f9fa;
      --dark-color: #343a40;
      --transition: all 0.3s ease;
    }
    
    /* 🔹 Navbar personalizado */
    .navbar-custom {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 12px 0;
      transition: var(--transition);
    }
    
    .navbar-custom.scrolled {
      padding: 8px 0;
      background: var(--primary-color) !important;
    }
    
    .navbar-brand {
      font-weight: 700;
      font-size: 1.8rem;
      display: flex;
      align-items: center;
      color: white !important;
      transition: var(--transition);
    }
    
    .navbar-brand i {
      margin-right: 10px;
      font-size: 1.6rem;
    }
    
    .navbar-brand:hover {
      transform: translateY(-2px);
      color: var(--light-color) !important;
    }
    
    .nav-link {
      color: white !important;
      font-weight: 500;
      margin: 0 8px;
      padding: 8px 16px !important;
      border-radius: 6px;
      transition: var(--transition);
      position: relative;
    }
    
    .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.15);
      transform: translateY(-2px);
    }
    
    .nav-link.active {
      background-color: rgba(255, 255, 255, 0.2);
      font-weight: 600;
    }
    
    .nav-link i {
      margin-right: 6px;
      font-size: 0.9rem;
    }
    
    /* Indicador para enlace activo */
    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 2px;
      background-color: white;
      transition: var(--transition);
    }
    
    .nav-link:hover::after,
    .nav-link.active::after {
      width: 70%;
    }
    
    /* Dropdown personalizado */
    .dropdown-menu {
      border: none;
      border-radius: 8px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
      padding: 8px 0;
      margin-top: 8px !important;
    }
    
    .dropdown-item {
      padding: 10px 20px;
      transition: var(--transition);
      display: flex;
      align-items: center;
    }
    
    .dropdown-item i {
      margin-right: 10px;
      width: 18px;
      text-align: center;
    }
    
    .dropdown-item:hover {
      background-color: rgba(44, 90, 160, 0.1);
      padding-left: 25px;
    }
    
    .dropdown-divider {
      margin: 8px 0;
    }
    
    /* Botón Admin personalizado */
    .btn-admin {
      background-color: white;
      color: var(--primary-color);
      border: none;
      border-radius: 6px;
      padding: 8px 20px;
      font-weight: 600;
      transition: var(--transition);
      display: flex;
      align-items: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-admin:hover {
      background-color: var(--light-color);
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-admin i {
      margin-right: 8px;
    }
    
    /* Navbar toggler personalizado */
    .navbar-toggler {
      border: none;
      padding: 4px 8px;
    }
    
    .navbar-toggler:focus {
      box-shadow: none;
    }
    
    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    
    /* Responsive */
    @media (max-width: 991px) {
      .navbar-collapse {
        margin-top: 15px;
        padding: 15px;
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        backdrop-filter: blur(10px);
      }
      
      .nav-link {
        margin: 4px 0;
      }
      
      .btn-admin {
        margin-top: 10px;
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>
<body>

<!-- 🔹 Navbar principal mejorado -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      
       
    </a>

    <!-- Botón responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBiblioteca"
      aria-controls="navbarBiblioteca" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarBiblioteca">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link " href="../../index.php">
            <i class="fas fa-home"></i> Inicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productos.php">
            <i class="fas fa-book"></i> Libros
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="nosotros.php" hidden>
            <i class="fas fa-users"></i> Nosotros
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="talleres.php">
            <i class="fas fa-palette"></i> Talleres
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="autoridades.php">
            <i class="fas fa-user-tie"></i> Autoridades
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="medico.php">
            <i class="fas fa-stethoscope"></i> Médico
          </a>
        </li>
<li class="nav-item">
<a class="nav-link" href="../Persistencia/reserva_carrito.php">
         Reservas
    </a>
</li>

        <!-- Dropdown mejorado -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownMenu" role="button"
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i> Más opciones
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
            <li><a class="dropdown-item" href="#">
              <i class="fas fa-calendar-alt"></i> Eventos
            </a></li>
            <li><a class="dropdown-item" href="#">
              <i class="fas fa-newspaper"></i> Noticias
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">
              <i class="fas fa-info-circle"></i> Ayuda
            </a></li>
          </ul>
        </li>
      </ul>
      
      <!-- Botón Admin mejorado -->
      <button class="btn btn-admin" onclick="window.location.href='../admin/paneladmin.php'">
        <i class="fas fa-user-shield"></i> Panel Admin
      </button>
         <?php include_once '../../logica/usuario/loginBanner.php'; ?>
    </div>
  </div>
</nav>

<!-- Espacio para el contenido debajo del navbar fijo -->
<div style="height: 80px;"></div>

<div class="container mt-4">
  <div class="row">
    <!-- Tu contenido aquí -->
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Efecto de navbar al hacer scroll
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar-custom');
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
  
  // Activar elemento de navegación actual
  document.addEventListener('DOMContentLoaded', function() {
    const currentLocation = location.href;
    const menuItems = document.querySelectorAll('.nav-link');
    
    menuItems.forEach(item => {
      if (item.href === currentLocation) {
        item.classList.add('active');
      }
    });
  });
</script>

</body>
</html>