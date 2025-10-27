<?php
include_once __DIR__ . "/../admin/seccion/bd.php";
include_once "Talleres.php"; // si tienes la clase Talleres definida en otro archivo

class TalleresBD extends Conexion {
public function ListarTalleres(){
    $con = $this->Conectar();
    $sql = "SELECT * FROM talleres";
    $stmt = $con->prepare($sql);
    if (!$stmt) die("Error preparando consulta: " . $con->errorInfo()[2]);

    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ListaTalleres = [];
    foreach ($resultado as $fila) {
        $taller = new Talleres();
        $taller->setId($fila['Id']);
        $taller->setNombre($fila['nombre']);
        $taller->setDia($fila['dia']);
        $taller->setHorario($fila['horario']);
        $taller->setFoto($fila['foto']);
        $taller->setDescripcion($fila['descripcion']);
        $taller->setCosto($fila['costo']);
        $taller->setEstado($fila['estado']);
        $ListaTalleres[] = $taller;
    }

    return $ListaTalleres;
}
}
?>