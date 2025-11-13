<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
/*  Estilos específicos para el login banner */
.login-banner {
  position: relative;
  display: flex;
  align-items: center;
}

/* Botón de "Iniciar sesión" */
.login-button {
  background-color: transparent;
  color: #fff;
  border: 2px solid transparent;
  padding: 8px 18px;
  border-radius: 6px;
  font-weight: 500;
  transition: all 0.3s ease;
}

.login-button:hover {
  background-color: #28a745; /* verde al pasar el mouse */
  color: #fff;
}

/* 🔹 Menú del usuario (desplegable) */
.user-menu {
  position: relative;
}

.user-button {
  background-color: transparent;
  color: #fff;
  border: none;
  font-weight: 500;
  padding: 8px 18px;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.user-button:hover {
  background-color: #28a745; /* verde al pasar el mouse */
}

/* Contenedor del dropdown */
.user-dropdown {
  display: none;
  position: absolute;
  top: 100%;
  right: 0;
  background-color: #fff;
  border-radius: 6px;
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
  min-width: 180px;
  z-index: 1000;
}

/* Mostrar el dropdown al tener clase "show" */
.user-dropdown.show {
  display: block;
}

.user-dropdown a {
  display: block;
  padding: 10px 15px;
  color: #333;
  text-decoration: none;
  transition: background 0.3s ease;
}

.user-dropdown a:hover {
  background-color: #f0f0f0;
}

.user-dropdown hr {
  margin: 5px 0;
  border-color: #ddd;
}
</style>

<div class="login-banner">
<?php if (isset($_SESSION['socios'])): ?>
  <div class="user-menu">
    <button class="user-button" id="userButton">
      👤 <?= htmlspecialchars($_SESSION['socios']['nombre'] ?? '') ?>
    </button>
    <div class="user-dropdown" id="userDropdown">
   <a href='/sitioweb/Presentacion/Usuario/Perfil.php'>Mi Perfil</a>
   
     
      <a href="ayuda.php"><i class="fas fa-question-circle"></i> Ayuda</a>
      <hr>
      <form action="logout.php" method="POST" style="margin:0;">
        <button type="submit" name="logout" class="dropdown-item" style="width:100%;text-align:left;border:none;background:none;padding:10px 15px;color:#333;">
          <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </button>
      </form>
    </div>
  </div>
<?php else: ?>
  <button class="login-button" id="loginButton" onclick="openLoginModal()">Iniciar sesión</button>
<?php endif; ?>
</div>

<script>
// Mostrar/ocultar el menú del usuario
document.addEventListener('DOMContentLoaded', function() {
  const userButton = document.getElementById('userButton');
  const userDropdown = document.getElementById('userDropdown');

  if (userButton) {
    userButton.addEventListener('click', function(e) {
      e.stopPropagation();
      userDropdown.classList.toggle('show');
    });
  }

  // Cerrar el menú si se hace clic fuera
  document.addEventListener('click', function(e) {
    if (userDropdown && !userDropdown.contains(e.target) && e.target !== userButton) {
      userDropdown.classList.remove('show');
    }
  });
});
</script>
