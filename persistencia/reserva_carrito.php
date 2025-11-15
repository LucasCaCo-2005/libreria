<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once 'bd.php';
include_once '../template/cabecera.php';
include_once __DIR__ . '/../users/loginBanner.php';



// Verificamos que el usuario esté logueado
if (!isset($_SESSION['socios'])) {
    echo "<h2>Error: Debes iniciar sesión para ver tu carrito de reservas.</h2>";
    exit();
}

// Obtenemos el ID del usuario logueado
$usuario_id = $_SESSION['socios']['id'];

// Procesar acciones: confirmar o eliminar reserva
if (isset($_GET['accion']) && isset($_GET['reserva_id'])) {
    $reserva_id = $_GET['reserva_id'];

    if ($_GET['accion'] === 'confirmar') {
        // Cambiar el estado de la reserva a 'confirmado'
        $stmt = $conexion->prepare("UPDATE reservas SET estado = 'confirmado' WHERE id = :reserva_id AND usuario_id = :usuario_id");
        $stmt->bindValue(':reserva_id', $reserva_id);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->execute();
    }

    if ($_GET['accion'] === 'eliminar') {
        // Eliminar la reserva del carrito
        $stmt = $conexion->prepare("DELETE FROM reservas WHERE id = :reserva_id AND usuario_id = :usuario_id");
        $stmt->bindValue(':reserva_id', $reserva_id);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->execute();
    }

    // Redirigir para evitar re-envío de formularios
    header("Location: reserva_carrito.php");
    exit();
}

// Obtener todas las reservas en carrito del usuario
$stmt = $conexion->prepare("
    SELECT r.id AS reserva_id, r.estado, r.fecha_reserva, l.nombre AS titulo, l.autor, l.imagen
    FROM reservas r
    JOIN libros l ON r.libro_id = l.id
    WHERE r.usuario_id = :usuario_id AND r.estado = 'en carrito'
");
$stmt->bindValue(':usuario_id', $usuario_id);
$stmt->execute();
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- <link rel="stylesheet" href="./estilos/index.css"> -->
    <link rel="stylesheet" href="../css/modal.css">
     <?php include_once '../template/cabecera.php'; ?> 
</head>
<body>
    
</body>
</html>
<h2>Mi Carrito de Reservas</h2>

<?php if ($reservas): ?>
    <div class="carrito-reservas">
        <?php foreach ($reservas as $reserva): ?>
            <div class="reserva-item">
                <div class="imagen-libro">
                    <img src="../images/<?php echo $reserva['imagen']; ?>" alt="Portada de <?php echo $reserva['titulo']; ?>" width="120">
                </div>
                <div class="info-libro">
                    <h3><?php echo $reserva['titulo']; ?></h3>
                    <p>Autor: <?php echo $reserva['autor']; ?></p>
                    <p>Agregado al carrito: <?php echo $reserva['fecha_reserva']; ?></p>
                    <div class="acciones-reserva">
                        <a href="reserva_carrito.php?accion=confirmar&reserva_id=<?php echo $reserva['reserva_id']; ?>" class="btn-confirmar">Confirmar</a>
                        <a href="reserva_carrito.php?accion=eliminar&reserva_id=<?php echo $reserva['reserva_id']; ?>" class="btn-eliminar">Eliminar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No tienes libros en tu carrito de reservas.</p>
<?php endif; ?>

<style>
    
.carrito-reservas {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.reserva-item {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 6px;
}
.imagen-libro img {
    border-radius: 4px;
}
.info-libro {
    margin-left: 15px;
}
.acciones-reserva a {
    display: inline-block;
    margin-right: 10px;
    padding: 5px 10px;
    text-decoration: none;
    color: white;
    border-radius: 4px;
}
.btn-confirmar { background-color: #28a745; }
.btn-eliminar { background-color: #dc3545; }
</style>
<?phpinclude_once '../template/pie.php';?>
