
<?php
include_once "bd.php";
// Maneja las operaciones de base de datos para los avisos, hereda conexion a la bd
class AvisosBD extends Conexion {

  // Obtiene todos los talleres de la base de datos
    public function ListarAvisos(){
 
          // Establecer conexión con la base de datos
        $con = $this->Conectar();
         // Consulta SQL para obtener todos los talleres
        $sql = "SELECT * FROM avisos";
        $stmt = $con->prepare($sql);
        //// Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) die("Error preparando consulta: " . $con->errorInfo()[2]);

        // Ejecutar la consulta
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Obtener todos los resultados como array asociativo

        // Array para almacenar los objetos Avisos
        $ListaTalleres = [];
        foreach ($resultado as $fila) { // // Recorrer cada fila del resultado y crear objetos Avisos
            // Establecer las propiedades del  con los Avisos con los datos de la BD
            $avisos = new Avisos();
            $avisos->setId($fila['id']);
            $avisos->setTitulo($fila['titulo']);
            $avisos->setContenido($fila['contenido']);
            $avisos->setActivo($fila['activo']);
            $avisos->setFecha_creacion($fila['fecha_creacion']);
       
            // Agregar el taller al array de resultados
            $ListaAvisos[] = $avisos;
        }

        return $ListaAvisos;
    }

 // Inserta un nuevo taller en la base de datos
    public function CargarAvisos($titulo, $contenido, $activo, $fecha_creacion){
         // Establecer conexión con la base de datos
        $con = $this->Conectar();
        // Consulta SQL para insertar nuevo Aviso
        $sql = "INSERT INTO avisos (titulo, contenido, activo, fecha_creacion)
                VALUES (:titulo, :contenido, :activo, :fecha_creacion)";
               
        $stmt = $con->prepare($sql);
        // Vincular parámetros para prevenir inyección SQL
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':contenido', $contenido);
        $stmt->bindParam(':activo', $activo);
        $stmt->bindParam(':fecha_creacion', $fecha_creacion);
   
        // Ejecutar la consulta y verificar resultado
        if ($stmt->execute()) {
            echo "<script>alert('Aviso agregado correctamente');</script>";
            return true;
        } else {
            echo "<script>alert('Error al agregar el Aviso');</script>";
            return false;
        }
    }
}