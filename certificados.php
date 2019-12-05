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
	$active_participantes="";
	$active_facilitadores="";
	$active_formatos="";
	$active_firmas="";
	$active_eventos="active";
	$active_usuarios="";	
	$title="Certificados | Certificados";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	$cert_public=intval($_GET['cert_public']);
	if ($cert_public==1){$tActiva="cert_cert";}
	else{$tActiva="cert_temp";}
	$_SESSION['tActiva']=$tActiva;
	if (isset($_GET['id_evento']))
	{
		$id_evento=intval($_GET['id_evento']);
		$eQuery="select * from cert_evento,cert_facilita where id_evento='".$id_evento."' and cert_evento.id_facilita=cert_facilita.id_facilita";
		$sql_evento=mysqli_query($con,$eQuery);
		$count=mysqli_num_rows($sql_evento);
		if ($count==1)
		{
				$rw_evento=mysqli_fetch_array($sql_evento);
				$id_evento=$rw_evento['id_evento'];
				$tipo_evento=$rw_evento['tipo_evento'];
				$_SESSION['nombre_evento']=$rw_evento['nombre_evento'];
				$nombre_evento=$_SESSION['nombre_evento'];
				$fecha_evento=$rw_evento['fecha_evento'];
				$fechaletras=$rw_evento['fechaletras'];
				$duracion=$rw_evento['duracion'];
				$formato=$rw_evento['formato'];
				$id_facilita=$rw_evento['id_facilita'];
				$facilitador=$rw_evento['titulo'].$rw_evento['nombres'];
				$firma=$rw_evento['firma'];
				$cert_public=intval($rw_evento['cert_public']);
				$_SESSION['id_evento']=$id_evento;
				$_SESSION['tipo_evento']=$tipo_evento;
		}	
		else
		{
			header("location: eventos.php");
			exit;	
		}
	} 
	else 
	{
		header("location: eventos.php");
		exit;
	}
	if ($tipo_evento=="jornada"){$desc_evento="de la ".$tipo_evento;}
		else{$desc_evento="del ".$tipo_evento;} 
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
	<div class="container" >
		<div class="panel panel-info" style="margin-top: 65px;">
			<div class="panel-heading">
				<div class="pull-right">
					<?php
		        	if ($tActiva=="cert_temp") { ?>
		        	<a href="publicar_certificados.php?id_facilita=<?php echo $id_facilita;?>" class='btn btn-warning' title='Publicar certificados'><span class="glyphicon glyphicon-refresh"></span><span class="glyphicon glyphicon-certificate"></span></a> 
					<?php } 
					 
		        	if ($_SESSION['user_name']=='admin' or $tActiva=="cert_temp") { ?>
					<a href="#" class='btn btn-info' title='Buscar participante' data-toggle="modal" data-target="#Modal7" onclick="<?php $tipo_evento;?>"><i class="glyphicon glyphicon-search"></i><span class="glyphicon glyphicon-user"></span></a> 
					<?php } ?>
				</div>	
				<h4><i class='glyphicon glyphicon-edit'></i> Certificados <?php echo utf8_encode($desc_evento);?>: <?php echo utf8_encode($nombre_evento);?></h4>

			</div>

		<div class="panel-body">
		<?php 
			include("modal/agregar_participante.php");
			include("modal/registro_participantes.php");
			include("modal/editar_certificado.php");
			
		?>
			<form class="form-horizontal" role="form" id="datos_evento">
				<div class="form-group row" style="margin-bottom:5px;">
				  <label for="facilitador" class="col-md-1 control-label">Facilitador</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="facilitador" placeholder="Nombre del facilitador" readonly value="<?php echo utf8_encode($facilitador);?>">
					  <input id="id_evento" name="id_evento" type='hidden' value="<?php echo $id_evento;?>">	
				  </div>
				  <label for="fecha_evento" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="fecha_evento" placeholder="Fecha del evento" value="<?php echo $fecha_evento;?>" readonly>
							</div>
					<label for="duracion" class="col-md-1 control-label">Duración</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="duracion" placeholder="Duración" readonly value="<?php echo $duracion;?>">
							</div>
					<label for="formato" class="col-md-1 control-label">Formato</label>
							<div class="col-md-1">
								<input type="text" class="form-control input-sm" id="formato" placeholder="Formato" readonly value="<?php echo $formato;?>">
							</div>
				 </div>
			</form>	
			<div class="clearfix"></div>
			
			<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->		

			
		</div>
	</div>		
		 
	</div>

	<?php
	include("footer.php");
	?>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type="text/javascript" src="js/certificados.js"></script>
<link rel="css/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 3000);
</script>

  </body>
</html>
<script>
$( "#guardar_certificado" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_certificado.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_certificados").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_certificados").html(datos);
			$('#guardar_datos').attr("disabled", false);
				$("#cedula").val("");
				$("#nombres").val("");
				$("#participa").val("");
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_certificado" ).submit(function( event ) {
  $('#actualizar_datos2').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_certificado.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos2').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos2(id){
			var cedula = $("#cedula"+id).val();
			var nombres = $("#nombres"+id).val();
			var participa = $("#participa"+id).val();
			var nivel_ponencia = $("#nivel_ponencia"+id).val();
			var tipo_evento = $("#tipo_evento"+id).val();
			var validador = $("#validador").val();
			var date_added = $("#date_added").val();
			var usuario = $("#usuario").val();
			var	divEcNivel = document.getElementById("ecnivel");
			var	divEcPonencia = document.getElementById("ecponencia");

			$("#mec_id").val(id);
			$("#mec_cedula").val(cedula);
			$("#mec_nombres").val(nombres);
			$("#mec_validador").val(validador);
			$("#mec_date_added").val(date_added);
			$("#mec_usuario").val(usuario);			
			document.getElementById("mec_participa").value = participa;
			document.getElementById("mec_nivel").value = nivel_ponencia;
	switch (participa) {
		case "aprobado":
			divEcNivel.style.display = "";
			divEcPonencia.style.display = "none";
			alert("Longitud: "+nivel_ponencia.length+"   y nivel: "+nivel_ponencia);
			$("select#mec_nivel").val(nivel_ponencia);
			break;
		case "autor":
		case "autora":
		case "coautor":
		case "coautora":
		case "conferencista":
			divEcNivel.style.display = "none";
			divEcPonencia.style.display = "";
			document.getElementById("mec_ponencia").value = nivel_ponencia;
			break;
		default:
			divEcNivel.style.display = "none";
			divEcPonencia.style.display = "none";
			break;
	}
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