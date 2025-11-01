<?php
session_start();
include_once "./admin/seccion/bd.php";
include_once __DIR__ . "/admin/seccion/users.php";


if (isset($_POST['login'])) {
    $socio = new socios();
    $resultado = $socio->login($_POST['cedula'], $_POST['contrasena']);

    if ($resultado) {
        $_SESSION['socios'] = $resultado;

        // Si se abre dentro del modal (iframe)
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
    <link rel="stylesheet" href="./estilos/login.css">
</head>
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
