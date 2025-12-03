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
         <link rel="stylesheet" href="../../css/usuario/perfil.css"> 
    <title>Mi Perfil</title>
    <style>
        
       
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