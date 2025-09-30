<?php

function CargarFoto(): mixed{

   /* En PHP, mixed es un tipo de retorno que indica que una función puede devolver
    diferentes tipos de valores. Esto significa que la función CargarImagen()
     podría devolver un valor de cualquier tipo, como un entero, cadena,
     booleano, arreglo, objeto, o incluso null.
    */
if (isset($_FILES['image'])) {
    // Obtener detalles del archivo
    $RutaTemporal = $_FILES['image']['tmp_name'];
    /*
    Esta línea obtiene la ruta temporal donde se almacena el archivo subido en el servidor
    de forma temporal.
    Cuando subes un archivo, PHP lo coloca primero en una ubicación temporal.
    Esta variable (tmp_name) contiene el camino a ese archivo temporal, que se
    utilizará más adelante para mover el archivo a la ubicación definitiva.
    */

    $NombreDelArchivo = $_FILES['image']['name'];
    /*Aquí se obtiene el nombre original del archivo subido,
    tal como aparece en el dispositivo del usuario. */


    $NombreDelArchivoCmps = explode(separator: ".", string: $NombreDelArchivo);
   /*
        Función explode: Esta función toma una cadena de texto y la divide en partes
        basándose en un delimitador, en este caso el punto (.).
        Propósito: El objetivo es dividir el nombre del archivo en dos partes:
        el nombre base y la extensión.
        Ejemplo:
        Si el archivo es foto_vacaciones.jpg, después de aplicar explode(".", $NombreDelArchivo),
        el resultado será un array: $NombreDelArchivoCmps = ['foto_vacaciones', 'jpg'];
   */


    $ExtensionDelArchivo = strtolower(end($NombreDelArchivoCmps));

    // Definir extensiones permitidas
    $extensionesPErmitidas = array('jpg', 'gif', 'png', 'jpeg');

    if (in_array(needle: $ExtensionDelArchivo, haystack: $extensionesPErmitidas)) {
         /*
            in_array():
            Esta función comprueba si un valor existe dentro de un array.
        */



        // Establecer el directorio donde se guardará la imagen
        $DirectorioDestino = '../fotos/';
        $RutaCompetaFinal = $DirectorioDestino . $NombreDelArchivo;

        // Mover el archivo subido a la carpeta de destino
        if (move_uploaded_file(from: $RutaTemporal, to: $RutaCompetaFinal)) {
            echo "El archivo fue guardado correctamente";
            return $NombreDelArchivo;
           
        } else {
            echo "Hubo un error moviendo el archivo a la carpeta de destino.";
            return null;
       
        }
    } else {
        echo "Tipo de archivo no permitido. Solo se permiten imágenes en formato JPG, PNG, GIF.";
        return null;
    }
} else {
    echo "Hubo un error al subir el archivo (input).";
    return null;
}

}

?>