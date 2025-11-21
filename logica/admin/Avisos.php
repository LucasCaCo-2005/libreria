
<?php
//  de conexión a base de datos
include_once __DIR__ . "/bd.php";
// se crea una clase para gestionar los datos y operaciones relacionadas con los Avisos
class Avisos {
    // // Propiedades privadas de la clase
    private $idAvisos;
    private $titulo;
    private $contenido;
    private $activo;
    private $fecha_creacion;

    // Getters y Setters
    // ID
    public function setId($idAvisos){ $this->idAvisos = $idAvisos; }
    public function getId(){ return $this->idAvisos; }

    // Nombre
    public function setTitulo($titulo){ $this->titulo = $titulo; }
    public function getTitulo(){ return $this->titulo; }

    // Dia
    public function setContenido($contenido){ $this->contenido = $contenido; }
    public function getContenido(){ return $this->contenido; }

    // Horario
    public function setActivo($activo){ $this->activo = $activo; }
    public function getActivo(){ return $this->activo; }

    // Foto
    public function setFecha_creacion($fecha_creacion){ $this->fecha_creacion = $fecha_creacion; }
    public function getFecha_creacion(){ return $this->fecha_creacion; }

  
    // Operaciones
    public function ListarAvisos(){
        $avisosBD = new AvisosBD();
        return $avisosBD->ListarAvisos();
    } 
// Carga/Inserta un nuevo Aviso en la base de datos
    public function CargarAvisos(){
        $avisosBD = new AvisosBD();
        return $avisosBD->CargarAvisos($this->titulo, $this->contenido, $this->activo, $this->fecha_creacion);
    }
}
include_once __DIR__ . "/../../persistencia/admin/AvisosBD.php";

