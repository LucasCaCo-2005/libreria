<?php
session_start();
include_once("seccion/bd.php");
include("seccion/logistica.php");

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

    unset($_SESSION['libroSeleccionado']);
}

// 3️⃣ Traer lista de libros
$listaLibros = $conexion->query("SELECT * FROM libros")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/productos.css">
    <title>Productos</title>
</head>
<body>
    

<?php include("template/cabecera.php"); ?>

<div class="admin-container">
    <div class="admin-header">
        <h1>📚 Panel de Administración - Libros</h1>
        <p>Gestiona el inventario de libros de tu biblioteca</p>
    </div>

    <?php if (!empty($txtNombre)): ?>
        <div class="alert-editing">
            <span class="alert-icon">✏️</span>
            <div class="alert-content">
                <strong>Editando libro:</strong> <?= htmlspecialchars($txtNombre); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['mensaje'])): ?>
        <div class="alert-message alert-success">
            ✅ <?= htmlspecialchars($_GET['mensaje']); ?>
        </div>
    <?php elseif (!empty($_GET['mensaje1'])): ?>
        <div class="alert-message alert-info">
            ℹ️ <?= htmlspecialchars($_GET['mensaje1']); ?>
        </div>
    <?php elseif (!empty($_GET['mensaje2'])): ?>
        <div class="alert-message alert-warning">
            ⚠️ <?= htmlspecialchars($_GET['mensaje2']); ?>
        </div>
    <?php elseif (!empty($_GET['mensaje3'])): ?>
        <div class="alert-message alert-danger">
            ❌ <?= htmlspecialchars($_GET['mensaje3']); ?>
        </div>
    <?php endif; ?>

    <div class="admin-content">
        <div class="form-section">
            <div class="form-card">
                <div class="card-header">
                    <h2><?= empty($txtID) ? '➕ Agregar Nuevo Libro' : '✏️ Editar Libro'; ?></h2>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" class="libro-form">
                        <input type="hidden" name="txtID" value="<?= $txtID; ?>">

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="txtNombre" class="form-label">
                                    <span class="label-icon">📖</span>
                                    Nombre del Libro
                                </label>
                                <input type="text" id="txtNombre" class="form-control" name="txtNombre" 
                                       value="<?= htmlspecialchars($txtNombre); ?>" required 
                                       placeholder="Ingrese el nombre del libro">
                            </div>

                            <div class="form-group">
                                <label for="txtAutor" class="form-label">
                                    <span class="label-icon">👤</span>
                                    Autor
                                </label>
                                <input type="text" id="txtAutor" class="form-control" name="txtAutor" 
                                       value="<?= htmlspecialchars($txtAutor); ?>" required 
                                       placeholder="Nombre del autor">
                            </div>

                            <div class="form-group">
                                <label for="txtfecha" class="form-label">
                                    <span class="label-icon">📅</span>
                                    Fecha de Publicación
                                </label>
                                <input type="text" id="txtfecha" class="form-control" name="txtfecha" 
                                       value="<?= htmlspecialchars($txtfecha); ?>" required 
                                       placeholder="Año de publicación">
                            </div>

                            <div class="form-group">
                                <label for="txtStock" class="form-label">
                                    <span class="label-icon">📦</span>
                                    Stock Disponible
                                </label>
                                <input type="number" id="txtStock" class="form-control" name="txtStock" 
                                       value="<?= htmlspecialchars($txtStock); ?>" required 
                                       placeholder="Cantidad en stock" min="0">
                            </div>

                            <div class="form-group">
                                <label for="txtCat" class="form-label">
                                    <span class="label-icon">🏷️</span>
                                    Categoría
                                </label>
                                <select id="txtCat" class="form-control" name="txtCat" required>
                                    <option value="" disabled <?= empty($txtCat) ? 'selected' : ''; ?>>Seleccione una categoría</option>
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

                            <div class="form-group full-width">
                                <label for="txtDesc" class="form-label">
                                    <span class="label-icon">📝</span>
                                    Descripción
                                </label>
                                <textarea id="txtDesc" class="form-control" name="txtDesc" required 
                                          placeholder="Descripción del libro" rows="3"><?= htmlspecialchars($txtDesc); ?></textarea>
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label">
                                    <span class="label-icon">🖼️</span>
                                    Imagen del Libro
                                </label>
                                <div class="image-upload-container">
                                    <?php if ($txtIMG != ""): ?>
                                        <div class="current-image">
                                            <img src="../../images/<?= $txtIMG; ?>" alt="Imagen actual" class="book-image">
                                            <span class="image-label">Imagen actual</span>
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="file-input" name="txtIMG" accept="image/*">
                                    <small class="file-help">Formatos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="accion" value="Agregar" 
                                    class="btn btn-success" <?= !empty($txtID) ? 'disabled' : ''; ?>>
                                <span class="btn-icon">➕</span>
                                Agregar Libro
                            </button>
                            <button type="submit" name="accion" value="Modificar" class="btn btn-warning">
                                <span class="btn-icon">✏️</span>
                                Modificar
                            </button>
                            <button type="submit" name="accion" value="Cancelar" class="btn btn-secondary">
                                <span class="btn-icon">↩️</span>
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-section">
            <div class="table-card">
                <div class="card-header">
                    <h2>📋 Lista de Libros (<?= count($listaLibros); ?>)</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="books-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Autor</th>
                                    <th>Fecha</th>
                                    <th>Stock</th>
                                    <th>Categoría</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($listaLibros)): ?>
                                    <tr>
                                        <td colspan="9" class="no-data">
                                            <div class="no-data-content">
                                                <span class="no-data-icon">📚</span>
                                                <p>No hay libros registrados</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($listaLibros as $libro): ?>
                                        <tr>
                                            <td class="book-id">#<?= $libro['id']; ?></td>
                                            <td class="book-name"><?= htmlspecialchars($libro['nombre']); ?></td>
                                            <td class="book-author"><?= htmlspecialchars($libro['autor']); ?></td>
                                            <td class="book-date"><?= htmlspecialchars($libro['fecha']); ?></td>
                                            <td class="book-stock">
                                                <span class="stock-badge <?= $libro['stock'] > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                                                    <?= $libro['stock']; ?>
                                                </span>
                                            </td>
                                            <td class="book-category">
                                                <span class="category-tag"><?= htmlspecialchars($libro['categoria']); ?></span>
                                            </td>
                                            <td class="book-desc">
                                                <?= htmlspecialchars(substr($libro['descripcion'], 0, 50) . '...'); ?>
                                            </td>
                                            <td class="book-image-cell">
                                                <img src="../../images/<?= $libro['imagen']; ?>" 
                                                     alt="<?= htmlspecialchars($libro['nombre']); ?>" 
                                                     class="book-thumbnail">
                                            </td>
                                            <td class="book-actions">
                                                <form method="post" class="action-form">
                                                    <input type="hidden" name="txtID" value="<?= $libro['id']; ?>">
                                                    <button type="submit" name="accion" value="Seleccionar" 
                                                            class="btn-action btn-select" title="Seleccionar libro">
                                                        👁️
                                                    </button>
                                                    <button type="submit" name="accion" value="Borrar" 
                                                            class="btn-action btn-delete" title="Eliminar libro"
                                                            onclick="return confirm('¿Está seguro de eliminar este libro?')">
                                                        🗑️
                                                    </button>
                                                </form>
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

</body>
</html>

<?php include("template/pie.php"); ?>

