<?php
session_start();
if (!isset($_SESSION['usuario'])) { // usuario debe estar logueado
    header("Location: login.php");
    exit;
}
// Incluir archivos necesarios - rutas desde logica/usuario/
include_once __DIR__ . '/../../logica/admin/bd.php';

$id = $_SESSION['usuario']['id'];
$exito = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y sanitizar los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $domicilio = trim($_POST['domicilio'] ?? '');
    
    // Validaciones básicas
    if (empty($nombre) || empty($correo)) {
        $error = "El nombre y el correo electrónico son obligatorios.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "El formato del correo electrónico no es válido.";
    } else {
        try {
            // Verificar si el correo ya existe en otro usuario
            $stmt = $conexion->prepare("SELECT id FROM socios WHERE correo = ? AND id != ?");
            $stmt->execute([$correo, $id]);
            $usuario_existente = $stmt->fetch();
            
            if ($usuario_existente) {
                $error = "El correo electrónico ya está en uso por otro usuario.";
            } else {
                // Actualizar los datos del usuario
                $stmt = $conexion->prepare("UPDATE socios SET nombre = ?, correo = ?, telefono = ?, domicilio = ? WHERE id = ?");
                $stmt->execute([$nombre, $correo, $telefono, $domicilio, $id]);
                
                // Actualizar los datos en la sesión
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['correo'] = $correo;
                $_SESSION['usuario']['telefono'] = $telefono;
                $_SESSION['usuario']['domicilio'] = $domicilio;
                
                $exito = "Perfil actualizado correctamente.";
            }
        } catch (PDOException $e) {
            $error = "Error al actualizar el perfil: " . $e->getMessage();
        }
    }
    
    // Redirigir de vuelta al perfil con mensajes
    $_SESSION['mensaje_exito'] = $exito;
    $_SESSION['mensaje_error'] = $error;
    header("Location: ../../presentacion/usuario/perfil.php");
    exit;
} else {
    // Si no es POST, redirigir al perfil
    header("Location: ../../presentacion/usuario/perfil.php");
    exit;
}
?>