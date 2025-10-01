<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            background-color: #0057a0;
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label, input {
            margin: 10px 0;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            border: none;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #003d70;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #002f5c;
        }
    </style>
</head>
<body>
    <form action="login.php" method="post">
        <label for="ci">Usuario</label>
        <input type="text" name="ci" id="ci" required>

        <label for="Pass">Contraseña</label>
        <input type="password" name="Pass" id="Pass" required>

        <input type="submit" name="login" value="Iniciar sesión">
       
    </form>
    <button 
    onclick="window.location.href='registro.php'" 
    style="margin-top: 15px; font-size: 1.6em; padding: 15px 25px; background-color: #0074d9; color: white; border: none; border-radius: 6px; cursor: pointer; width: 100%;">
    Registrarse
</button>
</body>
</html>

<?php


// include_once "../datos/conexion.php";
//include_once "../logica/persona.php";
//include_once "../datos/personasBd.php"; 

include_once __DIR__ . "/logica/conexion.php";
include_once __DIR__ . "/logica/persona.php";

if (isset($_POST['login'])) {
    $persona = new Persona();
    $persona->setCi($_POST['ci']);
    $persona->setPass($_POST['Pass']);
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

if (isset($_POST['Registrarse'])) {
    header("Location: registro.php");
    exit;
}
?>
