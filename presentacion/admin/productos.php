<?php 
include("cabecera.php");
include( __DIR__ . "/../../Logica/Admin/logistica.php"); 
include_once(__DIR__ . "/../../Logica/Admin/bd.php");
// __DIR__ . "/../../Logica/Admin/.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Document</title> <link rel="stylesheet" href="../../css/admin/productos.css">

</head>
<body>

<div class="container-fluid">
  <div class="row">
    
    <!-- Panel de Formulario -->
    <div class="col-md-4">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">
            <i class="fas fa-book me-2"></i>Gestión de Libros
          </h5>
        </div>
        <div class="card-body">

          <!-- Alertas -->
          <?php if (!empty($_GET['mensaje'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle me-2"></i>
              <?php echo htmlspecialchars($_GET['mensaje']); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php elseif (!empty($_GET['mensaje1'])): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <i class="fas fa-info-circle me-2"></i>
              <?php echo htmlspecialchars($_GET['mensaje1']); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php elseif (!empty($_GET['mensaje2'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-triangle me-2"></i>
              <?php echo htmlspecialchars($_GET['mensaje2']); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php elseif (!empty($_GET['mensaje3'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-circle me-2"></i>
              <?php echo htmlspecialchars($_GET['mensaje3']); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <!-- Formulario -->
          <form method="POST" enctype="multipart/form-data" id="formLibro">
            <input type="hidden" name="txtID" id="txtID" value="<?php echo $txtID; ?>">
            
            <div class="row">
           
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="txtNombre" class="form-label">
                    <i class="fas fa-heading me-1"></i>Nombre *
                  </label>
                  <input type="text" class="form-control" name="txtNombre" id="txtNombre" 
                         value="<?php echo htmlspecialchars($txtNombre); ?>" 
                         placeholder="Nombre del libro" required>
                </div>

                <div class="mb-3">
                  <label for="txtfecha" class="form-label">
                    <i class="fas fa-calendar me-1"></i>Fecha *
                  </label>
                  <input type="text" class="form-control" name="txtfecha" id="txtfecha" 
                         value="<?php echo htmlspecialchars($txtfecha); ?>" 
                         placeholder="Año de publicación" required>
                </div>

                <div class="mb-3">
                  <label for="txtAutor" class="form-label">
                    <i class="fas fa-user me-1"></i>Autor *
                  </label>
                  <input type="text" class="form-control" name="txtAutor" id="txtAutor" 
                         value="<?php echo isset($txtAutor) ? htmlspecialchars($txtAutor) : ''; ?>" 
                         placeholder="Nombre del autor" required>
                </div>
              </div>

             
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="txtStock" class="form-label">
                    <i class="fas fa-boxes me-1"></i>Stock *
                  </label>
                  <input type="number" class="form-control" name="txtStock" id="txtStock" 
                         value="<?php echo isset($txtStock) ? $txtStock : ''; ?>" 
                         placeholder="Cantidad en stock" min="0" required>
                </div>

                <div class="mb-3">
                  <label for="txtCat" class="form-label">
                    <i class="fas fa-tag me-1"></i>Categoría *
                  </label>
                  <select class="form-select" name="txtCat" id="txtCat" required>
                    <option value="">Seleccionar categoría</option>
                    <option value="Fantasia" <?php echo (isset($txtCat) && $txtCat == 'Fantasia') ? 'selected' : ''; ?>>Fantasia</option>
                    <option value="Terror" <?php echo (isset($txtCat) && $txtCat == 'Terror') ? 'selected' : ''; ?>>Terror</option>
                    <option value="Drama" <?php echo (isset($txtCat) && $txtCat == 'Drama') ? 'selected' : ''; ?>>Drama</option>
                    <option value="Misterio" <?php echo (isset($txtCat) && $txtCat == 'Misterio') ? 'selected' : ''; ?>>Misterio</option>
                    <option value="Historico" <?php echo (isset($txtCat) && $txtCat == 'Historico') ? 'selected' : ''; ?>>Historico</option>
                    <option value="Ficcion" <?php echo (isset($txtCat) && $txtCat == 'Ficcion') ? 'selected' : ''; ?>>Ficcion</option>
                    <option value="Romantico" <?php echo (isset($txtCat) && $txtCat == 'Romantico') ? 'selected' : ''; ?>>Romantico</option>
                     <option value="Biografia" <?php echo (isset($txtCat) && $txtCat == 'Biografia') ? 'selected' : ''; ?>>Biografia</option>
                      <option value="Autoayuda" <?php echo (isset($txtCat) && $txtCat == 'Autoayuda') ? 'selected' : ''; ?>>Autoayuda</option>
                       <option value="Nacional" <?php echo (isset($txtCat) && $txtCat == 'Nacional') ? 'selected' : ''; ?>>Nacional</option>
                    <option value="Otros" <?php echo (isset($txtCat) && $txtCat == 'Otros') ? 'selected' : ''; ?>>Otros</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="txtIMG" class="form-label">
                    <i class="fas fa-image me-1"></i>Portada
                  </label>
                  <?php if ($txtIMG != ""): ?>
                    <div class="mb-2">
                      <img src="../../imagenes/lib<?php echo htmlspecialchars($txtIMG); ?>" 
                           class="img-thumbnail" width="80" alt="Portada actual">
                    </div>
                  <?php endif; ?>
                  <input type="file" class="form-control" name="txtIMG" id="txtIMG" 
                         accept="image/*">
                  <div class="form-text">Formatos: JPG, PNG, GIF. Máx: 2MB</div>
                </div>
              </div>
            </div> 

            <div class="mb-3">
              <label for="txtDesc" class="form-label">
                <i class="fas fa-align-left me-1"></i>Descripción *
              </label>
              <textarea class="form-control" name="txtDesc" id="txtDesc" 
                        rows="3" placeholder="Descripción del libro" required><?php echo htmlspecialchars($txtDesc); ?></textarea>
            </div>

            <!-- Botones de Acción -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="submit" name="accion" value="Agregar" 
                      class="btn btn-success me-md-2 <?php echo (!empty($txtID)) ? 'disabled' : ''; ?>">
                <i class="fas fa-plus me-1"></i>Agregar
              </button>
              <button type="submit" name="accion" value="Modificar" 
                      class="btn btn-warning me-md-2">
                <i class="fas fa-edit me-1"></i>Modificar
              </button>
              <button type="submit" name="accion" value="Cancelar" 
                      class="btn btn-secondary">
                <i class="fas fa-times me-1"></i>Cancelar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Panel de Lista -->
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
          <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Lista de Libros
            <span class="badge bg-primary ms-2"><?php echo count($listaLibros); ?></span>
          </h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped">
              <thead class="table-dark">
                <tr>
                  <th width="5%">ID</th>
                  <th width="20%">Nombre</th>
                  <th width="8%">Fecha</th>
                  <th width="12%">Autor</th>
                  <th width="8%">Stock</th>
                  <th width="10%">Categoría</th>
                  <th width="20%">Descripción</th>
                  <th width="10%">Imagen</th>
                  <th width="7%">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($listaLibros)): ?>
                  <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                      <i class="fas fa-book-open fa-2x mb-3"></i>
                      <p>No hay libros registrados</p>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach($listaLibros as $libro): ?>
                    <tr>
                      <td><span class="badge bg-secondary"><?php echo $libro['id']; ?></span></td>
                      <td><strong><?php echo htmlspecialchars($libro['nombre']); ?></strong></td>
                      <td><?php echo htmlspecialchars($libro['fecha']); ?></td>
                      <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                      <td>
                        <span class="badge <?php echo ($libro['stock'] > 0) ? 'bg-success' : 'bg-danger'; ?>">
                          <?php echo $libro['stock']; ?>
                        </span>
                      </td>
                      <td>
                        <span class="badge bg-info"><?php echo htmlspecialchars($libro['categoria']); ?></span>
                      </td>
                      <td>
                        <small class="text-muted">
                          <?php echo substr(htmlspecialchars($libro['descripcion']), 0, 50); ?>
                          <?php if (strlen($libro['descripcion']) > 50): ?>...<?php endif; ?>
                        </small>
                      </td>
                      <td>
                        <?php if (!empty($libro['imagen'])): ?>
                          <img src="../../imagenes/lib<?php echo htmlspecialchars($libro['imagen']); ?>" 
                               class="img-thumbnail" width="60" alt="Portada">
                        <?php else: ?>
                          <span class="text-muted">Sin imagen</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <div class="btn-group-vertical btn-group-sm">
                          <form method="post" class="d-inline">
                            <input type="hidden" name="txtID" value="<?php echo $libro['id']; ?>">
                            <button type="submit" name="accion" value="Seleccionar" 
                                    class="btn btn-outline-primary btn-sm mb-1" title="Seleccionar">
                              <i class="fas fa-edit"></i>
                            </button>
                            <button type="submit" name="accion" value="Borrar" 
                                    class="btn btn-outline-danger btn-sm" 
                                    onclick="return confirm('¿Estás seguro de eliminar este libro?')" title="Eliminar">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.card {
  border: none;
  border-radius: 10px;
}
.card-header {
  border-radius: 10px 10px 0 0 !important;
}
.form-label {
  font-weight: 500;
  color: #495057;
}
.table th {
  border-top: none;
  font-weight: 600;
}
.btn {
  border-radius: 6px;
}
.img-thumbnail {
  border-radius: 8px;
}
</style>

<?php include("pie.php"); ?>
  
</body>
</html>