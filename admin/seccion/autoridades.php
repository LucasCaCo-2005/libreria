<?php

// include_once "persona.php"; 
include_once ("persona.php");
include_once ("bd.php");
include_once __DIR__ . "/../../logica/autoridadesBD.php";

class Autoridades extends Conexion  {
    private $id;
    private $cedula;
    private $cargo;
    private $fecha_inicio;
    private $fecha_fin;
    private $foto;
    private $estado;

    // ID
    public function setId($id){ $this->id = $id; }
    public function getId(){ return $this->id; }

    // cedula
    public function setCedula($cedula){ $this->cedula = $cedula; }
    public function getCedula(){ return $this->cedula; }

        // cargo
    public function setCargo($cargo){ $this->cargo = $cargo; }
    public function getCargo(){ return $this->cargo; }

    // Fecha Inicio
    public function setFecha_inicio($fecha_inicio){ $this->fecha_inicio = $fecha_inicio; }
    public function getFecha_inicio(){ return $this->fecha_inicio; }

    // Fecha Inicio
    public function setFecha_fin($fecha_fin){ $this->fecha_fin = $fecha_fin; }
    public function getFecha_fin(){ return $this->fecha_fin; }

    // Foto
    public function setFoto($foto){ $this->foto = $foto; }
    public function getFoto(){ return $this->foto; }

    // Estado
    public function setEstado($estado){ $this->estado = $estado; }
    public function getEstado(){ return $this->estado; }

  
    // Operaciones
    public function ListarAutoridades(){
        $autoridadesBD = new AutoridadesBD();
        return $autoridadesBD->ListarAutoridades();
    } 

    public function CargarAutoridades(){
        $autoridadesBD = new AutoridadesBD();
        return $autoridadesBD->CargarAutoridades($this->cedula, $this->cargo, $this->fecha_inicio, $this->fecha_fin, $this->foto, $this->estado);
    }
}

?>