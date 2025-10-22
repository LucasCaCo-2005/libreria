<?php
session_start();
if(!isset($_SESSION['usuario'])){
    $_SESSION['usuario'] = 'ok';
    $_SESSION['nombre'] = 'Lucas';
}
$nombreUsuario = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Test Dropdown</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Hola <?php echo $nombreUsuario; ?></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Menú
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Opción 1</a></li>
          <li><a class="dropdown-item" href="#">Opción 2</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
