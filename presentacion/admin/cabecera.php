<?php 
//Garantizo que haya una sesión activa 
if (session_status() === PHP_SESSION_NONE) {
  // y creo la sesion.
    session_start();
}
include_once __DIR__ . '/../../Logica/Admin/authHelper.php';
AuthHelper::requerirAdministrador();


$url = "http://" . $_SERVER['HTTP_HOST'] . "/sitioweb";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/admin/cab.css">
  <title>Panel Administrativo - Biblioteca</title>

  <link rel="stylesheet" href="../../css/usuario/bootstrap.min.css">
  <link rel="stylesheet" href="../css/Usuario/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 
  <style>
   
  
  </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-admin">
  <div class="container-fluid">

    <a class="navbar-brand" href="<?php echo $url; ?>/Presentacion/Admin/index.php">
      <i class="fas fa-cogs"></i>
      Panel Admin
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin"
      aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarAdmin">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url; ?>/Presentacion/Admin/index.php">
            <i class="fas fa-home"></i>
            Inicio
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownTalleres" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-palette"></i>
            Talleres
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownTalleres">
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/panelAdmin.php">
                <i class="fas fa-plus-circle"></i>
                Registro de Talleres
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/VistaT.php">
                <i class="fas fa-eye"></i>
                Vista Talleres
              </a>
            </li>

          </ul>
        </li>

        <!-- Libros -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownLibros" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-book"></i>
            Libros
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownLibros">
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/productos.php">
                <i class="fas fa-plus-circle"></i>
                Registro
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/VistaLibros.php">
                <i class="fas fa-eye"></i>
                Vista Libros
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/prest.php">
                <i class="fas fa-exchange-alt"></i>
                Préstamos
              </a>
            </li>

             <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/Reservas.php">
                <i class="fas fa-user-plus"></i>
               Reservas
              </a>
            </li>
          </ul>
        </li>

        <!-- Socios -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownSocios" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-users"></i>
            Socios
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownSocios">
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/socios.php">
                <i class="fas fa-user-plus"></i>
                Registro de Socios
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/sociosT.php">
                <i class="fas fa-list"></i>
                Lista de Socios
              </a>
            </li>
          </ul>
        </li>

        <!-- Empleados -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownEmpleados" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-tie"></i>
            Empleados
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownEmpleados">
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/Trab.php">
                <i class="fas fa-briefcase"></i>
                Trabajadores
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/panelautoridades.php">
                <i class="fas fa-user-shield"></i>
                Autoridades
              </a>
            </li>

             <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/panelavisos.php">
                <i class="fas fa-user-shield"></i>
                Avisos
              </a>
            </li>
          </ul>
        </li>

            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownEmpleados" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-tie"></i>
            Pagos
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownEmpleados">
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/pagoss.php">
                <i class="fas fa-briefcase"></i>
               Gestion de Pagos
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url; ?>">
            <i class="fas fa-external-link-alt"></i>
            Ver Sitio Web
          </a>
        </li>

        <!-- Cerrar Sesión en el menú principal (oculto en desktop, visible en móvil) -->
        <li class="nav-item d-lg-none">
        <a href="../usuario/logout.php" class="user-option logout">
        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
      </a>
        </li>
      </ul>

      <!-- Botón de usuario con popup (reemplaza el navbar-text) -->
      <button class="btn btn-user-admin" onclick="openUserModal()">
        <div class="user-avatar">
          <i class="fas fa-user-cog"></i>
        </div>
        <span class="d-none d-md-inline"><?php echo $nombreUsuario ?? 'Administrador'; ?></span>
        <i class="fas fa-chevron-down d-none d-md-inline"></i>
      </button>
    </div>
  </div>
</nav>

<!-- Modal para opciones de usuario -->
<div id="userModal" class="user-modal">
  <div class="user-modal-content">
    <div class="user-modal-header">
      <button class="user-modal-close" onclick="closeUserModal()">
        <i class="fas fa-times"></i>
      </button>
      <div class="user-avatar-large">
        <i class="fas fa-user-cog"></i>
      </div>
      <h5 class="mb-1"><?php echo $nombreUsuario ?? 'Administrador'; ?></h5>
      <small>Panel Administrativo</small>
    </div>
    <div class="user-modal-body">
      <a href="<?php echo $url; ?>/Presentacion/Admin/index.php" class="user-option">
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>
      <a href="<?php echo $url; ?>../Presentacion/usuario/Perfil.php" class="user-option">
        <i class="fas fa-user-edit"></i> Mi Perfil
      </a>
    
      <a href="<?php echo $url; ?>" class="user-option">
        <i class="fas fa-external-link-alt"></i> Ver Sitio Web
      </a>
      <a href="../usuario/logout.php" class="user-option logout">
        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
      </a>
    </div>
  </div>
</div>

<!-- Contenedor Principal -->
<div class="container-fluid mt-3">
  <div class="row">

<script>
  // Funciones para el modal de usuario
  function openUserModal() {
    document.getElementById('userModal').style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Previene scroll del body
  }
  
  function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
    document.body.style.overflow = 'auto'; // Restaura scroll del body
  }
  
  // Cerrar modal al hacer clic fuera del contenido
  document.getElementById('userModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeUserModal();
    }
  });
  
  // Cerrar modal con tecla ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeUserModal();
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