<?php
include_once "admin/seccion/bd.php";
include_once "logica/personaBD.php";
class Persona {

    private $Cedula;
    private $Nombre;
    private $Apellidos;
    private $Domicilio;
    private $Telefono;
    private $Correo;
    private $Contrasena;
    private $Tipo;

    public function getCedula() {
        return $this->Cedula;
    }

    public function getContrasena() {
        return $this->Contrasena;
    }

    public function setCedula($Cedula) { $this->Cedula = $Cedula; }
    public function setNombre($Nombre) { $this->Nombre = $Nombre; }
    public function setApellidos($Apellidos) { $this->Apellidos = $Apellidos; }
    public function setDireccion($Domicilio) { $this->Domicilio = $Domicilio; }
    public function setTelefono($Telefono) { $this->Telefono = $Telefono; }
    public function setCorreo($Correo) { $this->Correo = $Correo; }
    public function setContrasena($Contrasena) { $this->Contrasena = $Contrasena; }
    public function setTipo($Tipo) { $this->Tipo = $Tipo; }

    public function CargarPersonas() { 
        // Aquí registramos a la persona
        $registro = new personaBD();
        $registro->RegistrarPersona(
            $this->Cedula,
            $this->Nombre,
            $this->Apellidos,
            $this->Domicilio,
            $this->Telefono,  
            $this->Correo,
            $this->Contrasena,
            $this->Tipo
        );
    }

     //public function Login() { 
    //    $Cedula = $this->Cedula;
     //   $Contrasena = $this->Contrasena; 

     //   $conexion = new Conexion();
     //   $conn = $conexion->Conectar();

    //    $stmt = $conn->prepare("SELECT * FROM personas WHERE cedula = ? AND contrasena = ?");
     //   if (!$stmt) {
     //       die("Error en la preparación de la consulta: " . $conn->error);
  //      }

   //    $stmt = $con->prepare("SELECT * FROM personas WHERE cedula = ? AND contrasena = ?");
//$stmt->execute([$cedula, $contrasena]);

 //       if ($row = $resultado->fetch_assoc()) {
  //          $persona = new Persona();
  //          $persona->setCedula($row['cedula']);
  //          $persona->setContrasena($row['contrasena']);
    //        $persona->setTipo($row['Tipo']);
   //         return $persona;
 //       } else {
  //          return NULL;
  //      }
 //   }

 public function login($cedula, $contrasena) {
    // Creamos la conexión usando la clase Conexion
    $conexion = new Conexion(); // instancia de la clase Conexion
    $con = $conexion->Conectar(); // método que devuelve el PDO

    // Preparar la consulta
    $sql = "SELECT * FROM personas WHERE cedula = :cedula AND contrasena = :contrasena";
    $stmt = $con->prepare($sql);

    // Usar los parámetros correctos
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':contrasena', $contrasena);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve la fila encontrada o false
}
}