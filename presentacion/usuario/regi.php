<?php

include_once 'cabecera.php';
// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once __DIR__ . '/../../persistencia/usuario/usersBD.php';
    
    // Obtener y limpiar datos
    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';
    
    $error = '';
    
    // Validaciones
    if (empty($nombre) || empty($apellidos) || empty($telefono) || empty($correo) || empty($contrasena)) {
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
                $resultado = $socioBD->registrarUsuarioCompleto($nombre, $apellidos, $telefono, $correo, $contrasena);
                
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
    <style>
        * {
           
            padding: 1px;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
      
            min-height: 100vh;
           
      
        }

        .container {
          
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(168, 168, 168, 0.1);
            width: 100%;
         
            
        
        }
        overflow: hidden;
          background: white;
          
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

        input:valid {
            border-color: #28a745;
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

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .password-requirements, .phone-format {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
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
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" 
                           value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="apellidos">Apellidos *</label>
                    <input type="text" id="apellidos" name="apellidos" 
                           value="<?php echo isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : ''; ?>" 
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