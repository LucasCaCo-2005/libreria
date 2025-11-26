<?php 
//Garantizo que haya una sesión activa 
if (session_status() === PHP_SESSION_NONE) {
  // y creo la sesion.
    session_start();
}

$url = "http://" . $_SERVER['HTTP_HOST'] . "/sitioweb";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrativo - Biblioteca</title>

   <!-- ✅ Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../css/usuario/bootstrap.min.css">
  <link rel="stylesheet" href="../css/Usuario/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 
  <style>
      :root {
      --color-primary: #4a80e2ff;
      --color-secondary: #4a80e2ff;
       --color-dark: #5a4a4a;
      --color-light: #f8f4f4;
      --color-hover: #b98c8c;
    }
   
    /* Estilo de la barra de navegaciòn, degradado rojo-oscuro, sombra y estilo visual atractivo */
    .navbar-admin {
      background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-dark) 100%) !important;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      padding: 12px 0;
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.5rem;
      color: #f8f4f4 !important;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .navbar-brand i {
      font-size: 1.8rem;
    }

     /* Estilo de los enlaces de navegación,  efecto hover elegante (fondo semitransparente y desplazamiento)*/
    .nav-link {
      color: #f8f4f4 !important;
      font-weight: 500;
      padding: 8px 16px !important;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .nav-link:hover {
      background: rgba(255, 255, 255, 0.15);
      transform: translateY(-2px);
    }

    /* Estilo de los menues bordes redondeados, sombra, animación al pasar el ratón y cambio de color. */
    .dropdown-menu {
      background: #f8f4f4;
      border: 1px solid #e8e0e0;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      padding: 8px;
    }

    .dropdown-item {
      color: var(--color-dark);
      padding: 10px 16px;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .dropdown-item:hover {
      background: var(--color-secondary);
      color: #f8f4f4;
      transform: translateX(5px);
    }

    .dropdown-divider {
      border-color: #e8e0e0;
      margin: 8px 0;
    }

    .navbar-toggler {
      border: 2px solid #f8f4f4;
      padding: 6px 10px;
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28248, 244, 244, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    /* Botón de usuario con popup */
    .btn-user-admin {
      background: rgba(255, 255, 255, 0.1);
      color: #f8f4f4;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 20px;
      padding: 8px 16px;
      font-weight: 500;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
    }

    .btn-user-admin:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-2px);
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
    }

    /* Modal personalizado para usuario */
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
      border-radius: 16px;
      padding: 0;
      width: 90%;
      max-width: 350px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
      animation: modalSlideIn 0.3s ease;
      overflow: hidden;
    }

    @keyframes modalSlideIn {
      from {
        opacity: 0;
        transform: translateY(-30px) scale(0.9);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .user-modal-header {
      background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-dark) 100%);
      color: white;
      padding: 25px;
      text-align: center;
      position: relative;
    }

    .user-avatar-large {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 15px;
      font-size: 1.8rem;
      border: 3px solid rgba(255, 255, 255, 0.3);
    }

    .user-modal-close {
      position: absolute;
      top: 15px;
      right: 15px;
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
      border-radius: 50%;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .user-modal-close:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: rotate(90deg);
    }

    .user-modal-body {
      padding: 20px;
    }

    .user-option {
      display: flex;
      align-items: center;
      padding: 15px 0;
      text-decoration: none;
      color: var(--color-dark);
      transition: all 0.3s ease;
      border-bottom: 1px solid #f0f0f0;
    }

    .user-option:last-child {
      border-bottom: none;
    }

    .user-option:hover {
      color: var(--color-primary);
      padding-left: 15px;
      background: rgba(74, 128, 226, 0.05);
    }

    .user-option i {
      margin-right: 15px;
      width: 20px;
      text-align: center;
      font-size: 1.1rem;
    }

    .user-option.logout {
      color: #dc3545;
      border-top: 2px solid #f0f0f0;
      margin-top: 10px;
      padding-top: 20px;
    }

    .user-option.logout:hover {
      color: #c82333;
      background: rgba(220, 53, 69, 0.05);
    }

    .nav-link.active {
      background: rgba(255, 255, 255, 0.2);
      font-weight: 600;
    }

    /* Responsive (menú móvil) Cuando la pantalla es pequeña, el menú se convierte en un panel colapsable con fondo oscuro.*/
    @media (max-width: 991.98px) {
      .navbar-collapse {
        background: var(--color-dark);
        padding: 20px;
        border-radius: 12px;
        margin-top: 15px;
      }
      
      .nav-link {
        padding: 12px 16px !important;
      }
      
      .dropdown-menu {
        background: rgba(248, 244, 244, 0.95);
        margin: 8px 0;
      }

      .btn-user-admin {
        width: 100%;
        justify-content: center;
        margin-top: 10px;
      }
    }

    /* Animaciones */
    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .navbar-collapse.show {
      animation: fadeInDown 0.3s ease;
    }

    /* notificaciones */
    .nav-badge {
      background: var(--color-secondary);
      color: #f8f4f4;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      font-size: 0.7rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-left: 5px;
    }
  
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
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/Presentacion/Admin/PagosS.php">
                <i class="fas fa-money-bill-wave"></i>
                Gestión de Pagos
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

        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url; ?>">
            <i class="fas fa-external-link-alt"></i>
            Ver Sitio Web
          </a>
        </li>

        <!-- Cerrar Sesión en el menú principal (oculto en desktop, visible en móvil) -->
        <li class="nav-item d-lg-none">
          <a class="nav-link text-warning" href="<?php echo $url; ?>/cerrar.php">
            <i class="fas fa-sign-out-alt"></i>
            Cerrar Sesión
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
      <a href="<?php echo $url; ?>/Presentacion/Admin/perfil.php" class="user-option">
        <i class="fas fa-user-edit"></i> Mi Perfil
      </a>
      <a href="<?php echo $url; ?>/Presentacion/Admin/configuracion.php" class="user-option">
        <i class="fas fa-cog"></i> Configuración
      </a>
      <a href="<?php echo $url; ?>" class="user-option">
        <i class="fas fa-external-link-alt"></i> Ver Sitio Web
      </a>
      <a href="<?php echo $url; ?>/cerrar.php" class="user-option logout">
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