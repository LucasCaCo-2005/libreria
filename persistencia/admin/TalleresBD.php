
<?php
include_once "bd.php";
// Maneja las operaciones de base de datos para los talleres, hereda conexion a la bd
class TalleresBD extends Conexion {

  // Obtiene todos los talleres de la base de datos
    public function ListarTalleres(){
 
          // Establecer conexión con la base de datos
        $con = $this->Conectar();
         // Consulta SQL para obtener todos los talleres
        $sql = "SELECT * FROM talleres";
        $stmt = $con->prepare($sql);
        //// Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) die("Error preparando consulta: " . $con->errorInfo()[2]);

        // Ejecutar la consulta
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Obtener todos los resultados como array asociativo

        // Array para almacenar los objetos Talleres
        $ListaTalleres = [];
        foreach ($resultado as $fila) { // // Recorrer cada fila del resultado y crear objetos Talleres
            // Establecer las propiedades del taller con los datos de la BD
            $taller = new Talleres();
            $taller->setId($fila['Id']);
            $taller->setNombre($fila['nombre']);
            $taller->setDia($fila['dia']);
            $taller->setHorario($fila['horario']);
            $taller->setFoto($fila['foto']);
            $taller->setDescripcion($fila['descripcion']);
            $taller->setCosto($fila['costo']);
            $taller->setEstado($fila['estado']);
            // Agregar el taller al array de resultados
            $ListaTalleres[] = $taller;
        }

        return $ListaTalleres;
    }

 // Inserta un nuevo taller en la base de datos
    public function CargarTalleres($nombre, $dia, $horario, $foto, $idTaller, $descripcion, $costo, $estado){
         // Establecer conexión con la base de datos
        $con = $this->Conectar();
        // Consulta SQL para insertar nuevo taller
        $sql = "INSERT INTO talleres (nombre, dia, horario, foto, descripcion, costo, estado)
                VALUES (:nombre, :dia, :horario, :foto, :descripcion, :costo, :estado)";
               
        $stmt = $con->prepare($sql);
        // Vincular parámetros para prevenir inyección SQL
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':dia', $dia);
        $stmt->bindParam(':horario', $horario);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':estado', $estado);

        // Ejecutar la consulta y verificar resultado
        if ($stmt->execute()) {
            echo "<script>alert('Taller agregado correctamente');</script>";
            return true;
        } else {
            echo "<script>alert('Error al agregar taller');</script>";
            return false;
        }
    }
}