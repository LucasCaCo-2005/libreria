<?php 
include(__DIR__ ."/../../Logica/Admin/Trabajador.php"); 
include("cabecera.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Trabajadores - Biblioteca</title>
<<<<<<<< HEAD:presentacion/admin/Trab.php
    <link rel="stylesheet" href="../../css/admin/trab.css">
========
    <link rel="stylesheet" href="../css/Admin/trab.css">
>>>>>>>> 72a969d9b84989c8325ef25b7bf44b91d1c94b1a:Presentacion/Admin/Trab.php
    <style>
      
    </style>
</head>
<body>

<div class="trabajadores-container">
    <div class="trabajadores-header">
        <h1>👥 Gestión de Trabajadores</h1>
        <p>Administra el personal de la biblioteca</p>
    </div>

    <!-- Sistema de mensajes -->
    <?php if (!empty($mostrarMensaje)): 
        list($tipo, $mensaje) = explode('|', $mostrarMensaje, 2);
    ?>
    <div class="alert-message alert-<?= $tipo ?>">
        <?php if ($tipo == 'success'): ?>
            <span class="alert-icon">✅</span>
        <?php elseif ($tipo == 'error'): ?>
            <span class="alert-icon">❌</span>
        <?php elseif ($tipo == 'info'): ?>
            <span class="alert-icon">ℹ️</span>
        <?php endif; ?>
        <span class="alert-text"><?= htmlspecialchars($mensaje) ?></span>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">×</button> 
        <!-- Oculta con JS-->
    </div>
    <?php endif; ?>
    <div class="trabajadores-content">
       
        <div class="form-section">
            <div class="form-header"> <!--Titulo COntextual-->
                <h2><?php echo empty($txtID) ? '➕ Registrar Nuevo Trabajador' : '✏️ Editar Trabajador'; ?></h2>
            </div>
            <div class="form-body">
                <form method="POST" enctype="multipart/form-data" class="trabajador-form">
                    <input type="" name="txtID" value="<?php echo $txtID; ?>">

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="txtNombre" class="form-label">
                                <span class="label-icon">👤</span>
                                Nombre Completo
                            </label>
                            <input type="text" id="txtNombre" class="form-control" name="txtNombre" 
                                   value="<?php echo htmlspecialchars($txtNombre); ?>"
                                   placeholder="Ingrese nombre y apellido" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="txtCedula" class="form-label">
                                <span class="label-icon">🆔</span>
                                Cédula
                            </label>
                            <input type="text" id="txtCedula" class="form-control" name="txtCedula" 
                                   value="<?php echo htmlspecialchars($txtCedula); ?>"
                                   placeholder="x.xxx.xxx-x" 
                                   pattern="^[1-9]\.[0-9]{3}\.[0-9]{3}-[0-9X]$" 
                                   title="Formato válido: x.xxx.xxx-x" required>
                            <div class="form-help">Formato: x.xxx.xxx-x</div>
                        </div>

                        <div class="form-group full-width">
                            <label for="txtDomicilio" class="form-label">
                                <span class="label-icon">🏠</span>
                                Domicilio
                            </label>
                            <input type="text" id="txtDomicilio" class="form-control" name="txtDomicilio"
                                   value="<?php echo htmlspecialchars($txtDomicilio); ?>"
                                   placeholder="Ingrese domicilio completo">
                        </div>

                        <div class="form-group">
                            <label for="txtTelefono" class="form-label">
                                <span class="label-icon">📞</span>
                                Teléfono
                            </label>
                            <input type="text" id="txtTelefono" class="form-control" name="txtTelefono" 
                                   value="<?php echo htmlspecialchars($txtTelefono); ?>"
                                   placeholder="xx-xxx-xxx" 
                                   pattern="^[1-9]{2,3}\-[0-9]{3}\-[0-9]{3}$"
                                   title="Debe tener 8 o 9 dígitos numéricos">
                            <div class="form-help">Formato: xx-xxx-xxx</div>
                        </div>

                        <div class="form-group">
                            <div class="select-group">
                                <div class="select-label">
                                    <span class="label-icon">⚡</span>
                                    Estado
                                </div>
                                <select name="txtestado" id="txtestado" class="select-control" required>
                                    <option value="" disabled>Seleccione estado</option>
                                    <option value="activo" <?php if($txtestado == 'activo') echo 'selected'; ?>>🟢 Activo</option>
                                    <option value="inactivo" <?php if($txtestado == 'inactivo') echo 'selected'; ?>>🔴 Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="select-group">
                                <div class="select-label">
                                    <span class="label-icon">💼</span>
                                    Puesto
                                </div>
                                <select name="txtpuesto" id="txtpuesto" class="select-control" required>
                                    <option value="" disabled>Seleccione puesto</option>
                                    <option value="Secretario" <?php if($txtpuesto == 'Secretario') echo 'selected'; ?>>📋 Secretario</option>
                                    <option value="Medico" <?php if($txtpuesto == 'Medico') echo 'selected'; ?>>👨‍⚕️ Médico</option>
                                    <option value="Podologo" <?php if($txtpuesto == 'Podologo') echo 'selected'; ?>>🦶 Podólogo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="accion" value="Agregar" 
                                class="btn btn-success" <?php echo (!empty($txtID)) ? 'disabled' : ''; ?>>
                            <span class="btn-icon">➕</span>
                            Agregar Trabajador
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

        <!-- Lista de Trabajadores -->
        <div class="table-section">
            <div class="form-header">
                <h2>📋 Lista de Trabajadores (<?php echo count($listaTrabajadores); ?>)</h2>
            </div>
            <div class="table-responsive">
                <table class="trabajadores-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Cédula</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Puesto</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody> <!--  Lista de trabajadores con datos vacios-->
                        <?php if (empty($listaTrabajadores)): ?>
                            <tr>
                                <td colspan="7" class="no-data">
                                    <div class="no-data-content">
                                        <span class="no-data-icon">👥</span>
                                        <p>No hay trabajadores registrados</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($listaTrabajadores as $Trabajador): ?>
                            <tr>
                                <td class="trabajador-id">#<?php echo $Trabajador['id']; ?></td>
                                <td><?php echo htmlspecialchars($Trabajador['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($Trabajador['cedula']); ?></td>
                                <td><?php echo htmlspecialchars($Trabajador['telefono']); ?></td>
                                <td>
                                    <span class="estado-badge estado-<?php echo $Trabajador['estado']; ?>">
                                        <?php echo $Trabajador['estado'] == 'activo' ? '🟢 Activo' : '🔴 Inactivo'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="puesto-badge puesto-<?php echo strtolower($Trabajador['puesto']); ?>">
                                        <?php 
                                        $iconosPuestos = [
                                            'Secretario' => '📋',
                                            'Medico' => '👨‍⚕️',
                                            'Podologo' => '🦶'
                                        ];
                                        echo ($iconosPuestos[$Trabajador['puesto']] ?? '💼') . ' ' . $Trabajador['puesto'];
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="txtID" value="<?php echo $Trabajador['id']; ?>">
                                        <button type="submit" name="accion" value="Seleccionar" class="btn-seleccionar">
                                            👁️ Seleccionar
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

<script>
// Validación en tiempo real para cedula
document.getElementById('txtCedula').addEventListener('input', function(e) {
    const cedula = e.target.value;
    const pattern = /^[1-9]\.[0-9]{3}\.[0-9]{3}-[0-9X]$/;
    
    if (cedula && !pattern.test(cedula)) {
        this.style.borderColor = '#dc3545';
    } else {
        this.style.borderColor = '#28a745';
    }
});

// Validación en tiempo real para teléfono
document.getElementById('txtTelefono').addEventListener('input', function(e) {
    const telefono = e.target.value;
    const pattern = /^[1-9]{2,3}\-[0-9]{3}\-[0-9]{3}$/;
    
    if (telefono && !pattern.test(telefono)) {
        this.style.borderColor = '#dc3545';
    } else {
        this.style.borderColor = '#28a745';
    }
});

// Sistema de Confirmaciones
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const accion = this.querySelector('[name="accion"]')?.value;
        
        // NO hacer validación para estas acciones
        if (accion === 'Seleccionar' || accion === 'Cancelar') {
            return; // Permitir el envío normal sin confirmación
        }
        
        let mensaje = '';
        switch(accion) {
            case 'Agregar':
                // Validar que los campos requeridos no estén vacíos
                const nombre = document.getElementById('txtNombre')?.value;
                const cedula = document.getElementById('txtCedula')?.value;
                const puesto = document.getElementById('txtpuesto')?.value;
                
                if (!nombre || !cedula || !puesto) {
                    e.preventDefault();
                    // Mostrar mensaje de error (será manejado por PHP)
                    return;
                }
                
                mensaje = '¿Está seguro de agregar este trabajador?';
                break;
                
            case 'Modificar':
                mensaje = '¿Está seguro de modificar este trabajador?';
                break;
        }
          case 'Cancelar':
               
                break;
        }
        
        if (mensaje && !confirm(mensaje)) {
            e.preventDefault();
        }
    });
});

// Auto-ocultar mensajes después de 5 segundos
document.addEventListener('DOMContentLoaded', function() {
    const alertMessages = document.querySelectorAll('.alert-message');
    alertMessages.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
</script>

<?php include("pie.php"); ?>
</body>
</html>