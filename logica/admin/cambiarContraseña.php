<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password_actual'])) {
    $id = $_SESSION['usuario']['id'];
    $actual = $_POST['password_actual'];
    $nueva = $_POST['password_nueva'];
    $confirmar = $_POST['password_confirmar'];

    if ($nueva !== $confirmar) {
        $error = "Las contraseñas nuevas no coinciden.";
    } else {
        try {
            // Verificar la contraseña actual
            $stmt = $conexion->prepare("SELECT contrasena FROM socios WHERE id = ?");
            $stmt->execute([$id]);
            $usuario = $stmt->fetch();

            if ($usuario && password_verify($actual, $usuario['contrasena'])) {
                $nuevaHash = password_hash($nueva, PASSWORD_DEFAULT);
                $stmt = $conexion->prepare("UPDATE socios SET contrasena = ? WHERE id = ?");
                $stmt->execute([$nuevaHash, $id]);
                $exito = "Contraseña actualizada correctamente.";
            } else {
                $error = "La contraseña actual es incorrecta.";
            }
        } catch (PDOException $e) {
            $error = "Error al cambiar la contraseña: " . $e->getMessage();
        }
    }
}
?>