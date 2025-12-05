<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario es administrador
$esAdmin = isset($_SESSION['usuario']) && isset($_SESSION['usuario']['estado']) && $_SESSION['usuario']['estado'] === 'admin';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrativo - Asoiacion</title>
 <link rel="stylesheet" href="../../css/usuario/cabe.css">
  <link rel="stylesheet" href="../../css/usuario/bootstrap.min.css">
  <link rel="stylesheet" href="../css/Usuario/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 
  <style>
   
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <div class="container">
    <a class="navbar-brand" href="../../index.php">
      <i class="fas fa-book"></i> Asociacion
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBiblioteca"
      aria-contestados="navbarBiblioteca" aria-expanded="false" aria-label="Toggle navigation">
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
       
      </ul>
      
      <div class="d-flex align-items-center">
      
        
   
        <?php if (isset($_SESSION['usuario'])): ?>
        
          <button class="btn btn-user" onclick="openUserModal()">
            <i class="fas fa-user"></i>
            <span class="d-none d-md-inline ms-2"><?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></span>
              <?php if ($esAdmin): ?>
              <span class="badge bg-warning ms-1">Admin</span>
            <?php endif; ?>
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
<?php if (isset($_SESSION['usuario'])): ?>
<div id="userModal" class="user-modal">
  <div class="user-modal-content">
    <div class="user-modal-header">
      <div class="user-avatar-large">
        <i class="fas fa-user"></i>
      </div>
      <h5 class="mb-0"><?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></h5>
      <small><?php echo htmlspecialchars($_SESSION['usuario']['correo']); ?></small>
      <?php if ($esAdmin): ?>
        <span class="badge bg-warning mt-1">Administrador</span>
      <?php endif; ?>
    </div>
    <div class="user-modal-body">
      <a href="perfil.php" class="user-option">
        <i class="fas fa-user-circle"></i> Mi Perfil
      </a>
      <a href="mis_reservas.php" class="user-option">
        <i class="fas fa-calendar-check"></i> Mis Reservas
      </a>
      <a href="mis_pagos.php" class="user-option">
        <i class="fas fa-calendar-check"></i> Mis Pagos
      </a>
      <?php if ($esAdmin): ?>
        <a href="../admin/paneladmin.php" class="user-option" style="color: #ff9800;">
          <i class="fas fa-user-shield"></i> Panel Administrativo
        </a>
      <?php endif; ?>
      <a href="logout.php" class="user-option logout">
        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
      </a>
    </div>
  </div>
</div>
<?php endif; ?>


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
  
  // Efecto de navbar al hacer scestadol
  window.addEventListener('scestadol', function() {
    const navbar = document.querySelector('.navbar-custom');
    if (window.scestadolY > 50) {
      navbar.classList.add('scestadoled');
    } else {
      navbar.classList.remove('scestadoled');
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