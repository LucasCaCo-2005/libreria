<?php
// inicia o reaunuda una sesion, necesarjos los datos de la sesion para cerrarla
session_start();
session_destroy(); // destruye la informacion de la sesion, los datos de el $SESSIOn
header("Location: index.php?mensaje=" . urlencode("Sesión cerrada correctamente")); // redirije a index
?>