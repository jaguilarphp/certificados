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
	$active_firmas="";
	$active_eventos="";
	$active_validador="active";
	$active_usuarios="";	
	$title="Validador | Certificados";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	include("modal/enviar_correo.php");
	?>
	
    <div class="container">
	<div class="panel panel-info" style="margin-top: 65px; margin-bottom: 0px;">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-search'></i> Validador</h4>
		</div>
		<div class="panel-body" style="min-height:440px; max-height:440px;">
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Validador o cédula</label>
							<div class="col-md-5">
								<div class="input-group">
	 								<input type="text" class="form-control" id="q" placeholder="Validador o cédula del participante" onkeyup='load(1);'>
<!-- 									<span class="input-group-btn"><button class="btn btn-default" type="button" onclick='load(1);' id="loader"> Buscar</button></span>
 -->								<span class="input-group-btn">
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
  </body>
</html>
<script>
$(document).ready(function(){
	load(1);
});

function load(page){
	var q= $("#q").val();
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/buscar_validador.php?action=ajax&page='+page+'&q='+q,
		 beforeSend: function(objeto){
		 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
	  },
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
			
		}
	})
}

function datos_correo(id) {
		var id_cert = $("#id_cert"+id).val();
		var id_evento = $("#id_evento"+id).val();
		var nombres = $("#nombres"+id).val();
		var tipo_evento = $("#tipo_evento"+id).val();
		if (tipo_evento =="jornada") {
			articulo = "a la";
		} else 
			articulo = "al";
		
		var nombre_evento = $("#nombre_evento"+id).val();
		var correo = $("#correo"+id).val();
		var de = "Consejo Central de Pregrado";
		var asunto = "Certificado del Consejo Central de Pregrado";
		var mensaje = document.getElementById('mensaje');
		mensaje.innerHTML = "Saludos!<br><b>"+nombres+"</b><br><br><p> Gracias por acompañarnos a nuestros eventos. Haz click <a href=http://publicidadexpress.net/certificados/certificado104.php?id_cert="+id_cert+"&id_evento="+id_evento+">aquí</a> y podrás imprimir tu certificado correspondiente "+articulo+" "+tipo_evento+": <b>"+nombre_evento+"</b>";
		mensaje2 = "Saludos!<br><b>"+nombres+"</b><br><br><p> Gracias por acompañarnos a nuestros eventos. Haz click <a href=http://publicidadexpress.net/certificados/certificado104.php?id_cert="+id_cert+"&id_evento="+id_evento+">aquí</a> y podrás imprimir tu certificado correspondiente "+articulo+" "+tipo_evento+": <b>"+nombre_evento+"</b>";

		$("#id_cert").val(id_cert);
		$("#de").val(de);
		$("#nombre_evento").val(nombre_evento);
		$("#nombres").val(nombres);
		$("#correo").val(correo);
		$("#asunto").val(asunto);
		$("#mensaje").val(mensaje);
		$("#mensaje2").val(mensaje2);
	}
</script>