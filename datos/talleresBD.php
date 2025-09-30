<?php
include_once "conexion.php";
include_once "../logica/Talleres.php";
//include_once "../Logica/usuario.php"; 

class TalleresBD extends conexion {
    public function ListarTalleres() {
        $con = $this->Conectar();
        $sql = "SELECT * FROM Talleres";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $con->error);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        $ListaTalleres = []; 

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $taller = new Talleres();
       //         $taller->setid($fila['id']);
                $taller->setNombre($fila['nombre']);
                $taller->setDia($fila['dia']);
                $taller->setHorario($fila['horario']);
                $taller->setFoto($fila['foto']);
                $ListaTalleres[] = $taller;
            }

            return $ListaTalleres;
        } else {
            return [];
        }
    }

     public function CargarTalleres($nombre, $dia, $horario, $foto) {
        $con = $this->Conectar();
      $sql = "INSERT INTO talleres (nombre, dia, horario, foto)
        VALUES (?,?,?,?)";

        $stmt = $con->prepare($sql);

       if (!$stmt) {
        die("Error preparando la consulta: " . $con->error);
    }

        $stmt->bind_param("ssss", $nombre, $dia, $horario, $foto);
      return $stmt-> execute();
       
}

}