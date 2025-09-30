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
    private $correo;
    private $pass;
    

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
        include_once '../datos/personasBd.php';
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
            $this->pass,
            $this->Tipo
        )   
        ;
    }
    public function Login() {
    $ci = $this->Ci;
    $pass = $this->Pass;

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
        include_once "./datos/personasBd.php";
        $personaBD = new personasBd(); 
        return $personaBD->BuscarPersona($this->Ci); 
    }
}