<?php 
include_once __DIR__ ."/../../Logica/Admin/autoridades.php";
include("cabecera.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Autoridades - Biblioteca</title>
    <link rel="stylesheet" href="../../css/admin/panelautoridades.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="admin-container">
    <div class="admin-header">
        <h1><i class="fas fa-users-cog"></i> Gestión de Autoridades</h1>
        <p>Administra la información de las autoridades</p>
    </div>

    <div class="admin-content">
        <!-- Formulario de Gestion -->
        <div class="form-section <?= !empty($txtID) ? 'form-editing' : 'form-adding' ?>">
            <div class="section-header">
                <h3>
                    <i class="fas fa-edit"></i> 
                    <?= empty($txtID) ? 'Nueva Autoridad' : 'Editando Autoridad' ?>
                    <?php if (!empty($txtID)): ?>
                        <span class="badge badge-warning">Editando ID: <?= $txtID ?></span>
                    <?php endif; ?>
                </h3>
            </div>
            
            <?php if (!empty($txtID)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                Estás editando la autoridad. Modifica los campos necesarios y haz clic en "Guardar cambios" para actualizar los datos.
            </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data" class="admin-form">
                <input type="" name="txtID" value="<?= htmlspecialchars($txtID) ?>">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="txtCedula" class="form-label" >
                            <i class="fas fa-id-card"></i> Cédula
                        </label>
                        <input type="text" id="txtCedula" name="txtCedula" 
                               value="<?= htmlspecialchars($txtCedula) ?>" 
                               class="form-control"
                               placeholder="Ingrese cédula"  >
                    </div>

                    <div class="form-group">
                        <label for="txtNombre" class="form-label">
                            <i class="fas fa-user"></i> Nombre Completo
                        </label>
                        <input type="text" id="txtNombre" name="txtNombre" 
                               value="<?= htmlspecialchars($txtNombre) ?>" 
                               class="form-control"
                               placeholder="Ingrese Nombre completo" >
                    </div>

                    <div class="form-group">
                        <label for="txtCargo" class="form-label">
                            <i class="fas fa-briefcase"></i> Cargo
                        </label>
                        <input type="text" id="txtCargo" name="txtCargo" 
                               value="<?= htmlspecialchars($txtCargo) ?>" 
                               class="form-control"
                               placeholder="Ingrese cargo" >
                    </div>

                    <div class="form-group">
                        <label for="txtFecha_inicio" class="form-label">
                            <i class="fas fa-calendar-alt"></i> Fecha de Inicio
                        </label>
                        <input type="date" id="txtFecha_inicio" name="txtFecha_inicio" 
                               value="<?= htmlspecialchars($txtFecha_inicio) ?>" 
                               class="form-control" >
                    </div>

                    <div class="form-group">
                        <label for="txtFecha_fin" class="form-label">
                            <i class="fas fa-calendar-times"></i> Fecha de Fin
                        </label>
                        <input type="date" id="txtFecha_fin" name="txtFecha_fin" 
                               value="<?= htmlspecialchars($txtFecha_fin) ?>" 
                               class="form-control" >
                    </div>

                    <div class="form-group">
                        <label for="txtEstado" class="form-label">
                            <i class="fas fa-status"></i> Estado
                        </label>
                        <select id="txtEstado" name="txtEstado" class="form-control" >
                            <option value="activo" <?= ($txtEstado == 'activo') ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= ($txtEstado == 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label for="image" class="form-label">
                            <i class="fas fa-camera"></i> Fotografía
                        </label>
                        <input type="file" id="image" name="image" 
                               class="form-control file-input"
                               accept="image/*">
                        <small class="file-help">
                            Formatos aceptados: JPG, PNG, GIF (Máx. 2MB)
                            <?php if (!empty($foto_actual)): ?>
                                <br><strong>Foto actual:</strong> <?= htmlspecialchars($foto_actual) ?>
                            <?php endif; ?>
                        </small>
                    </div>
                </div>

                <div class="form-actions">
                    <?php if (empty($txtID)): ?>
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">
                        <i class="fas fa-plus"></i> Agregar Autoridad
                    </button>
                    <?php endif; ?>
                    
                    <?php if (!empty($txtID)): ?>
                    <button type="submit" name="accion" value="Modificar" class="btn btn-warning">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <?php endif; ?>
                    
                    <button type="submit" name="accion" value="Listar" class="btn btn-info">
                        <i class="fas fa-list"></i> Listar Autoridades
                    </button>
                    
                    <button type="submit" name="accion" value="Cancelar" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Autoridades -->
        <?php if (!empty($listaAutoridades)): ?>
        <div class="table-section">
            <div class="section-header">
                <h3><i class="fas fa-list-alt"></i> Lista de Autoridades</h3>
                <span class="badge badge-count"><?= count($listaAutoridades) ?> registros</span>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Foto</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaAutoridades as $autoridad): ?>
                        <tr>
                            <td class="text-center">#<?= $autoridad['id'] ?></td>
                            <td><?= htmlspecialchars($autoridad['cedula']) ?></td>
                            <td class="Nombre-cell"><?= htmlspecialchars($autoridad['Nombre']) ?></td>
                            <td><?= htmlspecialchars($autoridad['cargo']) ?></td>
                            <td><?= htmlspecialchars($autoridad['fecha_inicio']) ?></td>
                            <td><?= htmlspecialchars($autoridad['fecha_fin']) ?></td>
                            <td class="foto-cell">
                                <?php if (!empty($autoridad['foto'])): ?>
                                    <img src="../../imagenes/<?= htmlspecialchars($autoridad['foto']) ?>" 
                                         alt="Foto de <?= htmlspecialchars($autoridad['cargo']) ?>" 
                                         class="autoridad-foto">
                                <?php else: ?>
                                    <div class="no-photo">
                                        <i class="fas fa-user-slash"></i>
                                        <span>Sin foto</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge status-<?= htmlspecialchars($autoridad['estado']) ?>">
                                    <?= htmlspecialchars($autoridad['estado']) ?>
                                </span>
                            </td>
                            <td class="actions-cell">
                                <div class="action-form">
                                    <!-- Botón Seleccionar/Editar -->
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="txtID" value="<?= $autoridad['id'] ?>">
                                        <button type="submit" name="accion" value="Seleccionar" 
                                                class="btn-action btn-edit" title="Editar">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                    </form>
                                    
                                    <!-- Botón Eliminar -->
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="txtID" value="<?= $autoridad['id'] ?>">
                                        <button type="submit" name="accion" value="Eliminar" 
                                                class="btn-action btn-delete" title="Eliminar"
                                                onclick="return confirm('¿Está seguro de eliminar a <?= htmlspecialchars($autoridad['Nombre']) ?>?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Confirmación para acciones
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const accion = this.querySelector('[name="accion"]')?.value;
        
      
        if (accion === 'Seleccionar' || accion === 'Cancelar' || accion === 'Listar') {
            return; // Diferenciacion de acciones
        }
        
        let mensaje = '';
        switch(accion) {
            case 'Agregar':
                // Validar que los campos requeridos no estén vacíos
                const cedula = document.getElementById('txtCedula')?.value;
                const Nombre = document.getElementById('txtNombre')?.value;
                const cargo = document.getElementById('txtCargo')?.value;
                
                if (!cedula || !Nombre || !cargo) {
                    e.preventDefault();
                    alert('Por favor complete todos los campos requeridos');
                    return;
                }
                
                mensaje = '¿Está seguro de agregar esta autoridad?';
                break;
                
            case 'Modificar':
                mensaje = '¿Está seguro de modificar esta autoridad?';
                break;
                
            case 'Eliminar':
                
                return;
        }
        
        if (mensaje && !confirm(mensaje)) {
            e.preventDefault();
        }
    });
});

// Prevenir el envío del formulario cuando se hace clic en Cancelar o Listar
document.addEventListener('DOMContentLoaded', function() {
    const btnCancelar = document.querySelector('button[value="Cancelar"]');
    const btnListar = document.querySelector('button[value="Listar"]');
    
    if (btnCancelar) {
        btnCancelar.addEventListener('click', function(e) {
           
            e.preventDefault();
         
            window.location.href = window.location.pathname;
        });
    }
    
    if (btnListar) {
        btnListar.addEventListener('click', function(e) {
            // Permitir el envío normal, no necesita validación
        });
    } 
});

</script>

<?php include("pie.php"); ?>
</body>
</html>