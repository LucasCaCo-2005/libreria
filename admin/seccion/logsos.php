<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtApellido = (isset($_POST['txtApellido'])) ? $_POST['txtApellido'] : "";
$txtCedula = (isset($_POST['txtCedula'])) ? $_POST['txtCedula'] : "";
$txtDomicilio = (isset($_POST['txtDomicilio'])) ? $_POST['txtDomicilio'] : "";
$txtTelefono = (isset($_POST['txtTelefono'])) ? $_POST['txtTelefono'] : "";
$txtCorreo = (isset($_POST['txtCorreo'])) ? $_POST['txtCorreo'] : "";
$txtContraseña = (isset($_POST['txtContraseña'])) ? $_POST['txtContraseña'] : "";
$txtestado = (isset($_POST['txtestado'])) ? $_POST['txtestado'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : ""; 
$tipoPago = (isset($_POST['tipo_pago'])) ? $_POST['tipo_pago'] : "";

include("../config/bd.php");
switch($accion){
    case "Agregar":
        $sentencia = $conexion->prepare("INSERT INTO socios 
            (nombre, apellidos, cedula, domicilio, telefono, correo, contrasena, estado) 
            VALUES (:nombre, :apellidos, :cedula, :domicilio, :telefono, :correo, :contrasena, :estado)");

        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':apellidos', $txtApellido);
        $sentencia->bindParam(':cedula', $txtCedula);
        $sentencia->bindParam(':domicilio', $txtDomicilio);
        $sentencia->bindParam(':telefono', $txtTelefono);
        $sentencia->bindParam(':correo', $txtCorreo);
        $sentencia->bindParam(':contrasena', $txtContraseña);
        $sentencia->bindParam(':estado', $txtestado);
        $sentencia->execute();
        header("Location: logsos.php");
        break;

    case "Eliminar":
        $sentencia = $conexion->prepare("DELETE FROM socios WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        header("Location: logsos.php");
        break;

    case "Seleccionar":
        $sentencia = $conexion->prepare("SELECT * FROM socios WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $socio = $sentencia->fetch(PDO::FETCH_ASSOC);
        $txtNombre = $socio['nombre'];
        $txtApellido = $socio['apellidos'];
        $txtCedula = $socio['cedula'];
        $txtDomicilio = $socio['domicilio'];
        $txtTelefono = $socio['telefono'];
        $txtCorreo = $socio['correo'];
        $txtContraseña = $socio['contrasena'];
        $txtestado = $socio['estado'];
        break;

    case "Modificar": 
        $sentencia = $conexion->prepare("UPDATE socios 
            SET nombre=:nombre, 
                apellidos=:apellidos, 
                cedula=:cedula, 
                domicilio=:domicilio, 
                telefono=:telefono, 
                correo=:correo, 
                contrasena=:contrasena,
                estado=:estado
            WHERE id=:id");

        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':apellidos', $txtApellido);
        $sentencia->bindParam(':cedula', $txtCedula);
        $sentencia->bindParam(':domicilio', $txtDomicilio);
        $sentencia->bindParam(':telefono', $txtTelefono);
        $sentencia->bindParam(':correo', $txtCorreo);
        $sentencia->bindParam(':contrasena', $txtContraseña);
        $sentencia->bindParam(':estado', $txtestado);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        header("Location: logsos.php");
        break;

    case "Cancelar":
        header("Location: logsos.php");
        break;

case "Pagar":
    $mesActual = date("F Y"); 
    $fechaHoy = date("Y-m-d");

    $tipos = [
        "pago1" => 100.00,
        "pago2" => 50.00
    ];

    if(array_key_exists($tipoPago, $tipos)){
        $monto = $tipos[$tipoPago];
        $check = $conexion->prepare("SELECT COUNT(*) FROM pagos 
                                     WHERE socio_id = :socio_id 
                                     AND mes_pagado = :mes 
                                     AND tipo_pago = :tipo_pago");
        $check->bindParam(':socio_id', $txtID);
        $check->bindParam(':mes', $mesActual);
        $check->bindParam(':tipo_pago', $tipoPago);
        $check->execute();

        if($check->fetchColumn() == 0){ 
            $sentencia = $conexion->prepare("INSERT INTO pagos 
                                             (socio_id, fecha_pago, mes_pagado, tipo_pago, monto) 
                                             VALUES (:socio_id, :fecha_pago, :mes_pagado, :tipo_pago, :monto)");
            $sentencia->bindParam(':socio_id', $txtID);
            $sentencia->bindParam(':fecha_pago', $fechaHoy);
            $sentencia->bindParam(':mes_pagado', $mesActual);
            $sentencia->bindParam(':tipo_pago', $tipoPago);
            $sentencia->bindParam(':monto', $monto);
            $sentencia->execute();
        } else {
    
            echo "<script>alert('Este socio ya realizó este pago en $mesActual');</script>";
        }
    }

    header("Location: logsos.php"); 
    exit;
    break;
case "QuitarPago":
    $sentencia = $conexion->prepare("DELETE FROM pagos WHERE id=:id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();

    header("Location: logsos.php");
    exit;
    break;
}
$filtro = "";
$parametros = [];
if (isset($_GET['filtroEstado']) && $_GET['filtroEstado'] != "") {
    $filtro = " WHERE estado = :estado ";
    $parametros[':estado'] = $_GET['filtroEstado'];
}
$sentenciaSQL = $conexion->prepare("SELECT * FROM socios $filtro");
$sentenciaSQL->execute($parametros);
$listaSocios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$filtroSeleccionado = isset($_GET['filtroEstado']) ? $_GET['filtroEstado'] : "activo";

if ($filtroSeleccionado == "inactivo") {
    $sentencia = $conexion->prepare("SELECT * FROM socios WHERE estado='inactivo'");
} else {
    $sentencia = $conexion->prepare("SELECT * FROM socios WHERE estado='activo'");
}
$sentencia->execute();
$listaSocios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
$mesActual = date("F Y");
$sentenciaPagos = $conexion->prepare("SELECT p.*, s.nombre, s.apellidos 
                                      FROM pagos p
                                      INNER JOIN socios s ON p.socio_id = s.id
                                      WHERE p.mes_pagado = :mes");
$sentenciaPagos->bindParam(':mes', $mesActual);
$sentenciaPagos->execute();
$listaPagos = $sentenciaPagos->fetchAll(PDO::FETCH_ASSOC);

$sentenciaContador = $conexion->prepare("SELECT COUNT(DISTINCT socio_id) as total FROM pagos WHERE mes_pagado = :mes");
$sentenciaContador->bindParam(':mes', $mesActual);
$sentenciaContador->execute();
$totalPagos = $sentenciaContador->fetch(PDO::FETCH_ASSOC)['total'];

$sentenciaSuma = $conexion->prepare("SELECT SUM(monto) as total_monto FROM pagos WHERE mes_pagado = :mes");
$sentenciaSuma->bindParam(':mes', $mesActual);
$sentenciaSuma->execute();
$totalMonto = $sentenciaSuma->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

$mesSeleccionado = isset($_GET['mes']) ? $_GET['mes'] : date("m");
$anioSeleccionado = isset($_GET['anio']) ? $_GET['anio'] : date("Y");

$mesFormateado = date("F", mktime(0, 0, 0, $mesSeleccionado, 10)) . " " . $anioSeleccionado;

$sentenciaPagos = $conexion->prepare("SELECT p.*, s.nombre, s.apellidos 
                                      FROM pagos p
                                      INNER JOIN socios s ON p.socio_id = s.id
                                      WHERE p.mes_pagado = :mes");
$sentenciaPagos->bindParam(':mes', $mesFormateado);
$sentenciaPagos->execute();
$listaPagos = $sentenciaPagos->fetchAll(PDO::FETCH_ASSOC);

$sentenciaContador = $conexion->prepare("SELECT COUNT(DISTINCT socio_id) as total 
                                         FROM pagos 
                                         WHERE mes_pagado = :mes");
$sentenciaContador->bindParam(':mes', $mesFormateado);
$sentenciaContador->execute();
$totalPagos = $sentenciaContador->fetch(PDO::FETCH_ASSOC)['total'];

$sentenciaSuma = $conexion->prepare("SELECT SUM(monto) as total_monto 
                                     FROM pagos 
                                     WHERE mes_pagado = :mes");
$sentenciaSuma->bindParam(':mes', $mesFormateado);
$sentenciaSuma->execute();
$totalMonto = $sentenciaSuma->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
?>
<?php include("../template/cabecera.php"); ?>

<h2>Registro de Socios</h2>
<form method="POST" enctype="multipart/form-data">

</form>

<div class="mb-3">
    <form hidden method="GET" style="display: inline;">
        <input type="hidden" name="filtroEstado" value="activo"  hidden>
        <button type="submit" class="btn <?php echo ($filtroSeleccionado=="activo")  ? 'btn-success' : 'btn-outline-success'; ?>">
            Activos
        </button>
    </form>
</div>
<h3>Pagos del mes: <?php echo $mesFormateado; ?></h3>

<form method="GET" class="mb-3">
    <label>Mes:</label>
    <select name="mes">
        <?php 
        $meses = [
            "01" => "Enero", "02" => "Febrero", "03" => "Marzo", 
            "04" => "Abril", "05" => "Mayo", "06" => "Junio", 
            "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", 
            "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"
        ];
        $mesSeleccionado = isset($_GET['mes']) ? $_GET['mes'] : date("m");
        foreach($meses as $num => $nombre){
            $selected = ($num == $mesSeleccionado) ? "selected" : "";
            echo "<option value='$num' $selected>$nombre</option>";
        }
        ?>
    </select>

    <label>Año:</label>
    <select name="anio">
        <?php 
        $anioActual = date("Y");
        $anioSeleccionado = isset($_GET['anio']) ? $_GET['anio'] : $anioActual;
        for($i=$anioActual; $i>=($anioActual-5); $i--){
            $selected = ($i == $anioSeleccionado) ? "selected" : "";
            echo "<option value='$i' $selected>$i</option>";
        }
        ?>
    </select>

    <button type="submit" class="btn btn-info">Filtrar</button>
</form>


<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Apellido</th><th>Cedula</th>
                <th>Domicilio</th><th>Telefono</th><th>Correo</th><th>Estado</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaSocios as $usuario){ ?>
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
                
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="txtID" value="<?php echo $usuario['id']; ?>">
                        <input type="hidden" name="tipo_pago" value="pago1">
                        <input type="submit" class="btn btn-primary" name="accion" value="Pagar">
                    </form>
             
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="txtID" value="<?php echo $usuario['id']; ?>">
                        <input type="hidden" name="tipo_pago" value="pago2">
                        <input type="submit" class="btn btn-success" name="accion" value="Pagar">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<h3>Pagos del mes: <?php echo $mesActual; ?></h3>
<p><strong>Total de socios que pagaron:</strong> <?php echo $totalPagos; ?></p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Socio</th>
            <th>Fecha de Pago</th>
            <th>Mes Pagado</th>
            <th>Tipo de Pago</th>
            <th>Monto</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listaPagos as $pago){ ?>
        <tr>
            <td><?php echo $pago['nombre']." ".$pago['apellidos']; ?></td>
            <td><?php echo $pago['fecha_pago']; ?></td>
            <td><?php echo $pago['mes_pagado']; ?></td>
            <td><?php echo ucfirst($pago['tipo_pago']); ?></td>
            <td>$<?php echo number_format($pago['monto'],2); ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="txtID" value="<?php echo $pago['id']; ?>">
                    <input type="submit" class="btn btn-danger" name="accion" value="QuitarPago">
                </form>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php include("../template/pie.php"); ?>
