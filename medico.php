<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sección Médica</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/medico.css">
  <style>
   
  </style>
</head>
<body>

<?php include_once 'template/cabecera.php'; ?>
<?php include_once 'admin/seccion/trabajador.php'; ?>
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