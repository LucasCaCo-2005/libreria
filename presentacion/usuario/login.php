<?php
// En tu archivo que procesa el login
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../persistencia/usuario/loginBD.php';

if ($_POST) {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    
    $loginBD = new loginBD();
    $resultado = $loginBD->verificarCredenciales($correo, $contrasena);
    
    if ($resultado && is_array($resultado)) {
        // Login exitoso - guardar TODOS los datos en sesión incluyendo el estado
        $_SESSION['usuario'] = [
            'id' => $resultado['id'],
            'nombre' => $resultado['nombre'],
            'correo' => $resultado['correo'],
            'estado' => $resultado['estado'], // ¡IMPORTANTE! Incluir el estado
            'telefono' => $resultado['telefono'],
            'domicilio' => $resultado['domicilio'],
            'socio' => $resultado['socio'],
            'cedula' => $resultado['cedula']
        ];
        
        error_log("✅ Sesión iniciada - Estado: " . $_SESSION['usuario']['estado']);
        
        // Redirigir según el estado del usuario
        if ($_SESSION['usuario']['estado'] === 'admin') {
            header("Location: ../Admin/index.php");
        } else {
            header("Location: Perfil.php");
        }
        exit();
        
    } else if ($resultado === 'estado_no_permitido') {
        $error = "Tu cuenta no está activa. Contacta al administrador.";
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
include_once 'cabecera.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
        <link rel="stylesheet" href="../../css/Usuario/login.css">
    <style>
      
    </style>
</head>
<body>


    <div class="container">
        <div class="logo">
            <div class="logo-icon">👤</div>
        </div>
        
        <h1>Bienvenido</h1>
        <p class="subtitle">Inicia sesión en tu cuenta</p>
        
        <?php if (isset($success) && $success): ?>
            <div class="message success">
                ¡Inicio de sesión exitoso! Redirigiendo...
            </div>
        <?php elseif (isset($error) && $error): ?>
            <div class="message error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="correo">Correo Electrónico *</label>
                <input type="email" id="correo" name="correo" 
                       value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>" 
                       placeholder="tu@email.com"
                       required>
            </div>
            
            <div class="form-group">
                <label for="contrasena">Contraseña *</label>
                <input type="password" id="contrasena" name="contrasena" 
                       placeholder="••••••••"
                       required>
                <div class="password-helper">
                    <a href="recuperar.php">¿Olvidaste tu contraseña?</a>
                </div>
            </div>
            
            <button type="submit" class="btn">Iniciar Sesión</button>
        </form>
        
        <div class="register-link">
            ¿No tienes cuenta? <a href="regi.php">Regístrate aquí</a>
        </div>
    </div>

    <script>
        // Efecto de focus en los campos
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            
            inputs.forEach(input => {
                // Guardar el valor original del placeholder
                const originalPlaceholder = input.placeholder;
                
                input.addEventListener('focus', function() {
                    this.placeholder = '';
                });
                
                input.addEventListener('blur', function() {
                    if (this.value === '') {
                        this.placeholder = originalPlaceholder;
                    }
                });
            });
        });
    </script>
</body>
</html>