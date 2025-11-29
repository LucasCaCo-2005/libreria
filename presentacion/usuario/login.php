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
            'apellidos' => $resultado['apellidos'],
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
            header("Location: dashboard.php");
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

     

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
            font-weight: 600;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        input:focus {
            border-color: #667eea;
            background: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }

        .btn-secondary:hover {
            box-shadow: 0 10px 20px rgba(108, 117, 125, 0.3);
        }

        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .password-helper {
            text-align: right;
            margin-top: 5px;
        }

        .password-helper a {
            color: #667eea;
            text-decoration: none;
            font-size: 12px;
        }

        .password-helper a:hover {
            text-decoration: underline;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-icon {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 10px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
            }
        }
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