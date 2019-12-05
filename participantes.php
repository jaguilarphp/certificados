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
	
	$active_participantes="active";
	$active_facilitadoress="";
	$active_formatos="";
	$active_firmas="";
	$active_eventos="";
	$active_usuarios="";	
	$title="Participantes | Certificados";
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
	<div class="panel panel-info" style="margin-top: 65px; margin-bottom: 0px;">
		<div class="panel-heading">
		    <div class="pull-right">
		    	<?php
		        if ($_SESSION['user_name']=='admin') { ?>
	        	<a href="GenerarExcel.php" class='btn btn-warning' title='Generar Excel'><span class="glyphicon glyphicon-save"></a>; 
	        	<?php } ?>
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoParticipante" title="Nuevo participante"><span class="glyphicon glyphicon-plus" ></span></button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Participantes</h4>
		</div>
		<div class="panel-body" style="min-height:440px; max-height:440px;">
			<?php
			include("modal/registro_participantes.php");
			include("modal/editar_participantes.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Cédula o nombre</label>
							<div class="col-md-5">
								<div class="input-group">
	 								<input type="text" class="form-control" id="q" placeholder="Cédula o nombre del participante" onkeyup='load(1);'>
									<span class="input-group-btn">
									<button class="btn btn-info" type="button" id="loader1" onclick='load(1);'>
										<i class="glyphicon glyphicon-search"></i>
									</button> </span>
								</div>
							</div>
						
							
						</div>
				
				
				
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
	<script type="text/javascript" src="js/participantes.js"></script>
  </body>
</html>
<script>
$( "#guardar_participante" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_participante.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_participantes").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_participantes").html(datos);
			$('#guardar_datos').attr("disabled", false);
				$("#cedula").val("");
				$("#nombres").val("");
				$("#telefono").val("");
				$("#correo").val("");			
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_participante" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_participante.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
			var cedula = $("#cedula"+id).val();
			var nombres = $("#nombres"+id).val();
			var telefono = $("#telefono"+id).val();
			var correo = $("#correo"+id).val();
			
			$("#mod_id").val(id);
			$("#mod_cedula").val(cedula);
			$("#mod_nombres").val(nombres);
			$("#mod_telefono").val(telefono);
			$("#mod_correo").val(correo);
		}
</script>