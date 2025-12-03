<?php
// Incluye las clases necesarias
include_once __DIR__ . "./Logica/Admin/bd.php";
include_once "usersBD.php"; // Asegúrate de que esta ruta esté correcta
//session_start();  // Asegúrate de que la sesión esté iniciada


// Obtener los datos del socio logueado desde la sesión
$id = $_SESSION['socios']['id'];

// Crear una instancia de la clase socioBD
$socioBD = new socioBD();

// Obtener los datos actuales del usuario
$stmt = $conexion->prepare("SELECT nombre, correo, domicilio, telefono FROM socios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Mensajes de éxito o error
$mensaje = "";
$error = "";

// Si se ha enviado el formulario para actualizar los datos
if (isset($_POST['actualizar_datos'])) {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $domicilio = trim($_POST['domicilio']);
    $telefono = trim($_POST['telefono']);

    // Llamar al método ActualizarSocio
    $resultado = $socioBD->ActualizarSocio($id, $nombre, $domicilio, $telefono, $correo);

    // Mostrar mensaje o error
    if (strpos($resultado, "correctamente") !== false) {
        $mensaje = $resultado;
    } else {
        $error = $resultado;
    }
}

?>

