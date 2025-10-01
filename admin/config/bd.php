<?php
$host="localhost";
$bd="asociacion";
$usuario="root";
$contraseña="abc123";

try { 
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contraseña);  
    if($conexion) { 
        echo "";
    } else {
        echo "Error al conectar a la base de datos.";
    }
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>