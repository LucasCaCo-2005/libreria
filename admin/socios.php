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

<div class = "form-group">
<label for="txtNombre">Nombre:</label>
<input type="text" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo "$txtNombre"   ?> " placeholder="Enter Name" required>
</div>

<div class = "form-group">
<label for="txtApellido">Apellidos:</label>
<input type="text" class="form-control" name="txtApellido" id="txtApellido" value="<?php echo "$txtApellido"   ?> " placeholder="Enter Last Name" required>
</div>


<div class = "form-group">
<label for="txtCedula">Cedula:</label>
<input type="text" class="form-control" name="txtCedula" id="txtCedula" value="<?php echo "$txtCedula"   ?> " placeholder="Enter Cedula" required>
</div>

<div class = "form-group">
<label for="txtNombre">Domicilio:</label>
<input type="text" class="form-control" name="txtDomicilio" id="txtDomicilio" value="<?php echo "$txtDomicilio"   ?> " placeholder="Enter Address" >
</div>

<div class = "form-group">
<label for="txtTelefono">Telefono:</label>
<input type="text" class="form-control" name="txtTelefono" id="txtTelefono" value="<?php echo "$txtTelefono"   ?> " placeholder="Enter Phone" >
</div>

<div class = "form-group">
<label for="txtCorreo">Correo:</label>
<input type="Correo" class="form-control" name="txtCorreo" id="txtCorreo" value="<?php echo "$txtCorreo"   ?> " placeholder="Enter Correo" >
</div>

<div class = "form-group">
<label for="txtContraseña">Contraseña:</label>
<input type="text" class="form-control" name="txtContraseña" id="txtContraseña" value="<?php echo "$txtContraseña"   ?> " placeholder="Enter Password" >
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
                <th>Contraseña</th>
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
                <td><?php echo $usuario['contrasena']; ?></td>
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
