    <?php 
include_once 'template/cabecera.php';
include_once ("config/bd.php");
include_once ("seccion/Talleres.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talleres</title>

    <style>
        .list-group-item {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin: 10px auto;
            max-width: 600px;
            background-color: #f9f9f9;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary { background-color: #007bff; color: #fff; }
        .btn-danger { background-color: #dc3545; color: #fff; }
        .btn-filter { margin: 5px; }

        .button {
    background-color: #008000;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button2 {
    background-color: #ff0000;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button3 {
    background-color: #966868ff;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}
    </style>
</head>
<body>

<br>

<div style="text-align:center;">

Buscador de Talleres:
<input type="text" id="searchInput" onkeyup="filterTalleres()" placeholder="Buscar por nombre...">
<script>
function filterTalleres() { // función para filtrar talleres
    var input, filter, container, items, title, i, txtValue; // Declarar variables
    input = document.getElementById('searchInput'); // Obtener el valor del input
    filter = input.value.toUpperCase(); // Convertir a mayúsculas para comparación
    container = document.body; // Contenedor principal
    items = container.getElementsByClassName('list-group-item');
    for (i = 0; i < items.length; i++) { 
        title = items[i].getElementsByTagName("h5")[0];
        if (title) { 
            txtValue = title.textContent || title.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) { // si coincide, mostrar
                items[i].style.display = ""; 
            } else {
                items[i].style.display = "none"; // si no coincide, ocultar
            }
        }       
    }
}
</script> <br>
    <a href="vistaT.php?estado=todos" class="btn btn-primary btn-filter">Todos los Talleres</a>
    <a href="vistaT.php?estado=activo" class="btn btn-primary btn-filter">Talleres Activos</a> <br>
    <a href="vistaT.php?estado=inactivo" class="btn btn-danger btn-filter">Talleres Inactivos</a> 
</div>
<?php


$filtro = isset($_GET['estado']) ? $_GET['estado'] : "todos";

if ($filtro == "activo") {
    $sentencia = $conexion->prepare("SELECT * FROM talleres WHERE estado='activo'");
} elseif ($filtro == "inactivo") {
    $sentencia = $conexion->prepare("SELECT * FROM talleres WHERE estado='inactivo'");
} else {
    $sentencia = $conexion->prepare("SELECT * FROM talleres");
}

$sentencia->execute();
$listaTalleres = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (empty($listaTalleres)) { ?>
    <p style="text-align:center;">No hay talleres en este estado.</p>
<?php } else { ?>
    <?php foreach($listaTalleres as $taller){ ?> 
        <div class="list-group-item">
            <h5 class="mb-1"><?php echo $taller['nombre']; ?></h5>
            <small>Fecha: <?php echo $taller['dia']; ?> | Hora: <?php echo $taller['horario']; ?></small>
            <br>  
            <img src="../images/<?php echo $taller['foto']; ?>" 
                alt="<?php echo $taller['nombre']; ?>" 
                style="max-width: 200px; height: auto;"> 
            <br><br>
<form id="formTaller<?php echo $taller['Id']; ?>" action="vistaT.php" method="post" style="display:inline;">
    <input type="hidden" name="id" value="<?php echo $taller['Id']; ?>">
    <input type="hidden" name="accion" value="">
</form>

<!-- Botón externo que hace lo mismo -->
<button 
    type="button" 
    class="button2" 
    onclick="enviarAccion('<?php echo $taller['Id']; ?>', '<?php echo $taller['estado'] == 'activo' ? 'deshabilitar' : 'habilitar'; ?>')">
    <?php echo $taller['estado'] == 'activo' ? 'Desactivar' : 'Activar'; ?>
</button>

<script>
function enviarAccion(id, accion) {

    const form = document.getElementById('formTaller' + id);
    form.querySelector('[name="accion"]').value = accion;
    form.submit(); }
</script>

        </div>
    <?php } ?>
<?php } ?>


</body>
</html>
