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
	$active_facilitadores="";
	$active_formatos="";
	$active_firmas="";
	$active_eventos="active";
	$active_usuarios="";	
	$title="Eventos | Certificados";
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
		    <div class="btn-group pull-right">
			<?php
        	if ($_SESSION['user_name']=='admin') { ?>
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoEvento" title="Nuevo evento"><span class="glyphicon glyphicon-plus" ></span></button>
     		<?php  } ?>
   			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Eventos</h4>
		</div>

		<div class="panel-body" style="min-height:440px; max-height:440px;">
			<?php
			include("modal/registro_eventos.php");
			include("modal/editar_eventos.php");
			?>
			<form class="form-horizontal" role="form" id="datos_eventos">
				<div class="form-group row">
					<label for="q" class="col-md-2 control-label">Nombre del evento</label>
					<div class="col-md-5">
						<div class="input-group">
							<input type="text" class="form-control" id="q" autocomplete="off" placeholder="Nombre del evento" onkeyup='load(1);'>
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
	</div>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/eventos.js"></script>
  </body>
</html>
<script>
$( "#guardar_evento" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_evento.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_eventos").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_eventos").html(datos);
			$('#guardar_datos').attr("disabled", false);
				$("#tipo_evento").val("");
				$("#nombre_evento").val("");
				$("#fecha_evento").val("");
				$("#fechaletras").val("");
				$("#duracion").val("");
				$("#formato").val("");
				$("imgFormato").val("");
				$("#tipo_firmas").val("");			
				$("#id_facilita").val("");
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_evento" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_evento.php",
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
			var tipo_evento = $("#tipo_evento"+id).val();
			var nombre_evento = $("#nombre_evento"+id).val();
			var fecha_evento = $("#fecha_evento"+id).val();
			var fechaletras = $("#fechaletras"+id).val();
			var duracion = $("#duracion"+id).val();
			var formato = $("#formato"+id).val();
			var imgFormato = $("#imgFormato"+id).val();
			var tipo_firmas = $("#tipo_firmas"+id).val();
			var id_facilita = $("#id_facilita"+id).val();
			var facilitador = $("#facilitador"+id).val();
			
			$("#mod_id").val(id);
			$("#mod_tipo_evento").val(tipo_evento);
			$("#mod_nombre_evento").val(nombre_evento);
			$("#mod_fecha_evento").val(fecha_evento);
			$("#mod_fechaletras").val(fechaletras);
			$("#mod_duracion").val(duracion);
			$("#mod_formato").val(formato);
			$("#mod_imgFormato").val(imgFormato);
			$("#mod_tipo_firmas").val(tipo_firmas);
			$("#mod_id_facilita").val(id_facilita);
			$("#mod_facilitador").val(facilitador);
    		document.getElementById("mod_imgFormato").src = imgFormato;
			document.getElementById("mod_facilitador").selectedIndex = --id_facilita;		}
</script>