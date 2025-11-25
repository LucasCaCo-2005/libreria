<?php
// Activar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir la clase de base de datos
include_once "usersBD.php";

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registro.php?error=Método no permitido');
    exit;
}

// Obtener y limpiar datos
$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';
$confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';
$estado = 'activo';

// Validaciones básicas
if (empty($nombre) || empty($apellidos) || empty($telefono) || empty($correo) || empty($contrasena)) {
    header('Location: registro.php?error=Todos los campos son obligatorios');
    exit;
}

// Validar que las contraseñas coincidan
if ($contrasena !== $confirmar_contrasena) {
    header('Location: registro.php?error=Las contraseñas no coinciden');
    exit;
}

// Validar longitud de contraseña
if (strlen($contrasena) < 6) {
    header('Location: registro.php?error=La contraseña debe tener al menos 6 caracteres');
    exit;
}

// Validar email
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header('Location: registro.php?error=El formato del correo electrónico no es válido');
    exit;
}

try {
    // Crear instancia
    $socioBD = new socioBD();
    
    // Generar una cédula temporal
    $cedula = time() . rand(100, 999);
    
    // Intentar registro
    $resultado = $socioBD->RegistrarSocio(
        $cedula, 
        $nombre, 
        $apellidos, 
        'Por definir', // domicilio
        $telefono, 
        $correo, 
        $contrasena, 
        $estado
    );
    
    if ($resultado) {
        // Registro exitoso - redirigir a página de éxito
        header('Location: registro.php?success=1');
        exit;
    } else {
        header('Location: registro.php?error=Error al registrar el usuario. Puede que el correo ya esté en uso.');
        exit;
    }
    
} catch (Exception $e) {
    // Error del servidor
    error_log("Error en registro: " . $e->getMessage());
    header('Location: registro.php?error=Error del servidor. Intente más tarde.');
    exit;
}