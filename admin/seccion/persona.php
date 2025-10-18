<?php


 //include_once '/datos/conexion.php';

class Persona {
    private $Ci;
    private $PrimerNombre;
    private $SegundoNombre;
    private $PrimerApellido;
    private $SegundoApellido;
    private $Calle;
    private $Numero;
    private $Celular;
    private $TelefonoFijo;
    private $Correo;
    private $Pass;
    private $Tipo;

         public function getCI() {
        return $this->Ci;
    }
   public function getPass() {
        return $this->Pass;
    }

    public function setCi($Ci) { $this->Ci = $Ci; } 
    public function setPrimerNombre($PrimerNombre) { $this->PrimerNombre = $PrimerNombre; }
    public function setSegundoNombre($SegundoNombre) { $this->SegundoNombre = $SegundoNombre; }
    public function setPrimerApellido($PrimerApellido) { $this->PrimerApellido = $PrimerApellido; }
    public function setSegundoApellido($SegundoApellido) { $this->SegundoApellido = $SegundoApellido; }
    public function setCalle($Calle) { $this->Calle = $Calle; }
    public function setNumero($Numero) { $this->Numero = $Numero; }
    public function setCelular($Celular) { $this->Celular = $Celular; }
    public function setTelefonoFijo($TelefonoFijo) { $this->TelefonoFijo = $TelefonoFijo; }
    public function setCorreo($Correo) { $this->Correo = $Correo; }    
    public function setPass($Pass) { $this->Pass = $Pass; }
    public function setTipo($Tipo) { $this->Tipo = $Tipo; }


    public function CargarPersonas() { 
       // include_once '../datos/personasBd.php';
     
        $registro = new personasBd();
        $registro->RegistrarPersona(
            $this->Ci,
            $this->PrimerNombre,
            $this->SegundoNombre,
            $this->PrimerApellido,
            $this->SegundoApellido, 
            $this->Calle,
            $this->Numero,   
            $this->Celular,   
            $this->TelefonoFijo,  
            $this->Correo,
            $this->Pass,
            $this->Tipo
        )   
        ;
    }
    public function Login() { 
    $Ci = $this->Ci;
    $Pass = $this->Pass; 

    // Crear conexión
    $conexion = new Conexion();
    $conn = $conexion->Conectar();

    // Preparar la consulta
    $stmt = $conn->prepare("SELECT * FROM personas WHERE Ci = ? AND Pass = ?");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Asignar parámetros (ss = dos strings)
    $stmt->bind_param("ss", $ci, $pass);

    // Ejecutar
    $stmt->execute();

    // Obtener resultado
    $resultado = $stmt->get_result();

    // Verificar si hay un usuario
    if ($row = $resultado->fetch_assoc()) {
        $persona = new Persona();
        $persona->setCI($row['Ci']);
        $persona->setPass($row['Pass']);
        $persona->setTipo($row['Tipo']);
        return $persona;
    } else {
        return NULL; // Usuario no encontrado
    }
}
public function BuscarPersona(){
       // include_once "./datos/personasBd.php";
       
        $personaBD = new personasBd(); 
        return $personaBD->BuscarPersona($this->Ci); 
    }
}




// include_once "/config/bd.php";


class Conexion {
    private $nombreservidor ="localhost:3307";
    private $usuario = "root";
    private $pass = "";
    private $base = "asociacion";
    private $conexion;

    public function Conectar() {
        $this->conexion = new mysqli($this->nombreservidor, $this->usuario, $this->pass, $this->base);

        if ($this->conexion->connect_error) {
            echo "error" . $this->conexion->connect_error;
        } else {
            return $this->conexion;
        }
    }

    public function Desconectar() {
        $this->conexion->close();
    }
}




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