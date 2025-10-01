<?php

function CargarFoto(): mixed{

 
if (isset($_FILES['image'])) {
   
    $RutaTemporal = $_FILES['image']['tmp_name'];

    $NombreDelArchivo = $_FILES['image']['name'];


    $NombreDelArchivoCmps = explode(separator: ".", string: $NombreDelArchivo);
 

    $ExtensionDelArchivo = strtolower(end($NombreDelArchivoCmps));

 
    $extensionesPErmitidas = array('jpg', 'gif', 'png', 'jpeg');

    if (in_array(needle: $ExtensionDelArchivo, haystack: $extensionesPErmitidas)) {
      
        $DirectorioDestino = './images/';
        $RutaCompetaFinal = $DirectorioDestino . $NombreDelArchivo;

  
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