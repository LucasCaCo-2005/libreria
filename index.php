<?php
session_start();

<<<<<<< HEAD

include_once __DIR__ . "/admin/seccion/users.php";
=======
>>>>>>> 2ad180697827f417a48a26d45496592ac8eebdf8
include_once __DIR__ . '/admin/seccion/bd.php';
include_once __DIR__ . '/admin/seccion/Talleres.php';
include_once ("admin/seccion/bd.php");

$talleresBD = new TalleresBD();
$listaTalleres = $talleresBD->ListarTalleres();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Página con Banner</title>
  <link rel="stylesheet" href="./estilos/Index.css"> 

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    justify-content: center;
    align-items: center;
    overflow: hidden; /*elimina la barra de desplazamiento*/
}

.modal-content {
    background-color: #0057a0;
    padding: 60px 80px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
    color: white;
    font-family: Arial, sans-serif;
    width: 100%;
    max-width: 800px;
    position: relative;
    overflow: hidden;
}

.modal-content .close {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 28px;
    font-weight: bold;
    color: white;
    cursor: pointer;
}

.login-form input[type="text"],
.login-form input[type="password"],
.login-form input[type="submit"] {
    display: block;
    width: 100%;
    margin: 12px 0;
    padding: 10px;
    font-size: 20px;
    border: none;
    border-radius: 5px;
}

.login-form input[type="submit"] {
    background-color: #003d70;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 2.5em; /* tamaño aumentado */
    padding: 10px 0;    /* espacio interno aumentado */
    border: none;
    border-radius: 5px;
    margin-top: 10px;

}

.login-form input[type="submit"]:hover {
    background-color: #002f5c;
   
   .login-banner-button {
    background-color: #0057a0; /* Fondo azul */
    color: white; /* Texto blanco */
    padding: 12px 20px; /* Espaciado alrededor del texto */
    border: none; /* Sin borde */
    border-radius: 8px; /* Bordes redondeados */
    font-size: 18px; /* Tamaño de la fuente */
    cursor: pointer; /* Apunta con el cursor */
    transition: background-color 0.3s, transform 0.3s; /* Transiciones suaves */
    display: inline-block; /* Para no romper el flujo del layout */
}

}
</style>


</head>
<body>





    <!-- HEADER -->
    <header>
        <div class="header-content">
            <div class="flag">
                <img src="./images/bandera.png" alt="Bandera">
            </div>
            <div class="logo-header">
                <img src="./images/Logo.png" alt="Logo">
                
            </div>
          
   <!-- Incluyo el archivo que contiene el usuario logueado y el boton cerrar cesión -->
<?php include_once './incluidos/loginBanner.php'; ?>
       
    </div>
        <div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeLoginModal()">&times;</span>
    
    <h2 style="text-align:center; margin-top: 0;">Ingrese sus Datos</h2> <!-- TÍTULO del Formulario -->


    <!-- Aquí se carga login.php -->
  <iframe id="loginIframe" src="login.php" frameborder="0" 
    style="width: 100%; height: 300px; border-radius: 10px; overflow: hidden;">
</iframe>
  </div>
</div>
    </header>

        <!-- LISTADO DE TALLERES -->
    <div class="grid-container">
        <?php if ($listaTalleres && is_array($listaTalleres)): ?>
            <?php foreach ($listaTalleres as $taller): ?>
                <div class="card">
                    <img src="./images/<?= htmlspecialchars($taller->getFoto()) ?>" alt="Foto de <?= htmlspecialchars($taller->getNombre()) ?>">
                    <div class="card-content">
                        <h3><?= htmlspecialchars($taller->getNombre()) ?></h3>
                        <p>Día: <?= htmlspecialchars($taller->getDia()) ?></p>
                        <p>Horario: <?= htmlspecialchars($taller->getHorario()) ?></p>
                        <p>Costo: <?= htmlspecialchars($taller->getCosto()) ?> </p>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay cursos disponibles por ahora.</p>
        <?php endif; ?>
    </div>

    <!-- BANNER INFERIOR -->
    <div class="banner-inferior">
        <div class="scroll-text">
            ASOCIACION DE JUBILADOS Y PENSIONISTAS DE DURAZNO &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
            Luis Alberto de Herrera 1037 &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 43628063
        </div>
    </div>

    <!-- BOTÓN PARA MOSTRAR/OCULTAR BANNER VERTICAL -->
    <button id="toggleBannerBtn" class="toggle-banner-btn">☰</button>

    <!-- BANNER VERTICAL -->
    <div class="vertical-banner" id="verticalBanner">
        <button onclick="window.location.href='institucion.html'">Institución</button>
        <button onclick="window.location.href='#autoridades'">Autoridades</button>
        <button onclick="window.location.href='#talleres'">Talleres</button>
      <button onclick="window.location.href='./admin/index.php'">Admin</button>
          <button onclick="window.location.href='productos.php'">Productos</button>
         
    </div>

    <!-- JS -->
    <script>


        // Toggle banner vertical
        const toggleBtn = document.getElementById('toggleBannerBtn');
        const verticalBanner = document.getElementById('verticalBanner');

        toggleBtn.addEventListener('click', () => {
            if (verticalBanner.style.display === 'none') {
                verticalBanner.style.display = 'flex';
            } else {
                verticalBanner.style.display = 'none';
            }
        });

        // Mostrar por defecto
        verticalBanner.style.display = 'flex';

        // Logo animación opcional
        const logoImg = document.querySelector('.logo-header img');
        if (logoImg) {
            logoImg.addEventListener('click', () => {
                logoImg.classList.toggle('enlarged');
            });
        }
    </script>
 

    <div id="imageOverlay" class="image-overlay">
    <span class="close-overlay" onclick="closeImageOverlay()">&times;</span>
    <img id="overlayImage" src="" alt="Imagen ampliada">
</div>



<script>
    function showImageOverlay(src) {
        const overlay = document.getElementById('imageOverlay');
        const overlayImage = document.getElementById('overlayImage');
        overlayImage.src = src;
        overlay.style.display = 'flex';
    }

    function closeImageOverlay() {
        const overlay = document.getElementById('imageOverlay');
        overlay.style.display = 'none';
        document.getElementById('overlayImage').src = '';
    }

    // Asignar evento a las imágenes
    document.addEventListener('DOMContentLoaded', function () {
        const logo = document.querySelector('.logo-header img');
        const bandera = document.querySelector('.flag img');

        if (logo) {
            logo.style.cursor = 'pointer';
            logo.addEventListener('click', () => {
                showImageOverlay(logo.src);
            });
        }

        if (bandera) {
            bandera.style.cursor = 'pointer';
            bandera.addEventListener('click', () => {
                showImageOverlay(bandera.src);
            });
        }
    });
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeLoginModal()">&times;</span>

    <form method="post" action="login.php" class="login-form">
        <label for="ci">Usuario</label>
        <input type="text" name="ci" id="ci" required>

        <label for="Pass">Contraseña</label>
        <input type="password" name="Pass" id="Pass" required>

        <input type="submit" name="login" value="Iniciar sesión">
       
    
        </form>
        <button 
    onclick="window.location.href='registro.php'" 
    style="margin-top: 15px; font-size: 1.6em; padding: 15px 25px; background-color: #0074d9; color: white; border: none; border-radius: 6px; cursor: pointer; width: 100%;">
    Registrarse
</button>
  </div>
</div>

    </form>
  </div>
</div>


</script>
<script>
function openLoginModal() {
    document.getElementById("loginModal").style.display = "flex";
}

function closeLoginModal() {
    document.getElementById("loginModal").style.display = "none";
}

// Cierra el modal si se hace clic fuera del contenido
window.onclick = function(event) {
    const modal = document.getElementById("loginModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};
</script>



<script>
    //Abrie el modal 
function openLoginModal() {
    const modal = document.getElementById("loginModal");
    const iframe = document.getElementById("loginIframe");
    
    // Al abrir, siempre carga login.php con altura 300px
    iframe.src = "login.php";
    iframe.style.height = "300px";

    modal.style.display = "flex";
}

// Ajustar altura del iframe cuando cambia a registro.php
document.addEventListener("DOMContentLoaded", function () {
    const iframe = document.getElementById("loginIframe");

    iframe.addEventListener("load", function () {
        const currentUrl = iframe.contentWindow.location.href;
        if (currentUrl.includes("registro.php")) {
            iframe.style.height = "800px"; // Ajustá si necesitás más
        } else {
            iframe.style.height = "300px";
        }
    });
});
</script>

<script>
  // Obtener elementos
  var modal = document.getElementById("modal");
  var logo = document.getElementById("logo");
  var modalImg = document.getElementById("modal-img");
  var closeBtn = document.getElementsByClassName("close")[0];

  // Al hacer clic en el logo, mostrar modal
  logo.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
  }

  // Al hacer clic en la X, cerrar modal
  closeBtn.onclick = function() {
    modal.style.display = "none";
  }

  // Cerrar si se hace clic fuera de la imagen
  modal.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>



<?php
session_start();
include_once __DIR__ . '/admin/seccion/persona.php';
include_once __DIR__ . '/admin/seccion/bd.php';
include_once __DIR__ . '/admin/seccion/Talleres.php';
include_once ("admin/seccion/bd.php");

$talleresBD = new TalleresBD();
$listaTalleres = $talleresBD->ListarTalleres();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Página con Banner</title>
  <link rel="stylesheet" href="./estilos/Index.css"> 

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    justify-content: center;
    align-items: center;
    overflow: hidden; /*elimina la barra de desplazamiento*/
}

.modal-content {
    background-color: #0057a0;
    padding: 60px 80px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
    color: white;
    font-family: Arial, sans-serif;
    width: 100%;
    max-width: 800px;
    position: relative;
    overflow: hidden;
}

.modal-content .close {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 28px;
    font-weight: bold;
    color: white;
    cursor: pointer;
}

.login-form input[type="text"],
.login-form input[type="password"],
.login-form input[type="submit"] {
    display: block;
    width: 100%;
    margin: 12px 0;
    padding: 10px;
    font-size: 20px;
    border: none;
    border-radius: 5px;
}

.login-form input[type="submit"] {
    background-color: #003d70;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 2.5em; /* tamaño aumentado */
    padding: 10px 0;    /* espacio interno aumentado */
    border: none;
    border-radius: 5px;
    margin-top: 10px;

}

.login-form input[type="submit"]:hover {
    background-color: #002f5c;
 }

 /* Contenedor del botón */
#userButton, #loginButton {
    position: fixed;        /* Para mantener el botón fijo en la pantalla */
    top: 10px;              /* Alineado a 10px del borde superior */
    right: 10px;             /* Alineado a 10px del borde izquierdo */
    background-color: #4CAF50; /* Color de fondo (puedes cambiarlo) */
    color: white;           /* Color del texto */
    padding: 10px 20px;     /* Espaciado dentro del botón */
    border: none;           /* Sin borde */
    border-radius: 5px;     /* Bordes redondeados */
    font-size: 16px;        /* Tamaño de la fuente */
    cursor: pointer;       /* Cursor de mano */
    display: flex;          /* Usamos flexbox para alinear el texto y el ícono */
    align-items: center;    /* Centrado vertical */
    gap: 10px;              /* Espacio entre el ícono y el nombre */
    z-index: 9999;          /* Asegura que se quede arriba de otros elementos */
}

/* Alineación del ícono dentro del botón */
.user-icon {
    font-size: 20px; /* Tamaño del emoji */
}

/* Cambiar el color del botón al pasar el ratón */
#userButton:hover, #loginButton:hover {
    background-color: #45a049;
}

/* Estilo para el botón de cerrar sesión */
.logout-button {
    background-color: #f44336; /* Color de fondo rojo */
    color: white;              /* Color del texto */
    border: none;              /* Sin borde */
    padding: 5px 15px;         /* Espaciado dentro del botón */
    border-radius: 5px;        /* Bordes redondeados */
    cursor: pointer;          /* Cursor de mano */
}

.logout-button:hover {
    background-color: #e53935; /* Color más oscuro al pasar el ratón */
}

</style>


</head>
<body>





    <!-- HEADER -->
    <header>
        <div class="header-content">
            <div class="flag">
                <img src="./images/bandera.png" alt="Bandera">
            </div>
            <div class="logo-header">
                <img src="./images/Logo.png" alt="Logo">
                
            </div>
          
           <button class="login-banner-button" onclick="openLoginModal()">Iniciar sesión</button>
        </div>
        <div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeLoginModal()">&times;</span>
    
    <h2 style="text-align:center; margin-top: 0;">Ingrese sus Datos</h2> <!-- TÍTULO del Formulario -->


    <!-- Aquí se carga login.php -->
  <iframe id="loginIframe" src="login.php" frameborder="0" 
    style="width: 100%; height: 300px; border-radius: 10px; overflow: hidden;">
</iframe>
  </div>
</div>
    </header>

        <!-- LISTADO DE TALLERES -->
    <div class="grid-container">
        <?php if ($listaTalleres && is_array($listaTalleres)): ?>
            <?php foreach ($listaTalleres as $taller): ?>
                <div class="card">
                    <img src="./images/<?= htmlspecialchars($taller->getFoto()) ?>" alt="Foto de <?= htmlspecialchars($taller->getNombre()) ?>">
                    <div class="card-content">
                        <h3><?= htmlspecialchars($taller->getNombre()) ?></h3>
                        <p>Día: <?= htmlspecialchars($taller->getDia()) ?></p>
                        <p>Horario: <?= htmlspecialchars($taller->getHorario()) ?></p>
                        <p>Costo: <?= htmlspecialchars($taller->getCosto()) ?> </p>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay cursos disponibles por ahora.</p>
        <?php endif; ?>
    </div>

    <!-- BANNER INFERIOR -->
    <div class="banner-inferior">
        <div class="scroll-text">
            ASOCIACION DE JUBILADOS Y PENSIONISTAS DE DURAZNO &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
            Luis Alberto de Herrera 1037 &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 43628063
        </div>
    </div>

    <!-- BOTÓN PARA MOSTRAR/OCULTAR BANNER VERTICAL -->
    <button id="toggleBannerBtn" class="toggle-banner-btn">☰</button>

    <!-- BANNER VERTICAL -->
    <div class="vertical-banner" id="verticalBanner">
        <button onclick="window.location.href='institucion.html'">Institución</button>
        <button onclick="window.location.href='/sitioweb/autoridades.php'">Autoridades</button>
        <button onclick="window.location.href='#talleres'">Talleres</button>
      <button onclick="window.location.href='./admin/index.php'">Admin</button>
          <button onclick="window.location.href='productos.php'">Productos</button>
         
    </div>

    <!-- JS -->
    <script>


        // Toggle banner vertical
        const toggleBtn = document.getElementById('toggleBannerBtn');
        const verticalBanner = document.getElementById('verticalBanner');

        toggleBtn.addEventListener('click', () => {
            if (verticalBanner.style.display === 'none') {
                verticalBanner.style.display = 'flex';
            } else {
                verticalBanner.style.display = 'none';
            }
        });

        // Mostrar por defecto
        verticalBanner.style.display = 'flex';

        // Logo animación opcional
        const logoImg = document.querySelector('.logo-header img');
        if (logoImg) {
            logoImg.addEventListener('click', () => {
                logoImg.classList.toggle('enlarged');
            });
        }
    </script>
 

    <div id="imageOverlay" class="image-overlay">
    <span class="close-overlay" onclick="closeImageOverlay()">&times;</span>
    <img id="overlayImage" src="" alt="Imagen ampliada">
</div>



<script>
    function showImageOverlay(src) {
        const overlay = document.getElementById('imageOverlay');
        const overlayImage = document.getElementById('overlayImage');
        overlayImage.src = src;
        overlay.style.display = 'flex';
    }

    function closeImageOverlay() {
        const overlay = document.getElementById('imageOverlay');
        overlay.style.display = 'none';
        document.getElementById('overlayImage').src = '';
    }

    // Asignar evento a las imágenes
    document.addEventListener('DOMContentLoaded', function () {
        const logo = document.querySelector('.logo-header img');
        const bandera = document.querySelector('.flag img');

        if (logo) {
            logo.style.cursor = 'pointer';
            logo.addEventListener('click', () => {
                showImageOverlay(logo.src);
            });
        }

        if (bandera) {
            bandera.style.cursor = 'pointer';
            bandera.addEventListener('click', () => {
                showImageOverlay(bandera.src);
            });
        }
    });
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeLoginModal()">&times;</span>

    <form method="post" action="login.php" class="login-form">
        <label for="ci">Usuario</label>
        <input type="text" name="ci" id="ci" required>

        <label for="Pass">Contraseña</label>
        <input type="password" name="Pass" id="Pass" required>

        <input type="submit" name="login" value="Iniciar sesión">
       
    
        </form>
        <button 
    onclick="window.location.href='registro.php'" 
    style="margin-top: 15px; font-size: 1.6em; padding: 15px 25px; background-color: #0074d9; color: white; border: none; border-radius: 6px; cursor: pointer; width: 100%;">
    Registrarse
</button>
  </div>
</div>

    </form>
  </div>
</div>


</script>
<script>
function openLoginModal() {
    document.getElementById("loginModal").style.display = "flex";
}

function closeLoginModal() {
    document.getElementById("loginModal").style.display = "none";
}

// Cierra el modal si se hace clic fuera del contenido
window.onclick = function(event) {
    const modal = document.getElementById("loginModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};
</script>



<script>
    //Abrie el modal 
function openLoginModal() {
    const modal = document.getElementById("loginModal");
    const iframe = document.getElementById("loginIframe");
    
    // Al abrir, siempre carga login.php con altura 300px
    iframe.src = "login.php";
    iframe.style.height = "300px";

    modal.style.display = "flex";
}

// Ajustar altura del iframe cuando cambia a registro.php
document.addEventListener("DOMContentLoaded", function () {
    const iframe = document.getElementById("loginIframe");

    iframe.addEventListener("load", function () {
        const currentUrl = iframe.contentWindow.location.href;
        if (currentUrl.includes("registro.php")) {
            iframe.style.height = "800px"; // Ajustá si necesitás más
        } else {
            iframe.style.height = "300px";
        }
    });
});
</script>

<script>
  // Obtener elementos
  var modal = document.getElementById("modal");
  var logo = document.getElementById("logo");
  var modalImg = document.getElementById("modal-img");
  var closeBtn = document.getElementsByClassName("close")[0];

  // Al hacer clic en el logo, mostrar modal
  logo.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
  }

  // Al hacer clic en la X, cerrar modal
  closeBtn.onclick = function() {
    modal.style.display = "none";
  }

  // Cerrar si se hace clic fuera de la imagen
  modal.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>



</body>
</html>
<script>
window.addEventListener("message", function(event) {
    if (event.data === "loginExitoso") {
        closeLoginModal(); // cierra el modal
        window.location.href = "index.php"; // recarga el index ya logueado
    }
});
</script>


</body>
</html>
