<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_nombre_evento'])) {
           $errors[] = "Nombre del evento vacío";
        } else if (empty($_POST['mod_fecha_evento'])){
			$errors[] = "Escoja fecha del evento";
        } elseif (empty($_POST['mod_fechaletras'])) {
            $errors[] = "Fecha en letras no puede estar vacío";
        } elseif (empty($_POST['mod_duracion'])) {
            $errors[] = "La duracion no puede estar vacía";
        } else if (empty($_POST['mod_formato'])){
			$errors[] = "Nombre del formato vacío";
		} else if (empty($_POST['mod_id_facilita'])){
			$errors[] = "Nombre del facilitador vacío";
		} else if (
			!empty($_POST['mod_tipo_evento']) &&
			!empty($_POST['mod_nombre_evento']) &&
			!empty($_POST['mod_fecha_evento']) &&
			!empty($_POST['mod_fechaletras']) &&
			!empty($_POST['mod_duracion']) &&
			!empty($_POST['mod_formato']) &&
			!empty($_POST['mod_id_facilita']) 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$tipo_evento=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["mod_tipo_evento"]),ENT_QUOTES)));
		$nombre_evento=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["mod_nombre_evento"]),ENT_QUOTES)));
		$fecha_evento=mysqli_real_escape_string($con,(strip_tags($_POST["mod_fecha_evento"],ENT_QUOTES)));
		$fechaletras=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["mod_fechaletras"]),ENT_QUOTES)));
		$duracion=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["mod_duracion"]),ENT_QUOTES)));
		$formato=mysqli_real_escape_string($con,(strip_tags($_POST["mod_formato"],ENT_QUOTES)));
		$id_facilita=mysqli_real_escape_string($con,(strip_tags($_POST["mod_id_facilita"],ENT_QUOTES)));
		$facilitador=mysqli_real_escape_string($con,(strip_tags($_POST["mod_facilitador"],ENT_QUOTES)));
		$id_evento=mysqli_real_escape_string($con,(strip_tags($_POST["mod_id"],ENT_QUOTES)));

		$sql="UPDATE cert_evento SET tipo_evento='".$tipo_evento."', nombre_evento='".$nombre_evento."', fecha_evento='".$fecha_evento."', fechaletras='".$fechaletras."', duracion='".$duracion."', formato='".$formato."', id_facilita='".$id_facilita."' WHERE id_evento='".$id_evento."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Datos del evento han sido actualizado satisfactoriamente.";
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
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 3000);
</script>
