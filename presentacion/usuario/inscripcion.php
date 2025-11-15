<?php 
include_once 'cabecera.php';
 include_once '../../logica/admin/bd.php'; 
$taller = null;
// obtecion de datos
if(isset($_GET['id'])){
    $idTaller = $_GET['id'];

    $sentencia = $conexion->prepare("SELECT * FROM talleres WHERE Id=:Id");
    $sentencia->bindParam(":Id", $idTaller);
    $sentencia->execute();
    $taller = $sentencia->fetch(PDO::FETCH_ASSOC);
}

if(!$taller){
    echo "<h2>Taller no encontrado</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($taller['nombre']); ?> - Detalles del Taller</title>
    <link rel="stylesheet" href="../../css/usuario/t.css">

</head>
<body>
    <div class="pagina-detalle">
        <div class="contenedor-detalle">
            <div class="header-detalle">
                <h1 class="titulo-taller"><?php echo htmlspecialchars($taller['nombre']); ?></h1>
                <div class="estado-taller">
                    <?php echo $taller['estado'] == 'activo' ? '🟢 Taller Activo' : '🔴 Taller Inactivo'; ?>
                </div>
            </div>
            
            <div class="contenido-detalle">
                <div class="seccion-imagen">
                    <img src="./images/<?php echo $taller['foto']; ?>" 
                         alt="Imagen del taller <?php echo htmlspecialchars($taller['nombre']); ?>" 
                         class="imagen-taller">
                </div>
                
                <div class="seccion-info">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-icono">📅</span>
                            <div class="info-contenido">
                                <div class="info-label">Día del Taller</div>
                                <div class="info-valor"><?php echo htmlspecialchars($taller['dia']); ?></div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-icono">⏰</span>
                            <div class="info-contenido">
                                <div class="info-label">Horario</div>
                                <div class="info-valor"><?php echo htmlspecialchars($taller['horario']); ?></div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-icono">💰</span>
                            <div class="info-contenido">
                                <div class="info-label">Costo</div>
                                <div class="info-valor"><?php echo htmlspecialchars($taller['costo']); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="descripcion-taller">
                        <h3>📖 Descripción del Taller</h3>
                        <p class="descripcion-texto"><?php echo htmlspecialchars($taller['descripcion']); ?></p>
                    </div>
                    
                    <div class="botones-accion">
                        <a href="talleres.php" class="btn-volver">
                            ← Volver a Talleres
                        </a>
                        
                        <?php if ($taller['estado'] == 'activo'): ?>
                            <a href="inscripcion.php?id=<?php echo $taller['Id']; ?>" class="btn-inscribir">
                                ✍️ Inscribirse al Taller
                            </a>
                        <?php else: ?>
                            <button class="btn-inscribir" style="background: #8b6b6b; border-color: #8b6b6b; cursor: not-allowed;" disabled>
                                ⏸️ Taller No Disponible
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php  include_once 'pie.php'; ?>
</body>
</html>