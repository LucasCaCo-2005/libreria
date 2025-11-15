<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    } // inicio de sesion de forma que se evitan varias sesiones
include_once "./admin/seccion/bd.php";
include_once __DIR__ . "/admin/seccion/users.php";


if (isset($_POST['login'])) {
    $socio = new socios();
    $resultado = $socio->login($_POST['cedula'], $_POST['contrasena']);

    if ($resultado) {
        $_SESSION['socios'] = $resultado; // aqui se almacenan los datos

        
        echo "<script>
            window.parent.postMessage('loginExitoso', '*');
        </script>";
        exit;
    } else {
        echo "<script>alert('Usuario o contraseña incorrecta');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/Usuario/login.css">
</head>


    <!-- Botón de login o menú de usuario -->
    <?php if (isset($_SESSION['usuario'])): ?>
        <div class="dropdown me-3">
            <button class="btn btn-success dropdown-toggle" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                👤 <?= htmlspecialchars($_SESSION['usuario']) ?>

            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton">
                <li><a class="dropdown-item" href="perfil.php">Mi perfil</a></li>
                <li><a class="dropdown-item" href="ayuda.php">Ayuda</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="logout.php">Cerrar sesión</a></li>
            </ul>
        </div>
        <?php endif; ?>

</header>



<body>
    <div class="form-container">
        <h1 class="titulo-formulario">Iniciar Sesión</h1>
        <form class="login-form" action="" method="post">
            <div class="form-row">
                <label for="ci">Usuario:</label>
                <input type="text" name="cedula" id="cedula" required>
            </div>
            <div class="form-row">
                <label for="Pass">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" required>
            </div>
            <input type="submit" name="login" value="Iniciar sesión">
        </form>
        <button class="btn-registrarse" onclick="window.location.href='registro.php'">
            Registrarse
        </button>
    </div>
</body>
</html>
