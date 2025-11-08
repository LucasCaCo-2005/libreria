<?php
session_start();
if (!isset($_SESSION['usuario'])) { // usuario debe estar logueado
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // acepta unicamente envios por post
    require 'conexion.php'; D
    $id = $_SESSION['usuario']['id']; // obtiene datos
    $actual = $_POST['password_actual'];
    $nueva = $_POST['password_nueva'];
    $confirmar = $_POST['password_confirmar'];

    if ($nueva !== $confirmar) { // verifica que coincidan las contraseñas nuevas
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