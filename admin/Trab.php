<?php 
 include("template/cabecera.php");
include("seccion/Trabajador.php"); 

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
Trabajadores
<form method="POST" enctype="multipart/form-data">
<div class = "form-group">
<label  hidden for="txtID">Id:</label>
<input required readonly type="text" class="form-control" name="txtID" id="txtID" hidden
       value="<?php echo $txtID; ?>" placeholder="Enter ID">
</div>

<div class="form-group">
<label for="txtNombre">Nombre Completo:</label>
<input type="text" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo htmlspecialchars($txtNombre); ?>"
 placeholder="Ingrese nombre y apellido" required>
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
    <label for="txtestado" class="form-control" hidden>estado:</label>
  Estado:  <select name="txtestado" id="txtestado" required>
        <option value="" disabled>Seleccione</option>
        <option value="activo" <?php if($txtestado == 'activo') echo 'selected'; ?>>activo</option>
        <option value="inactivo" <?php if($txtestado == 'inactivo') echo 'selected'; ?>>inactivo</option>
    </select>
</div>
<div class="form-group">
    <label for="txtpuesto" class="form-control" hidden>Tipo:</label>
  Tipo:  <select name="txtpuesto" id="txtpuesto" required>
        <option value="" disabled>Seleccione</option>
        <option value="Secretario" <?php if($txtpuesto == 'Secretario') echo 'selected'; ?>>Secretario</option>
        <option value="Medico" <?php if($txtpuesto == 'Medico') echo 'selected'; ?>>Medico</option>
               <option value="Podologo" <?php if($txtpuesto == 'Podologo') echo 'selected'; ?>>Podologa</option>
    </select>
</div>
<div class="btn-group" role="group" aria-label="">
   <button type="submit" name="accion" 
    <?php echo (!empty($txtID)) ? 'disabled' : ''; ?> value="Agregar" class="btn btn-success">Agregar</button>
    <button type="submit" name="accion"   value="Modificar" class="btn btn-warning">Modificar</button>
    <button type="submit" name="accion"   value="Cancelar" class="btn btn-info">Cancelar</button> 
</div> 
</form>
<div class="col-md-8">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Cedula</th>
                <th>Domicilio</th>
                <th>Telefono</th>
                <th>Estado</th>
                <th>Tipo</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php 
       // var_dump($Trab); 
            foreach($listaTrabajadores as $Trabajador){ ?>
            <tr>
                <td><?php echo $Trabajador['id']; ?></td>
                <td><?php echo $Trabajador['nombre']; ?></td>
                <td><?php echo $Trabajador['cedula']; ?></td>
                <td><?php echo $Trabajador['domicilio']; ?></td>
                <td><?php echo $Trabajador['telefono']; ?></td>
                <td><?php echo $Trabajador['estado']; ?></td>
                <td><?php echo $Trabajador['puesto']; ?></td>
                              <td>         
<form action="" method="post">
<input type="hidden" name="txtID" id="txtID" value="<?php echo $Trabajador['id']; ?>">
<input type="submit" value="Seleccionar" name="accion" class="btn btn-primary" >
</form>
                </td>   
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
