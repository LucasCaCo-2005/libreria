<?php
// Inicializar las variables que utilizo para recibir y guardar datos del Form.
$txtID = $txtCedula = $txtNombre = $txtCargo = $txtFecha_inicio = $txtFecha_fin = $txtEstado = "";
$foto_actual = "";
$listaAutoridades = [];

// Recuperar valores del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $txtID = $_POST['txtID'] ?? "";
    $txtCedula = $_POST['txtCedula'] ?? "";
    $txtNombre = $_POST['txtNombre'] ?? "";
    $txtCargo = $_POST['txtCargo'] ?? "";
    $txtFecha_inicio = $_POST['txtFecha_inicio'] ?? "";
    $txtFecha_fin = $_POST['txtFecha_fin'] ?? "";
    $txtEstado = $_POST['txtEstado'] ?? "activo";
    $accion = $_POST['accion'] ?? "";
} else {
    $accion = "Listar"; // Acción por defecto al cargar la página
}

// Incluir archivo de conexión
include("bd.php");
// Función para cargar imagen
function cargarImagen() {
    if (!empty($_FILES['image']['name'])) {
        $directorio = "../../Imagenes/Autoridades";
        $archivo = $directorio . basename($_FILES['image']['name']);
        $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        
        // Validar que es una imagen
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            return null;
        }
        
        // Generar Nombre único
        $NombreArchivo = uniqid() . '.' . $tipoArchivo;
        $archivoDestino = $directorio . $NombreArchivo;
        
        // Mover archivo
        if (move_uploaded_file($_FILES['image']['tmp_name'], $archivoDestino)) {
            return $NombreArchivo;
        }
    }
    return null;
}

// Procesar acciones
switch($accion) {
    case "Agregar":
        $foto = cargarImagen();
        
        $sentencia = $conexion->prepare("
            INSERT INTO autoridades (cedula, Nombre, cargo, fecha_inicio, fecha_fin, foto, estado)
            VALUES (:cedula, :Nombre, :cargo, :fecha_inicio, :fecha_fin, :foto, :estado)
        ");

        $sentencia->bindParam(':cedula', $txtCedula);
        $sentencia->bindParam(':Nombre', $txtNombre);
        $sentencia->bindParam(':cargo', $txtCargo);
        $sentencia->bindParam(':fecha_inicio', $txtFecha_inicio);
        $sentencia->bindParam(':fecha_fin', $txtFecha_fin);
        $sentencia->bindParam(':foto', $foto);
        $sentencia->bindParam(':estado', $txtEstado);
        
        if ($sentencia->execute()) {
            // Limpiar formulario después de agregar
            $txtID = $txtCedula = $txtNombre = $txtCargo = $txtFecha_inicio = $txtFecha_fin = "";
            $txtEstado = "activo";
            echo "<script>alert('Autoridad agregada correctamente');</script>";
        } else {
            echo "<script>alert('Error al agregar la autoridad');</script>";
        }
        break;

    case "Seleccionar":
        $sentencia = $conexion->prepare("SELECT * FROM autoridades WHERE id = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $autoridad = $sentencia->fetch(PDO::FETCH_ASSOC);
        
        if ($autoridad) {
            $txtCedula = $autoridad['cedula'];
            $txtNombre = $autoridad['Nombre'];
            $txtCargo = $autoridad['cargo'];
            $txtFecha_inicio = $autoridad['fecha_inicio'];
            $txtFecha_fin = $autoridad['fecha_fin'];
            $txtEstado = $autoridad['estado'];
            $foto_actual = $autoridad['foto'];
            
            echo "<script>alert('Autoridad seleccionada para edición: {$autoridad['Nombre']}');</script>";
        } else {
            echo "<script>alert('Error: No se encontró la autoridad');</script>";
        }
        break;

    case "Modificar":
        if (!empty($txtID)) {
            // Si hay nueva imagen, cargarla
            $nueva_foto = cargarImagen();
            
            if ($nueva_foto) {
                // Actualizar con nueva foto
                $sentencia = $conexion->prepare("
                    UPDATE autoridades SET
                        cedula = :cedula,
                        Nombre = :Nombre,
                        cargo = :cargo,
                        fecha_inicio = :fecha_inicio,
                        fecha_fin = :fecha_fin,
                        foto = :foto,
                        estado = :estado
                    WHERE id = :id
                ");
                $sentencia->bindParam(':foto', $nueva_foto);
            } else {
                // Mantener foto actual
                $sentencia = $conexion->prepare("
                    UPDATE autoridades SET
                        cedula = :cedula,
                        Nombre = :Nombre,
                        cargo = :cargo,
                        fecha_inicio = :fecha_inicio,
                        fecha_fin = :fecha_fin,
                        estado = :estado
                    WHERE id = :id
                ");
            }
            
            $sentencia->bindParam(':cedula', $txtCedula);
            $sentencia->bindParam(':Nombre', $txtNombre);
            $sentencia->bindParam(':cargo', $txtCargo);
            $sentencia->bindParam(':fecha_inicio', $txtFecha_inicio);
            $sentencia->bindParam(':fecha_fin', $txtFecha_fin);
            $sentencia->bindParam(':estado', $txtEstado);
            $sentencia->bindParam(':id', $txtID);
            
            if ($sentencia->execute()) {
                // Limpiar formulario después de modificar
                $txtID = $txtCedula = $txtNombre = $txtCargo = $txtFecha_inicio = $txtFecha_fin = "";
                $txtEstado = "activo";
                $foto_actual = "";
                echo "<script>alert('Autoridad modificada correctamente');</script>";
            } else {
                echo "<script>alert('Error al modificar la autoridad');</script>";
            }
        }
        break;

    case "Eliminar":
        if (!empty($txtID)) {
            $sentencia = $conexion->prepare("DELETE FROM autoridades WHERE id = :id");
            $sentencia->bindParam(':id', $txtID);
            
            if ($sentencia->execute()) {
                echo "<script>alert('Autoridad eliminada correctamente');</script>";
            } else {
                echo "<script>alert('Error al eliminar la autoridad');</script>";
            }
        }
        break;

    case "Cancelar":
        // Limpiar todo
        $txtID = $txtCedula = $txtNombre = $txtCargo = $txtFecha_inicio = $txtFecha_fin = "";
        $txtEstado = "activo";
        $foto_actual = "";
        break;

}

// Siempre listar las autoridades (excepto en redirecciones)
if ($accion !== "Agregar" && $accion !== "Modificar" && $accion !== "Eliminar") {
    $sentencia = $conexion->prepare("SELECT * FROM autoridades ORDER BY cargo, Nombre");
    $sentencia->execute();
    $listaAutoridades = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}


class AutoridadesBD extends Conexion {
    
    // Método para listar autoridades - CORREGIDO
    public function ListarAutoridades() {
        try {
            $con = $this->Conectar();
            $sql = "SELECT * FROM autoridades WHERE estado = 'activo' ORDER BY 
                    CASE WHEN LOWER(cargo) = 'presidente' THEN 1 ELSE 2 END, 
                    cargo, Nombre";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Convertir a objetos Autoridades
            $ListaAutoridades = [];
            foreach ($resultado as $fila) {
                $autoridad = new Autoridades();
                $autoridad->setId($fila['id']);
                $autoridad->setCedula($fila['cedula']);
                $autoridad->setNombre($fila['Nombre']);
                $autoridad->setCargo($fila['cargo']);
                $autoridad->setFecha_inicio($fila['fecha_inicio']);
                $autoridad->setFecha_fin($fila['fecha_fin']);
                $autoridad->setFoto($fila['foto']);
                $autoridad->setEstado($fila['estado']);
                $ListaAutoridades[] = $autoridad;
            }
            return $ListaAutoridades;
        } catch (PDOException $e) {
            error_log("Error al listar autoridades: " . $e->getMessage());
            return [];
        }
    }
}

class Autoridades extends Conexion {
    private $id;
    private $cedula;
    private $Nombre;
    private $cargo;
    private $fecha_inicio;
    private $fecha_fin;
    private $foto;
    private $estado;
    
    // Getters y Setters MEJORADOS para evitar null
    public function setId($id){ $this->id = $id; }
    public function getId(){ return $this->id ?? 0; }
    
    public function setCedula($cedula){ $this->cedula = $cedula; }
    public function getCedula(){ return $this->cedula ?? ''; }
    
    public function setNombre($Nombre){ $this->Nombre = $Nombre; }
    public function getNombre(){ return $this->Nombre ?? ''; }
    
    public function setCargo($cargo){ $this->cargo = $cargo; }
    public function getCargo(){ return $this->cargo ?? ''; }
    
    public function setFecha_inicio($fecha_inicio){ $this->fecha_inicio = $fecha_inicio; }
    public function getFecha_inicio(){ return $this->fecha_inicio ?? ''; }
    
    public function setFecha_fin($fecha_fin){ $this->fecha_fin = $fecha_fin; }
    public function getFecha_fin(){ return $this->fecha_fin ?? ''; }
    
    public function setFoto($foto){ $this->foto = $foto; }
    public function getFoto(){ return $this->foto ?? 'default-avatar.jpg'; } // Imagen por defecto
    
    public function setEstado($estado){ $this->estado = $estado; }
    public function getEstado(){ return $this->estado ?? 'inactivo'; }
}












?>