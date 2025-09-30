<?php
include_once "persona.php"; 
include_once "../datos/conexion.php";
Class Talleres {
    private $idTaller;
    private $nombre;
    private $dia;
    private $horario;
    private $foto;

    // ID
    public function setid($idTaller){
        $this->idTaller = $idTaller;
    }
    public function getid(){
        return $this->idTaller;
    }

    // Nombre
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function getNombre(){
        return $this->nombre;
    }

    // Dia
    public function setDia($dia){
        $this->dia = $dia;
    } 
    public function getDia(){
        return $this->dia;
    }

        // Horario
    public function setHorario($horario){
        $this->horario = $horario;
    } 
    public function getHorario(){
        return $this->horario;
    }

    // Foto
    public function setFoto($foto){
        $this->foto = $foto;
    }
    public function getfoto(){
        return $this->foto;
    }

    public function ListarTalleres(){
        include_once "datos/talleresBD.php";
        $talleresBD = new TalleresBD();
        return $talleresBD->ListarTalleres();
    }
       public function CargarTalleres(){
        include_once "../datos/talleresBD.php";
        $talleresBD = new talleresBD();
        return $talleresBD->CargarTalleres($this->nombre,$this->dia, $this->horario, $this->foto);
    }
}
