<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID']
    : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre']
    : "";
$txtApellido = (isset($_POST['txtApellido'])) ? $_POST['txtApellido']
    : "";
$txtCedula = (isset($_POST['txtCedula'])) ? $_POST['txtCedula']
    : "";
$txtDomicilio = (isset($_POST['txtDomicilio'])) ? $_POST['txtDomicilio']
    : "";
$txtTelefono = (isset($_POST['txtTelefono'])) ? $_POST['txtTelefono']
    : "";
$txtCorreo = (isset($_POST['txtCorreo'])) ? $_POST['txtCorreo']
    : "";
$txtContraseña = (isset($_POST['txtContraseña'])) ? $_POST['txtContraseña']
    : ""; 
$txtestado = (isset($_POST['txtestado'])) ? $_POST['txtestado']
    : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion']
    : "";

include_once ("config/bd.php");
include_once ("template/cabecera.php");
include_once ("seccion/users.php");

// Obtener la lista de usuarios
$sentencia = $conexion->prepare("SELECT * FROM socios");
$sentencia->execute();
$listaSocios = $sentencia->fetchAll(PDO::FETCH_ASSOC);


        // Mantener la selección después de enviar el formulario
        $estadoSeleccionado = isset($_GET['estado']) ? $_GET['estado'] : '';
         $filtro = "";
        if ($estadoSeleccionado) {
            $filtro = "WHERE estado = :estado";
        }
        $sentencia = $conexion->prepare("SELECT * FROM socios $filtro");
        if ($estadoSeleccionado) {
            $sentencia->bindParam(':estado', $estadoSeleccionado);
        }
        $sentencia->execute();
        $listaSocios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>

.list-group-item {
    border: 1px solid #ceababff;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
    margin-bottom: 10px;
    padding: 15px;
}









</style>
<body>

</form>
<div class="mb-3">
    <input type="text" id="searchInput" onkeyup="filterItems()" placeholder="Buscar Socio por Nombre o Apellido" class="form-control">
<script>
function filterItems() {
    var input, filter, items, title, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    items = document.getElementsByClassName('list-group-item');

    for (i = 0; i < items.length; i++) {
        title = items[i].getElementsByTagName("h5")[0]; // obtener el título (nombre del socio)
        if (!title) continue; // si no hay título, saltar al siguiente

        // Verificar si el nombre o apellido coincide con el filtro
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
</script>
</div>

Filtrar por estado:
<form method="GET" class="mb-3">
    <select name="estado" onchange="this.form.submit()" class="form-control">
        <option value="">Todos</option>
        <option value="activo" <?php if(isset($_GET['estado']) && $_GET['estado'] == 'activo') echo 'selected'; ?>>Activos</option>
        <option value="inactivo" <?php if(isset($_GET['estado']) && $_GET['estado'] == 'inactivo') echo 'selected'; ?>>Inactivos</option>
        
    </select>
</form>




<div class="col-md-3">
    <ul class="list-group">
        <?php foreach($listaSocios as $socio){ ?>
        <li class="list-group-item">
        <h5>    <?php  echo $socio['nombre'] . " " . $socio['apellidos']; ?></h5> 
       
        <p>Cedula: <?php echo $socio['cedula']; ?></p>
            <p>Domicilio: <?php echo $socio['domicilio']; ?></p>
            <p>Telefono: <?php echo $socio['telefono']; ?></p>
            <p>Correo: <?php echo $socio['correo']; ?></p>
            <p>Estado: <?php echo ucfirst($socio['estado']); ?></p>


        </li>   <br>
        <?php } ?>
    </ul>
  
</div>



</body>
</html>








