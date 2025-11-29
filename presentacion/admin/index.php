<?php include_once 'cabecera.php';
include_once(__DIR__ ."/../../Logica/Admin/bd.php");
$servername = "localhost";
$username = "root";
$password = "abc123";
$dbname = "asociacion";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener estadísticas
$libros_query = "SELECT COUNT(*) as total FROM libros";
$socios_query = "SELECT COUNT(*) as total FROM socios WHERE estado = 'activo'";
$talleres_query = "SELECT COUNT(*) as total FROM talleres WHERE estado = 'activo'";
$empleados_query = "SELECT COUNT(*) as total FROM trabajadores WHERE estado = 'activo'";

$libros_result = $conn->query($libros_query);
$socios_result = $conn->query($socios_query);
$talleres_result = $conn->query($talleres_query);
$empleados_result = $conn->query($empleados_query);

$total_libros = $libros_result->fetch_assoc()['total'];
$total_socios = $socios_result->fetch_assoc()['total'];
$total_talleres = $talleres_result->fetch_assoc()['total'];
$total_empleados = $empleados_result->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <link rel="stylesheet" href="../../css/admin/inicio.css">

       <title>Document</title>
</head>
<body>
       


<div class="dashboard-container">
    <div class="container-fluid">
        <!-- Sección de Bienvenida -->
        <div class="welcome-section fade-in">
            <h1 class="welcome-title">🎉 ¡Bienvenido al Panel Administrativo!</h1>
            <p class="welcome-subtitle">Gestiona toda tu biblioteca desde un solo lugar</p>
        </div>

     <div class="stats-grid">
    <div class="stat-card fade-in" style="animation-delay: 0.1s">
        <span class="stat-icon">📚</span>
        <span class="stat-number"><?php echo $total_libros; ?></span>
        <span class="stat-label">Libros Registrados</span>
    </div>
    
    <div class="stat-card fade-in" style="animation-delay: 0.2s">
        <span class="stat-icon">👥</span>
        <span class="stat-number"><?php echo $total_socios; ?></span>
        <span class="stat-label">Socios Activos</span>
    </div>
    
    <div class="stat-card fade-in" style="animation-delay: 0.3s">
        <span class="stat-icon">🎨</span>
        <span class="stat-number"><?php echo $total_talleres; ?></span>
        <span class="stat-label">Talleres Activos</span>
    </div>
    
    <div class="stat-card fade-in" style="animation-delay: 0.4s">
        <span class="stat-icon">💼</span>
        <span class="stat-number"><?php echo $total_empleados; ?></span>
        <span class="stat-label">Empleados</span>
    </div>
</div>
      
        <div class="actions-grid">
            <div class="action-card fade-in" style="animation-delay: 0.2s">
                <span class="action-icon">📖</span>
                <h3 class="action-title">Gestión de Libros</h3>
                <p class="action-description">Administra el catálogo completo de libros, agrega nuevos títulos y gestiona inventario.</p>
                <a href="productos.php" class="btn-dashboard">
                    <i class="fas fa-cog"></i>
                    Administrar Libros
                </a>
            </div>

            <div class="action-card fade-in" style="animation-delay: 0.3s">
                <span class="action-icon">🎨</span>
                <h3 class="action-title">Talleres Culturales</h3>
                <p class="action-description">Gestiona talleres, horarios, inscripciones y toda la programación cultural.</p>
                <a href="paneladmin.php" class="btn-dashboard">
                    <i class="fas fa-palette"></i>
                    Administrar Talleres
                </a>
            </div>

            <div class="action-card fade-in" style="animation-delay: 0.4s">
                <span class="action-icon">👥</span>
                <h3 class="action-title">Socios y Membresías</h3>
                <p class="action-description">Administra socios, membresías, pagos y estado de cuentas.</p>
                <a href="socios.php" class="btn-dashboard">
                    <i class="fas fa-users"></i>
                    Administrar Socios
                </a>
            </div>

            <div class="action-card fade-in" style="animation-delay: 0.5s">
                <span class="action-icon">👨‍💼</span>
                <h3 class="action-title">Personal y Autoridades</h3>
                <p class="action-description">Gestiona el personal administrativo y autoridades de la biblioteca.</p>
                <a href="panelautoridades.php" class="btn-dashboard">
                    <i class="fas fa-user-tie"></i>
                    Administrar Personal
                </a>
            </div>
        </div>

    </div>
</div>

</body>
</html>
<?php include_once ('pie.php'); ?>