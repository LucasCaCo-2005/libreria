<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrativo - Biblioteca</title>

  <link rel="stylesheet" href="../../css/usuario/bootstrap.min.css">
  <link rel="stylesheet" href="../css/Usuario/bootstrap.min.css">
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
    
    .nav-link {
      color: white !important;
      font-weight: 500;
      margin: 0 8px;
      padding: 8px 16px !important;
      border-radius: 6px;
      transition: var(--transition);
    }
    
    .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.15);
      transform: translateY(-2px);
    }
    
    .nav-link.active {
      background-color: rgba(255, 255, 255, 0.2);
      font-weight: 600;
    }
    
    /* Botones */
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
    
    .btn-login {
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 6px;
      padding: 8px 20px;
      font-weight: 600;
      transition: var(--transition);
      display: flex;
      align-items: center;
      margin-left: 10px;
    }
    
    .btn-login:hover {
      background-color: white;
      color: var(--primary-color);
      transform: translateY(-2px);
    }
    
    .btn-user {
      background: transparent;
      border: 2px solid rgba(255, 255, 255, 0.3);
      color: white;
      border-radius: 6px;
      padding: 8px 20px;
      font-weight: 600;
      transition: var(--transition);
      display: flex;
      align-items: center;
      margin-left: 10px;
    }
    
    .btn-user:hover {
      background-color: rgba(255, 255, 255, 0.15);
      transform: translateY(-2px);
    }
    
    /* Modal personalizado */
    .user-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 9999;
      align-items: center;
      justify-content: center;
    }
    
    .user-modal-content {
      background: white;
      border-radius: 12px;
      padding: 0;
      width: 90%;
      max-width: 300px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      animation: modalSlideIn 0.3s ease;
    }
    
    @keyframes modalSlideIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .user-modal-header {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      color: white;
      padding: 20px;
      border-radius: 12px 12px 0 0;
      text-align: center;
    }
    
    .user-avatar-large {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 10px;
      font-size: 1.5rem;
    }
    
    .user-modal-body {
      padding: 20px;
    }
    
    .user-option {
      display: flex;
      align-items: center;
      padding: 12px 0;
      text-decoration: none;
      color: var(--dark-color);
      transition: var(--transition);
      border-bottom: 1px solid #f0f0f0;
    }
    
    .user-option:last-child {
      border-bottom: none;
    }
    
    .user-option:hover {
      color: var(--primary-color);
      padding-left: 10px;
    }
    
    .user-option i {
      margin-right: 12px;
      width: 20px;
      text-align: center;
    }
    
    .user-option.logout {
      color: #dc3545;
    }
    
    .user-option.logout:hover {
      color: #c82333;
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
      
      .btn-admin,
      .btn-login,
      .btn-user {
        margin-top: 10px;
        width: 100%;
        justify-content: center;
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <div class="container">
    <a class="navbar-brand" href="../../index.php">
      <i class="fas fa-book"></i> Biblioteca
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBiblioteca"
      aria-controls="navbarBiblioteca" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarBiblioteca">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="../../index.php">
            <i class="fas fa-home"></i> Inicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productos.php">
            <i class="fas fa-book"></i> Libros
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
          <a class="nav-link" href="mis_reservas.php">
            <i class="fas fa-calendar-check"></i> Reservas
          </a>
        </li>
      </ul>
      
      <div class="d-flex align-items-center">
        <!-- Botón Panel Admin -->
        <button class="btn btn-admin" onclick="window.location.href='../admin/paneladmin.php'">
          <i class="fas fa-user-shield"></i> Panel Admin
        </button>
        
        <!-- Estado de login/logout -->
        <?php if (isset($_SESSION['usuario'])): ?>
          <!-- Usuario logueado - Botón que abre modal -->
          <button class="btn btn-user" onclick="openUserModal()">
            <i class="fas fa-user"></i>
            <span class="d-none d-md-inline ms-2"><?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></span>
          </button>
        <?php else: ?>
          <!-- Usuario no logueado -->
          <button class="btn btn-login" onclick="window.location.href='login.php'">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<!-- Modal para opciones de usuario -->
<div id="userModal" class="user-modal">
  <div class="user-modal-content">
    <div class="user-modal-header">
      <div class="user-avatar-large">
        <i class="fas fa-user"></i>
      </div>
      <h5 class="mb-0"><?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></h5>
      <small><?php echo htmlspecialchars($_SESSION['usuario']['correo']); ?></small>
    </div>
    <div class="user-modal-body">
      <a href="perfil.php" class="user-option">
        <i class="fas fa-user-circle"></i> Mi Perfil
      </a>
      <a href="mis_reservas.php" class="user-option">
        <i class="fas fa-calendar-check"></i> Mis Reservas
      </a>
      <a href="logout.php" class="user-option logout">
        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
      </a>
    </div>
  </div>
</div>

<!-- Espacio para el contenido debajo del navbar fijo -->
<div style="height: 80px;"></div>

<script>
  // Funciones para el modal de usuario
  function openUserModal() {
    document.getElementById('userModal').style.display = 'flex';
  }
  
  function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
  }
  
  // Cerrar modal al hacer clic fuera
  document.getElementById('userModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeUserModal();
    }
  });
  
  // Cerrar modal con ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeUserModal();
    }
  });
  
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