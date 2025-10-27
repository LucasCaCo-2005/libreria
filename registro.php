<?php
// Procesa el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
   include_once __DIR__ . "/admin/seccion/persona.php";

    $persona = new Persona();
    $persona->setCedula($_POST['cedula']);
    $persona->setNombre($_POST['nombre']);

    $persona->setapellidos($_POST['apellidos']);
 
  $persona->setDireccion($_POST['domicilio']);
   

   $persona->setTelefono($_POST['telefono']);
    
   $persona->setCorreo($_POST['correo']);
    
  $persona->setContrasena($_POST['contrasena']);
 $persona->setTipo($_POST['tipo']);
    // Hashear la contraseña antes de guardarla
  //  $hashedPass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
 //   $usuario->setPass($hashedPass);
    $persona->CargarPersonas();
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
                <label for="Apellidos">Apellidos:</label>
                <input type="text" name="apellidos">
            </div>
            <div class="form-row">
                <label for="domicilio">Calle:</label>
                <input type="text" name="domicilio">
            </div>
            <div class="form-row">
                <label for="telefono">Teléfono:</label>
                <input type="tel" name="telefono">
            </div>
            <div class="form-row">
                <label for="correo">Correo:</label>
                <input type="email" name="correo">
            </div>
            <div class="form-row">
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena">
            </div>
            <input type="hidden" name="tipo" value="usuario">
            <input type="submit" name="agregar" value="Agregar">
        </form>
    </div>
</body>

</html>