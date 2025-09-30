

<?php
session_start();
$mensaje = "";


if ($_POST) {
    if (($_POST['usuario'] == "admen") && ($_POST['contraseña'] == "sistema123")) {
        $_SESSION['usuario'] = "ok";
        $_SESSION['nombre'] = "admen";
        header("Location: inicio.php");
        exit();
    } else {
        $mensaje = "Error: Usuario o contraseña incorrectos";
        $_SESSION['usuario'] = "no";
        $_SESSION['nombre'] = "";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    }
}
?>

<?php
session_start();

if ($_POST) {
    if (($_POST['usuario'] == "admen") && ($_POST['contraseña'] == "sistema123")) {
        $_SESSION['usuario'] = "ok";
        $_SESSION['nombre'] = "admen";
        header("Location: inicio.php");
        exit();
    } else {
        $mensaje = "Error: Usuario o contraseña incorrectos";
        $_SESSION['usuario'] = "no";
        $_SESSION['nombre'] = "";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    }
}
?>
