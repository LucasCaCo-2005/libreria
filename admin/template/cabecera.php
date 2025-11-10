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

  <!-- Librerias Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
        <!-- iconos -->
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

    .navbar-text {
      color: #f8f4f4 !important;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.1);
      padding: 8px 16px;
      border-radius: 20px;
    }

    .nav-item.dropdown .dropdown-toggle::after {
      margin-left: 6px;
      vertical-align: middle;
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


    <a class="navbar-brand" href="<?php echo $url; ?>/admin/index.php">
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
          <a class="nav-link" href="<?php echo $url; ?>/admin/index.php">
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
              <a class="dropdown-item" href="<?php echo $url; ?>/admin/panelAdmin.php">
                <i class="fas fa-plus-circle"></i>
                Registro de Talleres
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/admin/VistaT.php">
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
              <a class="dropdown-item" href="<?php echo $url; ?>/admin/productos.php">
                <i class="fas fa-plus-circle"></i>
                Registro
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/admin/VistaLibros.php">
                <i class="fas fa-eye"></i>
                Vista Libros
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/admin/prest.php">
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
              <a class="dropdown-item" href="<?php echo $url; ?>/admin/socios.php">
                <i class="fas fa-user-plus"></i>
                Registro de Socios
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/admin/sociosT.php">
                <i class="fas fa-list"></i>
                Lista de Socios
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/admin/PagosS.php">
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
              <a class="dropdown-item" href="<?php echo $url; ?>/admin/Trab.php">
                <i class="fas fa-briefcase"></i>
                Trabajadores
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo $url; ?>/admin/panelautoridades.php">
                <i class="fas fa-user-shield"></i>
                Autoridades
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

        <!-- Cerrar Sesión -->
        <li class="nav-item">
          <a class="nav-link text-warning" href="<?php echo $url; ?>/admin/seccion/cerrar.php">
            <i class="fas fa-sign-out-alt"></i>
            Cerrar Sesión
          </a>
        </li>
      </ul>

      <!-- Información del Usuario -->
      <span class="navbar-text">
        <i class="fas fa-user-circle"></i>
        <?php echo $nombreUsuario ?? 'Administrador'; ?>
      </span>
    </div>
  </div>
</nav>

<!-- Contenedor Principal -->
<div class="container-fluid mt-3">
  <div class="row">