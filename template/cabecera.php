<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>Biblioteca</title>

  <!-- ✅ Bootstrap 5 CSS -->
  <link rel="stylesheet" href="./estilos/bootstrap.min.css">

  <style>
    /* 🔹 Color celeste personalizado */
    .navbar-celeste {
      background-color: #35c4f3ff !important; /* Celeste brillante */
    }

    /* Opcional: cambia color del texto si el fondo es muy claro */
    .navbar-celeste .nav-link,
    .navbar-celeste .navbar-brand {
      color: white !important;
    }

    .navbar-celeste .nav-link:hover {
      color: #e0f7ff !important;
    }
  </style>
</head>
<body>

<!-- 🔹 Navbar principal -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-celeste">
  <div class="container-fluid">
    <a class="navbar-brand" href="./admin/paneladmin.php">Admin</a>



    <!-- Botón responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBiblioteca"
      aria-controls="navbarBiblioteca" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarBiblioteca">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="productos.php">Libros</a></li>
        <li class="nav-item"><a class="nav-link" href="nosotros.php">Nosotros</a></li>
        <li class="nav-item"><a class="nav-link" href="talleres.php">Talleres</a></li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownMenu" role="button"
             data-bs-toggle="dropdown" aria-expanded="false">
            Más opciones
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
            <li><a class="dropdown-item" href="#">Acción 1</a></li>
            <li><a class="dropdown-item" href="#">Acción 2</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Enlace separado</a></li>
          </ul>
        </li>
      </ul>
        <button onclick="window.location.href=''">Admin</button>
    </div>
     
  </div>
   
</nav>

<div class="container mt-4">
  <div class="row">