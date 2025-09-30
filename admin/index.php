<?php
session_start();
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Administrador- Oscar</title>
</head>
<body>
<?php if($mensaje): ?>
    <p style="color:red;"><?php echo $mensaje; ?></p>
<?php endif; ?>
<form action="login.php" method="post">
    <label for="usuario">Usuario:</label>
    <input type="text" name="usuario" required>
    <br>
    <label for="contraseña">Contraseña:</label>
    <input type="password" name="contraseña" required>
    <br>
    <button type="submit">Ingresar</button>
</form>
</body>
</html>
