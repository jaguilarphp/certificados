<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$tActiva=$_SESSION['tActiva'];
	$tipo_evento=$_SESSION['tipo_evento'];
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mec_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mec_participa'])) {
           $errors[] = "Participación no debe estar vacía";
		} else if (
			!empty($_POST['mec_id']) &&
			!empty($_POST['mec_cedula']) &&
			!empty($_POST['mec_nombres']) &&
			!empty($_POST['mec_participa'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$participa=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["mec_participa"]),ENT_QUOTES)));
		if (isset($_POST['mec_nivel'])){$nivel_ponencia=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["mec_nivel"]),ENT_QUOTES)));} 
		if (isset($_POST['mec_ponencia'])){$nivel_ponencia=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["mec_ponencia"]),ENT_QUOTES)));}
		$id_cert=$_POST['mec_id'];
		$cedula=$_POST['mec_cedula'];
		switch ($participa) {
			case "aprobado":
				if (isset($_POST['mec_nivel'])){$nivel_ponencia=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["mec_nivel"]),ENT_QUOTES)));};
				break;
			case "autor":
			case "autora":
			case "coautor":
			case "coautora":
			case "conferencista":
				if (isset($_POST['mec_ponencia'])){$nivel_ponencia=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["mec_ponencia"]),ENT_QUOTES)));};
				break;
			default:
				if (isset($_POST['mec_ponencia']) or isset($_POST['mec_nivel'])){$nivel_ponencia="";};
				break;
		}
		if ($tActiva=="cert_cert") {
			$validador=strtoupper(dechex($cedula + $id_cert));
			date_default_timezone_set("America/Caracas");
			$date_added=date("Y-m-d H:i:s");
			$usuario=$_SESSION['user_name'];
			$sql="UPDATE $tActiva SET participa='".$participa."', nivel_ponencia='".$nivel_ponencia."', validador='".$validador."', usuario='".$usuario."', date_added='".$date_added."' WHERE id_cert='".$id_cert."'";
		} else {
			$sql="UPDATE $tActiva SET participa='".$participa."', nivel_ponencia='".$nivel_ponencia."' WHERE id_cert='".$id_cert."'";
		}
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Datos del certificado han sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>

<script type="text/javascript">
/*$(document).ready(function()}
	function()}
		$('#resultados').load('certificados.php');
	}
	);
});
*/
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 3000);
</script>
