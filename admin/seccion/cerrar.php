<?php
session_start();
session_destroy();
header("Location: ../index.php?mensaje=" . urlencode("Sesión cerrada correctamente"));

?>