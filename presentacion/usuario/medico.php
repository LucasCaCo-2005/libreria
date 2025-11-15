<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sección Médica</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<<<<<<<< HEAD:presentacion/usuario/medico.php
  <link rel="stylesheet" href="../../css/usuario/medico.css">
========
  <link rel="stylesheet" href="../css/Usuario/medico.css">
>>>>>>>> 72a969d9b84989c8325ef25b7bf44b91d1c94b1a:Presentacion/Usuario/medico.php
  <style>
   
  </style>
</head>
<body>

<?php include_once 'cabecera.php'; ?>
<<<<<<<< HEAD:presentacion/usuario/medico.php
<?php  include_once '../../logica/admin/trabajador.php';  ?>
========
<?php include_once '../../Logica/Admin/Trabajador.php'; ?>
>>>>>>>> 72a969d9b84989c8325ef25b7bf44b91d1c94b1a:Presentacion/Usuario/medico.php
<div class="contenedor">
  <div class="header">
    <h1>Sección Médica</h1>
    <p>Selecciona con qué especialista deseas pedir turno. Nuestro equipo está listo para atenderte.</p>
  </div>
  
  <div class="cards-container">
    <div class="card">
      <div class="card-icon">
        <i class="fas fa-user-md"></i>
      </div>
      <h2>Médico General</h2>
      <div class="specialist-name">
        <?php echo htmlspecialchars($medico['nombre'] ?? 'No disponible'); ?>
      </div>
      <p>Atención médica general, consultas de rutina, diagnóstico y tratamiento de enfermedades comunes. Control de salud preventivo y seguimiento de pacientes crónicos.</p>
      <div class="availability">
        <i class="fas fa-circle"></i> Disponible esta semana
      </div>
      <a href="https://wa.me/598092749714?text=Hola,%20quiero%20solicitar%20un%20turno%20con%20el%20médico%20general%20<?php echo urlencode($medico['nombre'] ?? ''); ?>."
         class="btn-whatsapp" target="_blank">
        <i class="fab fa-whatsapp"></i> Pedir turno por WhatsApp
      </a>
    </div>
    
    <div class="card">
      <div class="card-icon">
        <i class="fas fa-foot"></i>
      </div>
      <h2>Podólogo</h2>
      <div class="specialist-name">
        <?php echo htmlspecialchars($podologo['nombre'] ?? 'No disponible'); ?>
      </div>
      <p>Consultas y tratamientos especializados para pies y uñas. Atención de problemas dermatológicos, biomecánicos y quirúrgicos del pie. Cuidado de uñas encarnadas, callosidades y hongos.</p>
      <div class="availability">
        <i class="fas fa-circle"></i> Disponible esta semana
      </div>
      <a href="https://wa.me/598092749714?text=Hola,%20quiero%20solicitar%20un%20turno%20con%20el%20podólogo%20<?php echo urlencode($podologo['nombre'] ?? ''); ?>."
         class="btn-whatsapp" target="_blank">
        <i class="fab fa-whatsapp"></i> Pedir turno por WhatsApp 123
      </a>
    </div>
  </div>
</div>


</body>
</html>