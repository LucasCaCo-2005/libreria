<?php session_start(); ?>
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
                <input type="text" name="ci" id="ci" required>
            </div>
            <div class="form-row">
                <label for="Pass">Contraseña:</label>
                <input type="password" name="Pass" id="Pass" required>
            </div>
            <input type="submit" name="login" value="Iniciar sesión">
        </form>
        <button class="btn-registrarse" onclick="window.location.href='registro.php'">
            Registrarse
        </button>
    </div>
</body>
</html>

<?php
include_once  "./admin/seccion/bd.php";
include_once __DIR__ . "/admin/seccion/persona.php";

if (isset($_POST['login'])) {
    $persona = new Persona();
    $resultado = $persona->login($_POST['ci'], $_POST['Pass']);
   // $persona->setCedula($_POST['ci']);
//    $persona->setContrasena($_POST['Pass']);

    if ($resultado) {
        $_SESSION['persona'] = $resultado;
        if ($_SESSION['persona']['Tipo'] == "admin") {
            header("Location: panelAdmin.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        echo "<script>alert('Usuario o contraseña incorrecta');</script>";
    }
}

/*

    $persona = $persona->Login();
    $_SESSION['persona'] = $persona;

    if ($_SESSION['persona'] != NULL) {
        if ($_SESSION['persona']->getTipo() == "admin") {
            header("Location: panelAdmin.php");
            exit;
        } else {
            header("Location: index.php");
            exit;
        }
    } else {
        echo "<script>alert('Usuario o contraseña incorrecta');</script>";
    }
}
    */
?>
