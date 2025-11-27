<?php
include_once 'cabecera.php';

include_once '../../logica/admin/bd.php';

include_once '../../logica/admin/cambiarContraseña.php';
// Incluir archivos necesarios - rutas desde presentacion/usuario/
// Recuperar mensajes de sesión
// Recuperar mensajes de sesión
$exito_personal = $_SESSION['mensaje_exito'] ?? '';
$error_personal = $_SESSION['mensaje_error'] ?? '';
$exito_password = $_SESSION['exito_password'] ?? '';
$error_password = $_SESSION['error_password'] ?? '';

// Limpiar mensajes de sesión después de mostrarlos
unset($_SESSION['mensaje_exito']);
unset($_SESSION['mensaje_error']);
unset($_SESSION['exito_password']);
unset($_SESSION['error_password']);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <style>
        /* Tus estilos CSS aquí (igual que antes) */
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: white;
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            margin-right: 15px;
        }
        
        .user-details h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .user-details p {
            color: #7f8c8d;
        }
        
        .logout-btn {
            background-color: var(--light-color);
            color: var(--dark-color);
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .logout-btn:hover {
            background-color: #dfe6e9;
        }
        
        .profile-sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        @media (max-width: 768px) {
            .profile-sections {
                grid-template-columns: 1fr;
            }
        }
        
        .section {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 25px;
        }
        
        .section h2 {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: var(--dark-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: rgba(46, 204, 113, 0.2);
            color: #27ae60;
            border: 1px solid #2ecc71;
        }
        
        .alert-danger {
            background-color: rgba(231, 76, 60, 0.2);
            color: #c0392b;
            border: 1px solid #e74c3c;
        }
        
        .password-toggle {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #7f8c8d;
            cursor: pointer;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        @media (max-width: 480px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
     <br><br><br>
    <div class="container">
        <header>
            <div class="user-info">
                <div class="avatar">
                    <?php 
                        $nombre = $_SESSION['usuario']['nombre'] ?? 'Usuario';
                        $iniciales = strtoupper(substr($nombre, 0, 2));
                        echo $iniciales;
                    ?>
                </div>
                <div class="user-details">
                    <h1><?php echo htmlspecialchars($nombre); ?></h1>
                    <p>Miembro desde <?php echo date('Y'); ?></p>
                </div>
            </div>
            <button class="logout-btn" onclick="window.location.href='logout.php'">Cerrar Sesión</button>
        </header>
        
        <div class="profile-sections">
            <div class="section">
                <h2>Información Personal</h2>
                
                <?php if (!empty($exito_personal)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($exito_personal); ?></div>
                <?php endif; ?>
                
                <?php if (!empty($error_personal)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_personal); ?></div>
                <?php endif; ?>
                
                <form id="personalInfoForm" method="POST" action="../../logica/usuario/actperfil.php">
                    <div class="form-group">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($_SESSION['usuario']['nombre'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="correo">Correo electrónico</label>
                        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($_SESSION['usuario']['correo'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($_SESSION['usuario']['telefono'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="domicilio">Domicilio</label>
                        <input type="text" id="domicilio" name="domicilio" value="<?php echo htmlspecialchars($_SESSION['usuario']['domicilio'] ?? ''); ?>">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
            
            <div class="section">
                <h2>Cambiar Contraseña</h2>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if (isset($exito)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($exito); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="password_actual">Contraseña actual</label>
                        <div class="password-toggle">
                            <input type="password" id="password_actual" name="password_actual" required>
                            <button type="button" class="toggle-password" data-target="password_actual">👁️</button>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password_nueva">Nueva contraseña</label>
                            <div class="password-toggle">
                                <input type="password" id="password_nueva" name="password_nueva" required>
                                <button type="button" class="toggle-password" data-target="password_nueva">👁️</button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmar">Confirmar nueva contraseña</label>
                            <div class="password-toggle">
                                <input type="password" id="password_confirmar" name="password_confirmar" required>
                                <button type="button" class="toggle-password" data-target="password_confirmar">👁️</button>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Funcionalidad para mostrar/ocultar contraseñas
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.textContent = '🙈';
                } else {
                    passwordInput.type = 'password';
                    this.textContent = '👁️';
                }
            });
        });
        
        // Validación de formulario de contraseña
   // Solo para el formulario de contraseña
document.querySelector('form[action*="cambiar_password"]').addEventListener('submit', function(e) {
    const nueva = document.getElementById('password_nueva').value;
    const confirmar = document.getElementById('password_confirmar').value;
    
    if (nueva !== confirmar) {
        e.preventDefault();
        alert('Las contraseñas nuevas no coinciden. Por favor, verifica.');
        return false;
    }
    
    if (nueva.length < 6) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 6 caracteres.');
        return false;
    }
});
        
        // Validación de formulario de información personal
        document.getElementById('personalInfoForm').addEventListener('submit', function(e) {
            const correo = document.getElementById('correo').value;
            const telefono = document.getElementById('telefono').value;
            
            // Validación básica de correo
            if (!correo.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                e.preventDefault();
                alert('Por favor, introduce un correo electrónico válido.');
                return false;
            }
            
            // Validación básica de teléfono (si se proporciona)
            if (telefono && !telefono.match(/^[\d\s\-\+\(\)]{7,}$/)) {
                e.preventDefault();
                alert('Por favor, introduce un número de teléfono válido.');
                return false;
            }
        });
    </script>
</body>
</html>