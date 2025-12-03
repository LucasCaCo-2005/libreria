<?php

include_once 'cabecera.php';
// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once __DIR__ . '/../../persistencia/usuario/usersBD.php';
    
    // Obtener y limpiar datos
    $nombre = trim($_POST['nombre'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';
    
    $error = '';
    
    // Validaciones
    if (empty($nombre) || empty($telefono) || empty($correo) || empty($contrasena)) {
        $error = 'Todos los campos son obligatorios';
    } elseif ($contrasena !== $confirmar_contrasena) {
        $error = 'Las contraseñas no coinciden';
    } elseif (strlen($contrasena) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = 'El formato del correo electrónico no es válido';
    } elseif (!preg_match('/^[1-9]{2,3}\-[0-9]{3}\-[0-9]{3}$/', $telefono)) {
        $error = 'El formato del teléfono no es válido. Use: XX-XXX-XXX o XXX-XXX-XXX';
    }
    
    // Si no hay errores, intentar registro
    if (empty($error)) {
        try {
            $socioBD = new socioBD();
            
            if (!$socioBD->probarConexion()) {
                $error = 'Error de conexión a la base de datos';
            } elseif ($socioBD->correoExiste($correo)) {
                $error = 'El correo electrónico ya está registrado';
            } else {
                $resultado = $socioBD->registrarUsuarioCompleto($nombre, $telefono, $correo, $contrasena);
                
                if ($resultado) {
                    $success = true;
                } else {
                    $error = 'Error al registrar el usuario. Intente nuevamente.';
                }
            }
        } catch (Exception $e) {
            $error = 'Error del servidor. Intente más tarde.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Socio</title>
    <link rel="stylesheet" href="../../css/usuario/regi.css">
    <style>
       
    </style>
</head>
<body>

<br><br><br><br>
    <div class="container">
        <h1>Crear Cuenta</h1>
        <p class="subtitle">Únete a nuestra asociación</p>
        
        <?php if (isset($success) && $success): ?>
            <div class="message success">
                ¡Registro exitoso! Bienvenido a nuestra asociación.
            </div>
        <?php elseif (isset($error) && $error): ?>
            <div class="message error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre Completo*</label>
                    <input type="text" id="nombre" name="nombre" 
                           value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" 
                           required>
                </div>
                  
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono *</label>
                <input type="text" id="telefono" name="telefono" 
                       value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>" 
                       placeholder="09-123-456 o 099-123-456"
                       required>
                <div class="phone-format">Formato: XX-XXX-XXX o XXX-XXX-XXX</div>
            </div>
            
            <div class="form-group">
                <label for="correo">Correo Electrónico *</label>
                <input type="email" id="correo" name="correo" 
                       value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="contrasena">Contraseña *</label>
                <input type="password" id="contrasena" name="contrasena" 
                       minlength="6" 
                       required>
                <div class="password-requirements">Mínimo 6 caracteres</div>
            </div>
            
            <div class="form-group">
                <label for="confirmar_contrasena">Confirmar Contraseña *</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" 
                       minlength="6" 
                       required>
            </div>
            
            <button type="submit" class="btn">Registrarse</button>
        </form>
        
        <div class="login-link">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
        </div>
    </div>

    <script>
        // Validación en tiempo real de contraseñas
        document.addEventListener('DOMContentLoaded', function() {
            const contrasena = document.getElementById('contrasena');
            const confirmar = document.getElementById('confirmar_contrasena');
            const telefono = document.getElementById('telefono');
            
            function validarContrasenas() {
                if (contrasena.value !== confirmar.value) {
                    confirmar.style.borderColor = '#dc3545';
                } else {
                    confirmar.style.borderColor = '#28a745';
                }
            }
            
            // Formato automático para teléfono
            telefono.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length <= 2) {
                    e.target.value = value;
                } else if (value.length <= 5) {
                    e.target.value = value.substring(0, 2) + '-' + value.substring(2);
                } else {
                    e.target.value = value.substring(0, 2) + '-' + value.substring(2, 5) + '-' + value.substring(5, 8);
                }
            });
            
            contrasena.addEventListener('input', validarContrasenas);
            confirmar.addEventListener('input', validarContrasenas);
        });
    </script>
</body>
</html>