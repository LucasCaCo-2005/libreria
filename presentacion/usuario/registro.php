<?php
// Procesa el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {

include_once __DIR__ . "/../../Logica/Admin/bd.php";
include_once __DIR__ . "/../../Logica/Admin/users.php";
include_once __DIR__ . "/../../Logica/Usuario/usersbd.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {

    // Captura todos los valores del formulario
    $cedula     = $_POST['cedula'] ?? '';
    $nombre     = $_POST['nombre'] ?? '';
    $apellidos  = $_POST['apellidos'] ?? '';
    $telefono   = $_POST['telefono'] ?? '';
    $correo     = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $estado     = $_POST['estado'] ?? 'pendiente'; // Valor por defecto
    $domicilio  = $_POST['domicilio'] ?? '';  

    //  Crear objeto y registrar
    $socio = new socios();
    $resultado = $socio->RegistrarSocio($cedula, $nombre, $apellidos, $domicilio, $telefono, $correo, $contrasena, $estado);

    if ($resultado) {
        echo "<script>alert('✅ Socio registrado correctamente');</script>";
        header("Location: login.php?registro=exitoso");
    } else {
        echo "<script>alert('❌ Error al registrar el socio');</script>";
    }
}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="./estilos/registro.css"> 
 
</head>
<body>
    <div class="form-container">
        <h1 class="titulo-formulario">Ingrese sus Datos</h1>
        <form action="" method="post">
            <div class="form-row">
                <label for="cedula">Cédula:</label>
                <input type="text" name="cedula" id="cedula">
            </div>
            <div class="form-row">
                <label for="Nombre">Nombre:</label>
                <input type="text" name="nombre">
            </div>
             <div class="form-row">
                <label for="Nombre">Apellidos:</label>
                <input type="text" name="apellidos">
            </div>
            <div class="form-row">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono">
            </div>
            <div class="form-row">
                <label for="telefono">Domicilio:</label>
                <input type="text" name="doicilio">
            </div>
            <div class="form-row">
                <label for="correo">Correo:</label>
                <input type="email" name="correo">
            </div>
            <div class="form-row">
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena">
            </div>
            <input type="hidden" name="estado" value="estado">
            <input type="submit" name="agregar" value="Agregar">
        </form>
    </div>
</body>

</html>
