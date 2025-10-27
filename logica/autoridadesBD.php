<?php
include_once __DIR__ . "/../admin/seccion/bd.php";
include_once __DIR__ . "/../admin/seccion/autoridades.php";


class autoridadesBD extends Conexion {

public function CargarAutoridades($cedula, $cargo, $fecha_inicio, $fecha_fin, $foto, $estado) {
    try {
        $conn = $this->Conectar(); 
        $sql = "INSERT INTO autoridades (cedula, cargo, fecha_inicio, fecha_fin, foto, estado)
                VALUES (:cedula, :cargo, :fecha_inicio, :fecha_fin, :foto, :estado)";

        $stmt = $conn->prepare($sql);


        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':cargo', $cargo);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':estado', $estado);

        $stmt->execute();

        echo "<script>alert('Autoridad agregada correctamente');</script>";

    } catch (PDOException $e) {
        echo "Error al insertar autoridad: " . $e->getMessage();
    }
}




public function ListarAutoridades(){
    $con = $this->Conectar();
    $sql = "SELECT * FROM autoridades";
    $stmt = $con->prepare($sql);
    if (!$stmt) die("Error preparando consulta: " . $con->errorInfo()[2]);

    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ListaAutoridades = [];
    foreach ($resultado as $fila) {
        $autoridad = new Autoridades();
        $autoridad->setId($fila['id']);
        $autoridad->setCedula($fila['cedula']);
        $autoridad->setCargo($fila['cargo']);
        $autoridad->setFecha_inicio($fila['fecha_inicio']);
        $autoridad->setFecha_fin($fila['fecha_fin']);
        $autoridad->setFoto($fila['foto']);
        $autoridad->setEstado($fila['estado']);
        $ListaAutoridades[] = $autoridad;
    }

    return $ListaAutoridades;
}
}
?>