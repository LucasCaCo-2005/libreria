
<?php include_once 'template/cabecera.php'; ?>
       <div class="jumbotron">
        <h1 class="display-3">      </h1>
        <p class="lead"><h1>Bienvenido, <?php echo $_SESSION['nombre']; ?>!</h1></p>
        <hr class="my-2">
        <p>More info</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="productos.php" role="button">Administrar productos</a> <br> <br>
              <a class="btn btn-primary btn-lg" href="paneladmin.php" role="button">Administrar Talleres</a> <br> <br>
               <a class="btn btn-primary btn-lg" href="socios.php" role="button">Administrar Socios</a> <br> <br>
        </p>
       </div>
<?php include_once ('template/pie.php'); ?>
    
