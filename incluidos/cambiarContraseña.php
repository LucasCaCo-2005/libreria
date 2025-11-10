<?php
session_start();
<<<<<<< HEAD
if (!isset($_SESSION['usuario'])) {
=======
if (!isset($_SESSION['usuario'])) { // usuario debe estar logueado
>>>>>>> 724c893d0c5e263a04d36fe6479dcd67a1653b7c
    header("Location: login.php");
    exit;
}

<<<<<<< HEAD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'conexion.php'; // tu archivo de conexión a la BD
    $id = $_SESSION['usuario']['id'];
=======
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // acepta unicamente envios por post
    require 'conexion.php'; D
    $id = $_SESSION['usuario']['id']; // obtiene datos
>>>>>>> 724c893d0c5e263a04d36fe6479dcd67a1653b7c
    $actual = $_POST['password_actual'];
    $nueva = $_POST['password_nueva'];
    $confirmar = $_POST['password_confirmar'];

<<<<<<< HEAD
    // Verificar que coincidan
    if ($nueva !== $confirmar) {
=======
    if ($nueva !== $confirmar) { // verifica que coincidan las contraseñas nuevas
>>>>>>> 724c893d0c5e263a04d36fe6479dcd67a1653b7c
        $error = "Las contraseñas nuevas no coinciden.";
    } else {
        // Verificar la contraseña actual
        $stmt = $conexion->prepare("SELECT password FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch();

        if (password_verify($actual, $usuario['password'])) {
            $nuevaHash = password_hash($nueva, PASSWORD_DEFAULT);
            $stmt = $conexion->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            $stmt->execute([$nuevaHash, $id]);
            $exito = "Contraseña actualizada correctamente.";
        } else {
            $error = "La contraseña actual es incorrecta.";
        }
    }
}
?>