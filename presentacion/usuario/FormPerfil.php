<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica que el usuario esté logueado
if (!isset($_SESSION['socios'])) {
    header("Location: /../index.php");  // Redirige al login si no hay datos de sesión
    exit;
}

// Incluye la conexión a la base de datos
include_once '../../logica/admin/bd.php'; 

// Recupera el id del socio logueado desde la sesión
$id = $_SESSION['socios']['id'];

// Obtener los datos del socio logueado
$stmt = $conexion->prepare("SELECT nombre, apellidos, correo, domicilio, telefono, contrasena FROM socios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Variables para el mensaje
$mensaje = '';
$error = '';

// Procesar la actualización de datos personales
if (isset($_POST['actualizar_datos'])) {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];

    // Validar que los campos no estén vacíos
    if (!empty($nombre) && !empty($apellidos) && !empty($correo) && !empty($domicilio) && !empty($telefono)) {
        try {
            // Actualizar los datos en la base de datos
            $sql = "UPDATE socios SET nombre = ?, apellidos = ?, correo = ?, domicilio = ?, telefono = ? WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$nombre, $apellidos, $correo, $domicilio, $telefono, $id]);

            // Verificar si se actualizaron los datos correctamente
            if ($stmt->rowCount() > 0) {
                $mensaje = "Datos actualizados correctamente";
                
                // Actualizar los datos en la variable $usuario para mostrarlos inmediatamente
                $usuario['nombre'] = $nombre;
                $usuario['apellidos'] = $apellidos;
                $usuario['correo'] = $correo;
                $usuario['domicilio'] = $domicilio;
                $usuario['telefono'] = $telefono;
                
                // Opcional: Actualizar también en la sesión si es necesario
                $_SESSION['socios']['nombre'] = $nombre;
                $_SESSION['socios']['apellidos'] = $apellidos;
            } else {
                $error = "No se realizaron cambios o hubo un problema al actualizar los datos.";
            }
        } catch (PDOException $e) {
            $error = "Error al actualizar los datos: " . $e->getMessage();
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}

// Procesar el cambio de contraseña
if (isset($_POST['cambiar_password'])) {
    $password_actual = $_POST['password_actual'];
    $password_nueva = $_POST['password_nueva'];
    $password_confirmar = $_POST['password_confirmar'];

    // Verificar si la contraseña actual es correcta
    if (password_verify($password_actual, $usuario['contrasena'])) {
        // Verificar si las contraseñas nuevas coinciden
        if ($password_nueva === $password_confirmar) {
            // Validar que la nueva contraseña tenga al menos 6 caracteres
            if (strlen($password_nueva) >= 6) {
                // Hashear la nueva contraseña
                $password_nueva_hash = password_hash($password_nueva, PASSWORD_DEFAULT);

                // Actualizar la contraseña en la base de datos
                $sql = "UPDATE socios SET contrasena = ? WHERE id = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([$password_nueva_hash, $id]);

                // Verificar si se actualizó la contraseña correctamente
                if ($stmt->rowCount() > 0) {
                    $mensaje = "Contraseña actualizada correctamente";
                } else {
                    $error = "Hubo un problema al actualizar la contraseña. Intenta de nuevo.";
                }
            } else {
                $error = "La nueva contraseña debe tener al menos 6 caracteres.";
            }
        } else {
            $error = "Las contraseñas nuevas no coinciden.";
        }
    } else {
        $error = "La contraseña actual es incorrecta.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">👤 Mi Perfil</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Formulario de datos personales -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Datos Personales</div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" 
                           value="<?= isset($usuario['nombre']) ? htmlspecialchars($usuario['nombre']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" 
                           value="<?= isset($usuario['apellidos']) ? htmlspecialchars($usuario['apellidos']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" 
                           value="<?= isset($usuario['correo']) ? htmlspecialchars($usuario['correo']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label for="domicilio" class="form-label">Domicilio</label>
                    <input type="text" class="form-control" id="domicilio" name="domicilio" 
                           value="<?= isset($usuario['domicilio']) ? htmlspecialchars($usuario['domicilio']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" 
                           value="<?= isset($usuario['telefono']) ? htmlspecialchars($usuario['telefono']) : '' ?>" required>
                </div>

                <button type="submit" name="actualizar_datos" class="btn btn-success">Guardar cambios</button>
            </form>
        </div>
    </div>

    <!-- Formulario de cambio de contraseña -->
    <div class="card">
        <div class="card-header bg-warning">Cambiar Contraseña</div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="password_actual" class="form-label">Contraseña actual</label>
                    <input type="password" class="form-control" id="password_actual" name="password_actual" required>
                </div>

                <div class="mb-3">
                    <label for="password_nueva" class="form-label">Nueva contraseña</label>
                    <input type="password" class="form-control" id="password_nueva" name="password_nueva" required minlength="6">
                    <div class="form-text">La contraseña debe tener al menos 6 caracteres.</div>
                </div>

                <div class="mb-3">
                    <label for="password_confirmar" class="form-label">Confirmar nueva contraseña</label>
                    <input type="password" class="form-control" id="password_confirmar" name="password_confirmar" required minlength="6">
                </div>

                <button type="submit" name="cambiar_password" class="btn btn-primary">Actualizar contraseña</button>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <a href="/sitioweb/index.php" class="btn btn-secondary">⬅ Volver al inicio</a>
    </div>
</div>

</body>
</html>