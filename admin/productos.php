<?php
session_start(); // 👈 Debe estar siempre al inicio
include_once("seccion/bd.php");
include("seccion/logistica.php"); // Procesa Agregar/Modificar/Seleccionar/Borrar

// 1️⃣ Variables iniciales
$txtID = $txtNombre = $txtIMG = $txtfecha = $txtAutor = $txtStock = $txtDesc = $txtCat = "";

// 2️⃣ Llenar variables si hay libro seleccionado
if (isset($_SESSION['libroSeleccionado'])) {
    $txtID     = $_SESSION['libroSeleccionado']['id'];
    $txtNombre = $_SESSION['libroSeleccionado']['nombre'];
    $txtIMG    = $_SESSION['libroSeleccionado']['imagen'];
    $txtfecha  = $_SESSION['libroSeleccionado']['fecha'];
    $txtAutor  = $_SESSION['libroSeleccionado']['autor'];
    $txtStock  = $_SESSION['libroSeleccionado']['stock'];
    $txtDesc   = $_SESSION['libroSeleccionado']['descripcion'];
    $txtCat    = $_SESSION['libroSeleccionado']['categoria'];

    unset($_SESSION['libroSeleccionado']); // Se usa solo una vez
}

// 3️⃣ Traer lista de libros
$listaLibros = $conexion->query("SELECT * FROM libros")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("template/cabecera.php"); ?>

<?php if (!empty($txtNombre)): ?>
  <div class="alert alert-info">
    Editando libro: <strong><?= htmlspecialchars($txtNombre); ?></strong>
  </div>
<?php endif; ?>


<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">Datos</div>
        <div class="card-body">

          <?php if (!empty($_GET['mensaje'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['mensaje']); ?></div>
          <?php elseif (!empty($_GET['mensaje1'])): ?>
            <div class="alert alert-info"><?= htmlspecialchars($_GET['mensaje1']); ?></div>
          <?php elseif (!empty($_GET['mensaje2'])): ?>
            <div class="alert alert-warning"><?= htmlspecialchars($_GET['mensaje2']); ?></div>
          <?php elseif (!empty($_GET['mensaje3'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['mensaje3']); ?></div>
          <?php endif; ?>

          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="txtID" value="<?= $txtID; ?>">

            <div class="form-group">
              <label>Nombre:</label>
              <input type="text" class="form-control" name="txtNombre" value="<?= $txtNombre; ?>" required>
            </div>

            <div class="form-group">
              <label>Fecha:</label>
              <input type="text" class="form-control" name="txtfecha" value="<?= $txtfecha; ?>" required>
            </div>

            <div class="form-group">
              <label>Autor:</label>
              <input type="text" class="form-control" name="txtAutor" value="<?= $txtAutor; ?>" required>
            </div>

            <div class="form-group">
              <label>Stock:</label>
              <input type="number" class="form-control" name="txtStock" value="<?= $txtStock; ?>" required>
            </div>

            <div class="form-group">
              <label>Descripción:</label>
              <input type="text" class="form-control" name="txtDesc" value="<?= $txtDesc; ?>" required>
            </div>

            <div class="form-group">
              <label>Categoría:</label>
              <select class="form-control" name="txtCat" id="txtCat" required>
                <option value="" disabled <?= empty($txtCat) ? 'selected' : ''; ?>>Seleccione</option>
                <option value="Fantasia"   <?= ($txtCat == 'Fantasia') ? 'selected' : ''; ?>>Fantasia</option>
                <option value="Terror"     <?= ($txtCat == 'Terror') ? 'selected' : ''; ?>>Terror</option>
                <option value="Drama"      <?= ($txtCat == 'Drama') ? 'selected' : ''; ?>>Drama</option>
                <option value="Misterio"   <?= ($txtCat == 'Misterio') ? 'selected' : ''; ?>>Misterio</option>
                <option value="Historico"  <?= ($txtCat == 'Historico') ? 'selected' : ''; ?>>Historico</option>
                <option value="Ficcion"    <?= ($txtCat == 'Ficcion') ? 'selected' : ''; ?>>Ciencia Ficcion</option>
                <option value="Romantico"  <?= ($txtCat == 'Romantico') ? 'selected' : ''; ?>>Romantico</option>
                <option value="Biografia"  <?= ($txtCat == 'Biografia') ? 'selected' : ''; ?>>Biografia</option>
                <option value="Autoayuda"  <?= ($txtCat == 'Autoayuda') ? 'selected' : ''; ?>>Autoayuda</option>
                <option value="Nacional"   <?= ($txtCat == 'Nacional') ? 'selected' : ''; ?>>Nacional</option>
                <option value="Otros"      <?= ($txtCat == 'Otros') ? 'selected' : ''; ?>>Otros</option>
              </select>
            </div>

            <div class="form-group">
              <label>Imagen:</label><br>
              <?php if ($txtIMG != ""): ?>
                <img src="../../images/<?= $txtIMG; ?>" width="100">
              <?php endif; ?>
              <input type="file" class="form-control" name="txtIMG">
            </div>

            <div class="btn-group" role="group">
              <button type="submit" name="accion" value="Agregar" <?= !empty($txtID) ? 'disabled' : ''; ?> class="btn btn-success">Agregar</button>
              <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
              <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
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
            <th>Fecha</th>
            <th>Autor</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Desc</th>
            <th>Imagen</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listaLibros as $libro): ?>
            <tr>
              <td><?= $libro['id']; ?></td>
              <td><?= $libro['nombre']; ?></td>
              <td><?= $libro['fecha']; ?></td>
              <td><?= $libro['autor']; ?></td>
              <td><?= $libro['stock']; ?></td>
              <td><?= $libro['categoria']; ?></td>
              <td><?= substr($libro['descripcion'], 0, 50) . '...'; ?></td>
              <td><img src="../../images/<?= $libro['imagen']; ?>" width="100"></td>
              <td>
                <form method="post">
                  <input type="hidden" name="txtID" value="<?= $libro['id']; ?>">
                  <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                  <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include("template/pie.php"); ?>
