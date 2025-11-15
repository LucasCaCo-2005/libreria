<?php
//  de conexión a base de datos
 include_once "./persistencia/admin/bd.php";
 include_once "./persistencia/admin/TalleresBD.php";
//include_once __DIR__ . '/admin/seccion/Talleres.php';

// se crea una clase para gestionar los datos y operaciones relacionadas con los talleres
class Talleres {
    // // Propiedades privadas de la clase
    private $idTaller;
    private $nombre;
    private $dia;
    private $horario;
    private $foto;
    private $descripcion;
    private $costo;
    private $estado;
    // Getters y Setters
    // ID
    public function setId($idTaller){ $this->idTaller = $idTaller; }
    public function getId(){ return $this->idTaller; }

    // Nombre
    public function setNombre($nombre){ $this->nombre = $nombre; }
    public function getNombre(){ return $this->nombre; }

    // Dia
    public function setDia($dia){ $this->dia = $dia; }
    public function getDia(){ return $this->dia; }

    // Horario
    public function setHorario($horario){ $this->horario = $horario; }
    public function getHorario(){ return $this->horario; }

    // Foto
    public function setFoto($foto){ $this->foto = $foto; }
    public function getFoto(){ return $this->foto; }

    // Descripcion
    public function setDescripcion($descripcion){ $this->descripcion = $descripcion; }
    public function getDescripcion(){ return $this->descripcion; }

      //Costo

    
    public function setCosto($costo){ $this->costo = $costo; }
    public function getCosto(){ return $this->costo; }


    // Estado
    public function setEstado($estado){ $this->estado = $estado; }
    public function getEstado(){ return $this->estado; }

  
    // Operaciones
    public function ListarTalleres(){
        $talleresBD = new TalleresBD();
        return $talleresBD->ListarTalleres();
    } 
// Carga/Inserta un nuevo taller en la base de datos
    public function CargarTalleres(){
        include_once "../../persistencia/admin/TalleresBD.php";
        $talleresBD = new TalleresBD();
        return $talleresBD->CargarTalleres($this->nombre, $this->dia, $this->horario, $this->foto, $this->idTaller, $this->descripcion, $this->costo  ,$this->estado);
    }

    public function ListarTalleresAdmin(){
          include_once "../../persistencia/admin/TalleresBD.php";
        $talleresBD = new TalleresBD();
        return $talleresBD->ListarTalleres();
    } 

}

// Maneja las operaciones de base de datos para los talleres, hereda conexion a la bd


?>