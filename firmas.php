<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_participantes="";
	$active_facilitadoress="";
	$active_formatos="";
	$active_firmas="active";
	$active_eventos="";
	$active_usuarios="";	
	$title="Firmas | Certificados";

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
    <div class="container">
	<div class="panel panel-info" style="margin-top: 65px;">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevaFirma" title="Nueva firma"><span class="glyphicon glyphicon-plus" ></span></button>
			</div>
			<h4><i class='glyphicon glyphicon-list-alt'></i> Firmas</h4>
		</div>
		<div class="panel-body">
		
			
			
			<?php
				include("modal/registro_firma.php");
                $ruta="./firmas";
                $gestor = opendir($ruta);
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">

   <section class="content">
        <div class="container-fluid">
            <!-- Default Example -->
            <!-- Custom Content -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

		                    <?php while (($archivo = readdir($gestor)) !== false)  {
		                        // Solo buscamos archivos sin entrar en subdirectorios
		                        if (is_file($ruta."/".$archivo)) {
		                           // echo "<img src='".$ruta."/".$archivo."' width='200px' alt='".$archivo."' title='".$archivo."'>";
		                            $pathimagen=$ruta."/".$archivo; ?>
		                            <div class="col-sm-6 col-md-3">
		                                

		                                <ul class="" id="hover-cap-6col">
										
										<div class=" thumbnail thumbnail2" id="">
										<div class="caption">
										<h4><p><?php echo $archivo ?></h4>
										<p>
								        <?php
								        if ($_SESSION['user_name']=='admin') { ?>
								            <a href='borrarimagen.php?path=<?php echo $pathimagen ?>' class="btn btn-default" rel="tooltip" title="Eliminar firma" onclick="if(confirm('Deseas borrar realmente el archivo?')){this.form.submit();}else{return false;}"><i class="glyphicon glyphicon-trash"></i></a></a>
								   <?php  } ?>										
										</p>
										</div>
										<img width='300px' height='300px' src=<?php echo $pathimagen ?>>
										</div>
										
										</ul>
		                            </div>
		                <?php   }
		                    
		                    }

                    // Cierra el gestor de directorios
                    closedir($gestor);                                       
                    ?>
                            </div>
                </div>
            </div>
            <!-- #END# Custom Content -->
        </div>
    </section>				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			
  </div>
</div>
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/formatos.js"></script>
	<script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>
  </body>
</html>
