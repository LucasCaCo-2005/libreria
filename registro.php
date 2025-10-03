<?php

// Procesa el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
   include_once __DIR__ . "/admin/seccion/persona.php";

    $persona = new Persona();
    $persona->setCi($_POST['ci']);
    $persona->setPrimerNombre($_POST['PrimerNombre']);
    $persona->setSegundoNombre($_POST['SegundoNombre']);
    $persona->setPrimerApellido($_POST['PrimerApellido']);
    $persona->setSegundoApellido($_POST['SegundoApellido']);
    $persona->setCalle($_POST['Calle']);
    $persona->setNumero($_POST['Numero']);
    $persona->setCorreo($_POST['correo']);
    $persona->setTelefonoFijo($_POST['TelefonoFijo']);
    $persona->setCelular($_POST['Celular']);
 $persona->setPass($_POST['Pass']);
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
   <form action="" method="post">
    <div class="form-row">
        <input type="text" name="ci" >
        <label for="ci">Cédula:</label>
    </div>
    
    <div class="form-row">
        <input type="text" name="PrimerNombre" >
        <label for="PrimerNombre">Nombre:</label>
    </div>
    
    <div class="form-row">
        <input type="text" name="SegundoNombre">
        <label for="SegundoNombre">Segundo Nombre:</label>
    </div>
    
    <div class="form-row">
        <input type="text" name="PrimerApellido" >
        <label for="PrimerApellido">Apellido:</label>
    </div>
    
    <div class="form-row">
        <input type="text" name="SegundoApellido">
        <label for="SegundoApellido">Segundo Apellido:</label>
    </div>
    
    <div class="form-row">
        <input type="text" name="Calle" >
        <label for="Calle">Calle:</label>
    </div>
    
    <div class="form-row">
        <input type="text" name="Numero" >
        <label for="Numero">Número:</label>
    </div>
    
    <div class="form-row">
        <input type="text" name="TelefonoFijo" >
        <label for="TelefonoFijo">Teléfono:</label>
    </div>
    
    <div class="form-row">
        <input type="text" name="Celular" >
        <label for="Celular">Celular:</label>
    </div>
    
    <div class="form-row">
        <input type="email" name="correo" >
        <label for="correo">Correo:</label>
    </div>
    
    <div class="form-row">
        <input type="password" name="Pass" >
        <label for="Pass">Contraseña:</label>
    </div>
    
<input type="hidden" name="tipo" value="usuario">

    
    <input type="submit" name="agregar" value="Agregar">
</form>


        
    </form>
</body>
</html>