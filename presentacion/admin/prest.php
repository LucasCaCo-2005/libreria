<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Préstamos</title>
<<<<<<<< HEAD:presentacion/admin/prest.php
    <link rel="stylesheet" href="../../css/admin/prest.css">
========
    <link rel="stylesheet" href="../css/Admin/prest.css">
>>>>>>>> 72a969d9b84989c8325ef25b7bf44b91d1c94b1a:Presentacion/Admin/prest.php
</head>
<body>
<?php include_once 'cabecera.php'; ?>

<div class="container">
    <div class="header">
        <h1>Gestión de Préstamos</h1>
        <p>Administra y realiza seguimiento de los préstamos de libros</p>
    </div>

    <?php
    include_once(__DIR__ ."/../../Logica/Admin/bd.php");

    // Procesar devolución
    if (isset($_GET['devolver'])) {
        $idPrestamo = $_GET['devolver'];
        $fechaActual = date("Y-m-d");

        try {
            $sentencia = $conexion->prepare("
                UPDATE prestamos 
                SET estado = 'devuelto', fecha_devolucion = :fechaActual 
                WHERE id = :id
            "); // actualiza el estado a devuelto
            $sentencia->bindParam(":fechaActual", $fechaActual);
            $sentencia->bindParam(":id", $idPrestamo);
            $sentencia->execute();

            echo '<div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Libro devuelto correctamente</span>
                  </div>';
        } catch (PDOException $e) {
            echo '<div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Error al procesar la devolución: ' . $e->getMessage() . '</span>
                  </div>';
        }
    }

    // Filtro por estado
    $filtroEstado = isset($_GET['estado']) ? $_GET['estado'] : 'todos';

    // Consulta base
    $sql = "
        SELECT p.id, l.nombre AS libro, 
               p.persona, 
               p.fecha_prestamo, p.fecha_devolucion, p.estado
        FROM prestamos p
        INNER JOIN libros l ON p.libro_id = l.id
    ";

    // Aplica filtro
    if ($filtroEstado === 'prestados') {
        $sql .= " WHERE p.estado = 'prestado'";
    } elseif ($filtroEstado === 'devueltos') {
        $sql .= " WHERE p.estado = 'devuelto'";
    }

    $sql .= " ORDER BY p.fecha_prestamo DESC";

    $sentencia = $conexion->prepare($sql);
    $sentencia->execute();
    $prestamos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="card">
        <div class="card-header">
            <h2>Listado de Préstamos</h2>
            <div class="filters">
                <div class="filter-group">
                    <label for="estado">Filtrar por estado:</label> <!--Boton de filtrado-->
                    <select id="estado" onchange="filtrarPrestamos(this.value)"> <!-- Redirije al estado filtrado con JS -->
                        <option value="todos" <?php echo $filtroEstado === 'todos' ? 'selected' : ''; ?>>Todos</option>
                        <option value="prestados" <?php echo $filtroEstado === 'prestados' ? 'selected' : ''; ?>>Prestados</option>
                        <option value="devueltos" <?php echo $filtroEstado === 'devueltos' ? 'selected' : ''; ?>>Devueltos</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body">
            <?php if (empty($prestamos)): ?>
                <div class="empty-state">
                    <i class="fas fa-book-open"></i>
                    <h3>No hay préstamos registrados</h3>
                    <p>No se encontraron préstamos con los criterios seleccionados.</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Libro</th>
                            <th>Persona</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Devolución</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($prestamos as $p): ?>
                        <tr>
                            <td><?php echo $p['id']; ?></td>
                            <td><?php echo htmlspecialchars($p['libro']); ?></td>
                            <td><?php echo htmlspecialchars($p['persona']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($p['fecha_prestamo'])); ?></td>
                            <td>
                                <?php 
                                if ($p['fecha_devolucion']) {
                                    echo date('d/m/Y', strtotime($p['fecha_devolucion']));
                                } else {
                                    echo '--/--/----';
                                } // valores nulos para fechas vaciad
                                ?>
                            </td>
                            <td> <!-- Diferencia de color segun el estado -->
                                <?php if($p['estado'] == 'devuelto'): ?>
                                    <span class="badge badge-success">Devuelto</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Prestado</span>
                                <?php endif; ?>
                            </td>
                            <td> <!-- Acciones segun el contexto -->
                                <?php if($p['estado'] == 'prestado'): ?>
                                    <a href="prest.php?devolver=<?php echo $p['id']; ?>&estado=<?php echo $filtroEstado; ?>" 
                                       class="btn btn-success btn-sm"
                                       onclick="return confirm('¿Marcar como devuelto hoy?')">
                                        Devolver
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-primary btn-sm" disabled>Devuelto</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<script> // filtrado instantaneo
    function filtrarPrestamos(estado) {
        window.location.href = 'prest.php?estado=' + estado;
    }

    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>

<?php include_once 'pie.php'; ?>
</body>
</html>
