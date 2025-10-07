<?php  include("template/cabecera.php"); ?>
<?php include("seccion/users.php"); 
include_once ("config/bd.php");
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

Registro de Socios

<form method="POST" enctype="multipart/form-data">
<div class = "form-group">
<label  hidden for="txtID">Id:</label>
<input required readonly type="text" class="form-control" name="txtID" id="txtID" hidden
       value="<?php echo $txtID; ?>" placeholder="Enter ID">
</div>

<div class="form-group">
<label for="txtNombre">Nombre:</label>
<input type="text" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo htmlspecialchars($txtNombre); ?>"
 placeholder="Ingrese nombre" required>
</div>

<div class="form-group">
<label for="txtApellido">Apellidos:</label>
 <input type="text" class="form-control" name="txtApellido" id="txtApellido" value="<?php echo htmlspecialchars($txtApellido); ?>"
placeholder="Ingrese apellidos" required>
</div>

<div class="form-group"> 
<label for="txtCedula">Cédula (x.xxx.xxx-x):</label>
<input type="text" class="form-control" name="txtCedula" id="txtCedula" value="<?php echo htmlspecialchars($txtCedula); ?>"
placeholder="x.xxx.xxx-x" pattern="^[1-9]\.[0-9]{3}\.[0-9]{3}-[0-9X]$" title="Formato válido: x.xxx.xxx-x" required>
</div>

<div class="form-group"> <label for="txtDomicilio">Domicilio:</label>
<input type="text" class="form-control" name="txtDomicilio" id="txtDomicilio"value="<?php echo htmlspecialchars($txtDomicilio); ?>"
placeholder="Ingrese domicilio">
</div>

<div class="form-group">
 <label for="txtTelefono">Teléfono (xx/x-xxx-xxx):</label>
 <input type="text" class="form-control" name="txtTelefono" id="txtTelefono" value="<?php echo htmlspecialchars($txtTelefono); ?>"
 placeholder="8 o 9 dígitos" pattern="^[1-9]{2,3}\-[0-9]{3}\-[0-9]{3}$"       title="Debe tener 8 o 9 dígitos numéricos">
</div>
<?php //    pattern="^[0-9]{8,9}$"?>
<div class="form-group">
<label for="txtCorreo">Correo:</label>
<input type="email" class="form-control" name="txtCorreo" id="txtCorreo"
value="<?php echo htmlspecialchars($txtCorreo); ?>" placeholder="Ingrese correo electrónico"required>
</div>











<div class="form-group">
    <label for="txtestado" class="form-control" hidden>estado:</label>
  Estado:  <select name="txtestado" id="txtestado" required>
        <option value="" disabled>Seleccione</option>
        <option value="activo" <?php if($txtestado == 'activo') echo 'selected'; ?>>activo</option>
        <option value="inactivo" <?php if($txtestado == 'inactivo') echo 'selected'; ?>>inactivo</option>
    </select>
</div>

<div class="btn-group" role="group" aria-label="">
   <button type="submit" name="accion" 
    <?php echo (!empty($txtID)) ? 'disabled' : ''; ?> value="Agregar" class="btn btn-success">Agregar</button>
    <button type="submit" name="accion"   value="Modificar" class="btn btn-warning">Modificar</button>
    <button type="submit" name="accion"   value="Cancelar" class="btn btn-info">Cancelar</button> 
</div> 
</form>
<div class="mb-3">
    <form method="GET" style="display: inline;">
        <input type="hidden" name="filtroEstado" value="activo">
        <button type="submit" class="btn <?php echo (isset($_GET['filtroEstado']) && $_GET['filtroEstado']=="activo") ? 'btn-success' : 'btn-outline-success'; ?>">
            Activos
        </button>
    </form>

    <form method="GET" style="display: inline;">
        <input type="hidden" name="filtroEstado" value="inactivo">
        <button type="submit" class="btn <?php echo (isset($_GET['filtroEstado']) && $_GET['filtroEstado']=="inactivo") ? 'btn-danger' : 'btn-outline-danger'; ?>">
            Inactivos
        </button>
    </form>
</div>




<div class="col-md-8">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cedula</th>
                <th>Domicilio</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Estado</th>
                 <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($listaSocios as $usuario){ ?>
            <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td><?php echo $usuario['nombre']; ?></td>
                <td><?php echo $usuario['apellidos']; ?></td>
                <td><?php echo $usuario['cedula']; ?></td>
                <td><?php echo $usuario['domicilio']; ?></td>
                <td><?php echo $usuario['telefono']; ?></td>
                <td><?php echo $usuario['correo']; ?></td>
                <td><?php echo $usuario['estado']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $usuario['id']; ?>">
                        
                        <input type="submit" class="btn btn-warning" name="accion" value="Seleccionar">
                    </form>
</td>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
        </div>
<?php  include("../template/pie.php"); ?>
    
</body>
</html> 
