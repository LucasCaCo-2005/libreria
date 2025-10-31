<?php
// Verifica si la clase Conexion ya existe, esto evita errores
if (!class_exists('Conexion')) {
    // declara la clase conexion con propiedades privadas. solo accesibles dentro de la clase
    class Conexion { 
        private $host = "localhost";
        private $bd = "asociacion";
        private $usuario = "root";
        private $contraseña = "abc123";
        private $conexion;
// metodo para empezar la conexion
        public function Conectar() {
           try { // el try ejecuta un codigo que puede llegar a fallar
            // Crea objeto PDo, php data object para conexion con mysql
                $this->conexion = new PDO(
                    "mysql:host=$this->host;dbname=$this->bd;charset=utf8", // codificacion para aguantar ñ y tildes
                    $this->usuario,
                    $this->contraseña
                );
                 //Lanza excepciones cuando ocurren errores
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                return $this->conexion; // Retorna el objeto de conexion para ser usado en consultas

                //Captura excepciones especificas de PDO
            } catch (PDOException $e) { 
                echo "Error: " . $e->getMessage();
                return null;
            }
        }
    }
}
// Verifica si la variable conexion ya existe, si no existe crea la variable
if (!isset($conexion)) {
    $conexion = (new Conexion())->Conectar();
}
?>
