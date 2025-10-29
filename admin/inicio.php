<?php include_once 'template/cabecera.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <link rel="stylesheet" href="./css/inicio.css">
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

        <!-- Estadísticas Rápidas -->
        <div class="stats-grid">
            <div class="stat-card fade-in" style="animation-delay: 0.1s">
                <span class="stat-icon">📚</span>
                <span class="stat-number">150</span>
                <span class="stat-label">Libros Registrados</span>
            </div>
            
            <div class="stat-card fade-in" style="animation-delay: 0.2s">
                <span class="stat-icon">👥</span>
                <span class="stat-number">89</span>
                <span class="stat-label">Socios Activos</span>
            </div>
            
            <div class="stat-card fade-in" style="animation-delay: 0.3s">
                <span class="stat-icon">🎨</span>
                <span class="stat-number">12</span>
                <span class="stat-label">Talleres Activos</span>
            </div>
            
            <div class="stat-card fade-in" style="animation-delay: 0.4s">
                <span class="stat-icon">💼</span>
                <span class="stat-number">8</span>
                <span class="stat-label">Empleados</span>
            </div>
        </div>

        <!-- Acciones Rápidas -->
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

        <!-- Actividad Reciente -->
        <div class="recent-activity fade-in" style="animation-delay: 0.6s">
            <h2 class="section-title">
                <i class="fas fa-history"></i>
                Actividad Reciente
            </h2>
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Nuevo libro "Cien años de soledad" agregado al catálogo</div>
                        <div class="activity-time">Hace 2 horas</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Nuevo socio registrado: María González</div>
                        <div class="activity-time">Hace 4 horas</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Taller de pintura actualizado con nuevo horario</div>
                        <div class="activity-time">Ayer a las 15:30</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Pago de membresía registrado para Carlos López</div>
                        <div class="activity-time">Ayer a las 11:15</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
// Animación de contadores (opcional - para estadísticas reales)
document.addEventListener('DOMContentLoaded', function() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    statNumbers.forEach(stat => {
        const target = parseInt(stat.textContent);
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            stat.textContent = Math.floor(current);
        }, 30);
    });
});

// Efecto de aparición al hacer scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observar todos los elementos con clase fade-in
document.querySelectorAll('.fade-in').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});
</script>
</body>
</html>
<?php include_once ('template/pie.php'); ?>