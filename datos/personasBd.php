<?php
include_once "conexion.php";


class personasBD extends Conexion {
    public function RegistrarPersona($ci, $PrimerNombre, $SegundoNombre, $PrimerApellido, $SegundoApellido, $Calle, $Numero, $Celular, $TelefonoFijo, $Correo, $Pass, $Tipo) {
        $con = $this->Conectar();

        $stmt = $con->prepare("INSERT INTO personas (ci, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, Calle, Numero, Celular, TelefonoFijo, Correo, Pass, Tipo)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            echo "Error al preparar la consulta: " . $con->error;
            return;
        }

        $stmt->bind_param("ssssssssssss", $ci, $PrimerNombre, $SegundoNombre, $PrimerApellido, $SegundoApellido, $Calle, $Numero, $Celular, $TelefonoFijo, $Correo, $Pass, $Tipo);

        if ($stmt->execute()) {
            echo "✅ Usuario registrado correctamente.";
        } else {
            echo "❌ Error al registrar usuario: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
    }


public function BuscarUsuarioPorCI($ci, $pass) {
    $con = $this->Conectar();
    $stmt = $con->prepare("SELECT * FROM personas WHERE Ci = ? AND Pass =?");
    $stmt->bind_param("ss", $Ci, $Pass);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    $stmt->close();
    $con->close();

    return $personas ?: null;
}
public function BuscarUsuario($Ci) {
    $con = $this->Conectar();

    $stmt = $con->prepare("SELECT * FROM personas WHERE Ci = ?");
    $stmt->bind_param("s", $Ci);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $persona = [];

    while ($fila = $resultado->fetch_assoc()) {
        $persona = new Persona();
        $persona->setPrimerNombre($fila['Primernombre']);
        $persona->setCi($fila['Ci']);
        $persona->setCorreo($fila['Correo']);
        $persona->setTelefonoFijo($fila['TelefonoFijo']);
        $persona[] = $persona;
    }

    $stmt->close();
    $con->close();

    return $persona;
}



}
?>