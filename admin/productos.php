
<?php  include("template/cabecera.php");
include("seccion/logistica.php"); 
include_once ("config/bd.php");
 ?>
<div class="container">
  <div class="row">
<div class="col-md-4" >
      
<div class="card">
    <div class="card-header">
        Datos
    </div>
    <div class="card-body">

<?php if (!empty($_GET['mensaje'])): ?>
    <div class="alert alert-success" role="alert">
        <?php echo htmlspecialchars($_GET['mensaje']); ?>
    </div>
<?php elseif (!empty($_GET['mensaje1'])): ?>
    <div class="alert alert-info" role="alert">
        <?php echo htmlspecialchars($_GET['mensaje1']); ?>
    </div>
<?php elseif (!empty($_GET['mensaje2'])): ?>
    <div class="alert alert-warning" role="alert">
        <?php echo htmlspecialchars($_GET['mensaje2']); ?>
    </div>
<?php elseif (!empty($_GET['mensaje3'])): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($_GET['mensaje3']); ?>
    </div>
<?php endif; ?>


<form method="POST" enctype="multipart/form-data">
<div class = "form-group">
<label hidden for="txtID">Id:</label>
<input  required readonly  hidden   type="text" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID; ?>" placeholder="Enter ID" >
</div>

<div class = "form-group">
<label for="txtNombre">Nombre:</label>
<input type="text" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $txtNombre; ?>" placeholder="Enter Name" required>
</div>

<div class = "form-group">
<label for="txtfecha">fecha:</label>
<input type="text" class="form-control" name="txtfecha" id="txtfecha" value="<?php echo $txtfecha ?>" placeholder="Enter Year" required>
</div>

<div class = "form-group">
<label for="txtAutor">Autor:</label>
<input type="text" class="form-control" name="txtAutor" id="txtAutor" value="<?php echo isset($txtAutor) ? $txtAutor : ''; ?>" placeholder="Enter Author" required>
</div>

<div class = "form-group">
<label for="txtStock">Stock:</label>
<input type="number" class="form-control" name="txtStock" id="txtStock" value="<?php echo isset($txtStock) ? $txtStock : ''; ?>" placeholder="Enter Stock" required>
</div>

<div class = "form-group">

<label for="txtIMG">Imagen</label>
<br>
<?php if ($txtIMG != "") { ?>
    <img src="../../images/<?php echo $txtIMG; ?>" width="100" alt=""> <?php } ?>
<input type="file" class="form-control" name="txtIMG" id="txtIMG" value="" placeholder="Enter IMG" >
</div>
<div class="btn-group" role="group" aria-label="">
   <button type="submit" name="accion" 
    <?php echo (!empty($txtID)) ? 'disabled' : ''; ?> value="Agregar" class="btn btn-success">Agregar</button>
    <button type="submit" name="accion"   value="Modificar" class="btn btn-warning">Modificar</button>
    <button type="submit" name="accion"   value="Cancelar" class="btn btn-info">Cancelar</button> 
</div> 
</form>
    </div>
</div>
</div>
<div class="col-md-8">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>fecha</th>
                <th>autor</th>
                <th>stock</th>
                <th>Imagen</th>
                 <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listaLibros as $libro) { 
             ?>
            <tr>
                <td><?php echo  $libro['id']  ?> </td>
                <td><?php echo  $libro['nombre']  ?> </td>
                  <td><?php echo  $libro['fecha']  ?> </td>           
                <td><?php echo  $libro['autor']  ?> </td>        
                <td><?php echo  $libro['stock']  ?> </td>
       <td>
                    <img src="../../images/<?php echo $libro['imagen']; ?>" width="100" alt="">

</td>
                <td>         
<form action="" method="post">
<input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">
<input type="submit" value="Seleccionar" name="accion" class="btn btn-primary" >
<input type="submit" value="Borrar" name="accion" class="btn btn-danger">
</form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    
</div>
<?php  include("../template/pie.php") ?>

