<?php 
include("seccion/users.php"); 
include("template/cabecera.php"); 
include_once ("seccion/bd.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Socios - Biblioteca</title>
    <link rel="stylesheet" href="./css/socios.css">

</head>
<body>

<div class="socios-container">
    <div class="socios-header">
        <h1>👥 Registro de Socios</h1>
        <p>Gestiona los socios de la biblioteca</p>
    </div>

    <div class="socios-content">
   
        <div class="form-section">
            <div class="form-header">
                <h2><?php echo empty($txtID) ? '➕ Registrar Nuevo Socio' : '✏️ Editar Socio'; ?></h2>
            </div>
            <div class="form-body">
                <form method="POST" enctype="multipart/form-data" class="socio-form">
                    <input type="hidden" name="txtID" value="<?php echo $txtID; ?>">

                    <div class="form-grid">
<div class="form-group">
                            <label for="txtsocio" class="form-label">
                                <span class="label-icon">👤</span>
                                Numero de socio
                            </label>
                            <input type="text" class="form-control" name="txtsocio" id="txtsocio" 
                                   value="<?php echo htmlspecialchars($txtsocio); ?>"
                                   placeholder="Ingrese Numero de socio" required>
                        </div>




                        <div class="form-group">
                            <label for="txtNombre" class="form-label">
                                <span class="label-icon">👤</span>
                                Nombre
                            </label>
                            <input type="text" class="form-control" name="txtNombre" id="txtNombre" 
                                   value="<?php echo htmlspecialchars($txtNombre); ?>"
                                   placeholder="Ingrese nombre" required>
                        </div>

                        <div class="form-group">
                            <label for="txtApellido" class="form-label">
                                <span class="label-icon">📝</span>
                                Apellidos
                            </label>
                            <input type="text" class="form-control" name="txtApellido" id="txtApellido" 
                                   value="<?php echo htmlspecialchars($txtApellido); ?>"
                                   placeholder="Ingrese apellidos" required>
                        </div>

                         <div class="form-group">
                            <label for="txtTelefono" class="form-label">
                                <span class="label-icon">📞</span>
                                Teléfono
                            </label>
                            <input type="text" class="form-control" name="txtTelefono" id="txtTelefono" 
                                   value="<?php echo htmlspecialchars($txtTelefono); ?>"
                                   placeholder="xx-xxx-xxx" 
                                   pattern="^[1-9]{2,3}\-[0-9]{3}\-[0-9]{3}$"
                                   title="Debe tener 8 o 9 dígitos numéricos">
                            <div class="form-help">Formato: xx-xxx-xxx</div>
                        </div>


                        <div class="form-group full-width">
                            <label for="txtCedula" class="form-label">
                                <span class="label-icon">🆔</span>
                                Cédula
                            </label>
                            <input type="text" class="form-control" name="txtCedula" id="txtCedula" 
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
                            <input type="text" class="form-control" name="txtDomicilio" id="txtDomicilio"
                                   value="<?php echo htmlspecialchars($txtDomicilio); ?>"
                                   placeholder="Ingrese domicilio completo">
                        </div>

                      
                        <div class="form-group">
                            <label for="txtCorreo" class="form-label">
                                <span class="label-icon">📧</span>
                                Correo
                            </label>
                            <input type="email" class="form-control" name="txtCorreo" id="txtCorreo"
                                   value="<?php echo htmlspecialchars($txtCorreo); ?>" 
                                   placeholder="correo@ejemplo.com" >
                        </div>

                           <div class="form-group">
                            <label for="txtcon" class="form-label">
                                <span class="label-icon">📝</span>
                                Contraseña
                            </label>
                            <input type="text" class="form-control" name="txtcon" id="txtcon" 
                                   value="<?php echo htmlspecialchars($txtcon); ?>"
                                   placeholder="Ingrese apellidos" >
                        </div>


                        <div class="form-group full-width">
                            <div class="estado-container">
                                <div class="estado-label">
                                    <span class="label-icon">⚡</span>
                                    Estado del Socio
                                </div>
                                <select name="txtestado" id="txtestado" class="estado-select" required>
                                    <option value="" disabled>Seleccione estado</option>
                                    <option value="activo" <?php if($txtestado == 'activo') echo 'selected'; ?>>🟢 Activo</option>
                                    <option value="inactivo" <?php if($txtestado == 'inactivo') echo 'selected'; ?>>🔴 Inactivo</option>
                                    <option value="pendiente" <?php if($txtestado == 'pendiente') echo 'selected'; ?>>🟡 Pendiente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="accion" value="Agregar" 
                                class="btn btn-success" <?php echo (!empty($txtID)) ? 'disabled' : ''; ?>>
                            <span class="btn-icon">➕</span>
                            Agregar Socio
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

    
        <div class="table-section">
            <div class="form-header">
                <h2>📋 Lista de Socios (<?php echo count($listaSocios); ?>)</h2>
            </div>
            
            <div class="filtros-container">
                <div class="filtros-header">
                    <span class="label-icon">🔍</span>
                    Filtrar por Estado:
                </div>
                <div class="filtros-botones">
                    <form method="GET" style="display: inline;">
                        <input type="hidden" name="filtroEstado" value="activo">
                        <button type="submit" class="btn-filtro <?php echo (isset($_GET['filtroEstado']) && $_GET['filtroEstado']=="activo") ? 'btn-filtro-activo' : ''; ?>">
                            ✅ Socios Activos
                        </button>
                    </form>

                    <form method="GET" style="display: inline;">
                        <input type="hidden" name="filtroEstado" value="inactivo">
                        <button type="submit" class="btn-filtro <?php echo (isset($_GET['filtroEstado']) && $_GET['filtroEstado']=="inactivo") ? 'btn-filtro-inactivo' : ''; ?>">
                            ⚠️ Socios Inactivos
                        </button>
                    </form>

                     <form method="GET" style="display: inline;">
                        <input type="hidden" name="filtroEstado" value="pendiente">
                        <button type="submit" class="btn-filtro <?php echo (isset($_GET['filtroEstado']) && $_GET['filtroEstado']=="pendiente") ? 'btn-filtro-pendiente' : ''; ?>">
                            🙈 Socios Pendientes
                        </button>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="socios-table">
                    <thead>
                        <tr>
                            <th>Nro de Socio</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cédula</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Contraseña</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($listaSocios)): ?>
                            <tr>
                                <td colspan="7" class="no-data">
                                    <div class="no-data-content">
                                        <span class="no-data-icon">👥</span>
                                        <p>No hay socios registrados</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($listaSocios as $usuario): ?>
                            <tr>
                               <td><?php echo htmlspecialchars($usuario['socio']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['cedula']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['contrasena']); ?></td>
                                <td>
                                  <span class="estado-badge estado-<?php echo $usuario['estado']; ?>">
    <?php
    echo ($usuario['estado'] == 'activo') ? '🟢 Activo' :
         (($usuario['estado'] == 'inactivo') ? '🔴 Inactivo' :
         (($usuario['estado'] == 'pendiente') ? '🟡 Pendiente' : '⚪ Desconocido'));
    ?>
</span>

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

<?php include("../template/pie.php"); ?>
</body>
</html>