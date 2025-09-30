   <?php
    
    include_once "../logica/Talleres.php";
    include_once "../datos/talleresBD.php";

    //include_once "../incluir/menu.php";

    // Agregar
    if(isset($_POST['agregar'])){
        $taller = new talleres();
        $taller->setNombre($_POST['nombre']);
        $taller->setDia($_POST['dia']);
        $taller->setHorario($_POST['horario']);
      //  $taller->setEstado($_POST['estado']);
        include_once "cargarimagen.php";

        $foto = CargarFoto();
        if($foto != null){
            $taller ->setFoto($foto);
              $taller->CargarTalleres();

        }
        
      
    }

    // Listar
    if(isset($_POST['ListarTalleres'])) {
        $taller = new talleres();
        $listatalleres = $taller->ListarTalleres();

        echo "<table border='1'>";
        echo "<th>Id</th>";
        echo "<th>Nombre</th>";
        echo "<th>Dia</th>";
        echo "<th>Horario</th>";
       // echo "<th>Estado</th>";
        echo "<th>Foto</th>";

        foreach ($listatalleres as $taller) {
        echo "<tr>";
        echo "<td>".$taller->getId()."</td>";
        echo "<td>".$taller->getNombre()."</td>";
        echo "<td>".$taller->getDia()."</td>";
        echo "<td>".$taller->gethorario()."</td>";
        //echo "<td>".$taller->getEstado()."</td>";
        echo "<td>".$taller->getFoto()."</td>";
        echo "</tr>";

        }
        echo "</table>"; 
    }

    // Buscar
if (isset($_POST['BuscarTalleres'])) {
    $taller = new talleres();

    if (!empty($_POST["id"])) {
        $taller->setId($_POST["id"]);
    }

    if (!empty($_POST["nombre"])) {
        $taller->setNombre($_POST["nombre"]);
    }

    $buscarTalleres = $taller->BuscarTalleres();

    if ($buscarTalleres && count($buscarTalleres) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Nombre</th><th>Dia</th><th>Horario</th><th>Estado</th></tr>";

        foreach ($buscarTalleres as $resultado) {
            echo "<tr>";
            echo "<td>" . $resultado->getNombre() . "</td>";
            echo "<td>" . $resultado->getDia() . "</td>";
            echo "<td>" . $resultado->getHorario() . "</td>";
            //echo "<td>" . $resultado->getEstado() . "</td>";
            echo "</tr>";

            // Cargar datos al formulario con JS
            echo "<script>
                document.getElementById('idTaller').value='" . $resultado->getId() . "';
                document.getElementById('nombreT').value='" . $resultado->getNombre() . "';
                document.getElementById('dia').value='" . $resultado->getDia() . "';
                document.getElementById('horario').value='" . $resultado->getHorario() . "';
                
            </script>";
        }

        echo "</table>";
    } else {
        echo "<p>No se encontraron animales con esos criterios.</p>";
    }
}


    // Cambiar
    if(isset($_POST['Cambiar'])){
        $taller = new talleres();
        $taller->setId($_POST['id']);
        $taller->setNombre($_POST['nombre']);
        $taller->setDia($_POST['dia']);
        $taller->setHorario($_POST['horario']);
     //   $taller->setEstado($_POST['estado']);
        $taller->CambiarTalleres();
    }

   
  if (isset($_POST['agregarfoto'])) {
    include_once "../Logica/Talleres.php";
    $taller = new Talleres();
        $taller->setNombre($_POST['nombre']);
        $taller->setDia($_POST['dia']);
        $taller->setHorario($_POST['horario']);
        //$mascota->setTipo($_POST['tipo']);
           $taller->setFoto($_POST['foto']);
       include_once "cargarimagen.php";
       $foto=CargarFoto();

       if($foto != null){
        $taller->setFoto($foto);
           $taller->CargarMascotas();
       } else{
        echo "error al cargar la foto";
       }
       
   }

    
    ?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administración</title>
    <link rel="stylesheet" href="../estilos/adoptar.css">
    <link rel="stylesheet" href="../estilos/admin.css">
</head>

<body>
    
        </a>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="idAnimal">ID</label>
            <input type="number" name="id" id="idAnimal" >
        </div>

        <div>
            <label for="nombreL">Nombre</label>
            <input type="text" name="nombre" id="nombre">
        </div>

        <div>
            <label for="edad">Dia</label>
            <input type="text" name="dia" id="dia">
        </div>

        <div>
            <label for="tipo">Horario</label>
            <input type="text" name="horario" id="horario">
        </div>

        <div>
            <label for="estado">Estado</label>
            <select id="estado" name="estado">
                <option value="disponible">Disponible</option>
                <option value="reservado">Reservado</option>
                <option value="adoptado">Adoptado</option>
            </select>
        </div>

        <div>
            <label> Foto</label>
            <input type="file" name= "image">
        
        </div>

        <div>
            <input type="submit" name="agregar" value="Agregar">
            <input type="submit" name="ListarTalleres" value="Listar Talleres">
            <input type="submit" name="BuscarTalleres" value="Buscar Talleres">
            <input type="submit" name="Cambiar" value="Cambiar">
        </div>
    </form>
</body>
</html>


 </body>
</html>


