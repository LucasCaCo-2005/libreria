<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
} else {
    if ($_SESSION['usuario'] == "ok") {
        $nombreUsuario = $_SESSION['nombre'];
    }
}

$url = "http://" . $_SERVER['HTTP_HOST'] . "/sitioweb";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrador</title>

  <!-- ✅ Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
</head>
<body>

<!-- 🔹 Navbar Bootstrap 5 -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">

    <a class="navbar-brand" href="#">Administrador</a>

    <!-- Botón responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin"
      aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarAdmin">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url; ?>/admin/inicio.php">Inicio</a>
        </li>

        <!-- Talleres -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownTalleres" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Talleres
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownTalleres">
            <li><a class="dropdown-item" href="<?php echo $url; ?>/admin/panelAdmin.php">Registro de talleres</a></li>
            <li><a class="dropdown-item" href="<?php echo $url; ?>/admin/VistaT.php">Vista Talleres</a></li>
          </ul>
        </li>

        <!-- Libros -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownLibros" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Libros
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownLibros">
            <li><a class="dropdown-item" href="<?php echo $url; ?>/admin/productos.php">Registro</a></li>
            <li><a class="dropdown-item" href="<?php echo $url; ?>/admin/VistaLibros.php">Vista Libros</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?php echo $url; ?>/admin/prest.php">Préstamos</a></li>
          </ul>
        </li>

        <!-- Socios -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownSocios" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Socios
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownSocios">
            <li><a class="dropdown-item" href="<?php echo $url; ?>/admin/socios.php">Registro de Socios</a></li>
            <li><a class="dropdown-item" href="<?php echo $url; ?>/admin/sociosT.php">Socios</a></li>
          </ul>
        </li>

        <!-- Empleados -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownEmpleados" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Empleados
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownEmpleados">
            <li><a class="dropdown-item" href="<?php echo $url; ?>/admin/Trab.php">Trabajadores</a></li>
            <li><a class="dropdown-item" href="<?php echo $url; ?>/admin/medico.php">Médicos</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url; ?>">Ver sitio web</a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-danger" href="<?php echo $url; ?>/admin/seccion/cerrar.php">Cerrar Sesión</a>
        </li>
      </ul>

      <span class="navbar-text">
        👤 <?php echo $nombreUsuario ?? ''; ?>
      </span>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="row">
