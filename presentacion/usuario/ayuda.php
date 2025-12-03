<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  
     <h1 class="titulo-ayuda">Preguntas Frecuentes</h1>
    <h1>¿Cómo me hago Socio ?</h1>
    <p>Para hacerte Socio te puedes Registrar en nuestra página y cuando lo desees concurrir por nuestro local de calle Luis Alberto de Herrera 1043.</p>
    <p>Si lo prefieres podemos concurrir a tu domicilio para finalizar el trámite. </p>
    <h1>¿Qué beneficios tengo por ser Socio ? </h1>
    <p>Como Socio puedes acceder a Servicio de Enfermería, consulta con Médico, Podología, participar de los diferentes Talleres, Eventos y Viajes que se realizan.</p> 
    <p>Además podrás acceder a nuestras instalaciones y Biblioteca. </p>

    <?php
include_once(__DIR__ ."/../../Logica/Admin/bd.php");

$consultaTablas = $conexion->query("SHOW TABLES");
$tablas = $consultaTablas->fetchAll(PDO::FETCH_COLUMN);

echo "<pre>";
foreach ($tablas as $tabla) {
    echo "--- Tabla: $tabla ---\n";
    
    $consultaCreate = $conexion->query("SHOW CREATE TABLE `$tabla`");
    $createTable = $consultaCreate->fetch(PDO::FETCH_ASSOC);
    
    echo $createTable['Create Table'] . "\n\n";
}
echo "</pre>";
?>
</body>
</html>