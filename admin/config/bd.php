<?php
$host="localhost";
$bd="sitio";
$usuario="root";
$contraseña="abc123";

try { // Try Intenta ejecutar el código dentro del bloque. Si hay un error (como no poder conectarse a la base de datos), se salta al bloque catch.
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contraseña);  //Se crea una nueva conexión a la base de datos usando los datos:
    if($conexion) { //Verifica si la conexión fue exitosa.s
        echo "";
    } else {
        echo "Error al conectar a la base de datos.";
    }
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Configura la conexión para que, si ocurre un error SQL, se lance una excepción.
} catch (Exception $e) { //Si ocurre un error dentro del try, este bloque lo captura y muestra el mensaje con:
    echo "Error: " . $e->getMessage();
}

?>