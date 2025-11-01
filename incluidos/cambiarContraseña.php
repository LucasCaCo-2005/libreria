<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'conexion.php'; // tu archivo de conexión a la BD
    $id = $_SESSION['usuario']['id'];
    $actual = $_POST['password_actual'];
    $nueva = $_POST['password_nueva'];
    $confirmar = $_POST['password_confirmar'];

    // Verificar que coincidan
    if ($nueva !== $confirmar) {
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