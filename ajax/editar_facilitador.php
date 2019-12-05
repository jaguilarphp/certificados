<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_cedula'])) {
           $errors[] = "Cédula vacío";
         } else if (empty($_POST['mod_nombres'])){
			$errors[] = "Nombre de facilitador vacío";
        } else if (empty($_POST['mod_telefono'])){
			$errors[] = "Número telefónico vacío";
        } else if (empty($_POST['mod_correo'])){
			$errors[] = "Correo Electrónico vacío";
        }else if (empty($_POST['mod_firma'])) {
           $errors[] = "Firma vacía";
		} else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_cedula']) &&
			!empty($_POST['mod_nombres']) &&
			!empty($_POST['mod_telefono']) &&
			!empty($_POST['mod_correo']) &&
			!empty($_POST['mod_firma'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$cedula=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cedula"],ENT_QUOTES)));
		$titulo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_titulo"],ENT_QUOTES)));
		$nombres=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["mod_nombres"]),ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telefono"],ENT_QUOTES)));
		$correo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_correo"],ENT_QUOTES)));
		$firma=mysqli_real_escape_string($con,(strip_tags($_POST["mod_firma"],ENT_QUOTES)));
		$id_facilita=$_POST['mod_id'];
		$sql="UPDATE cert_facilita SET cedula='".$cedula."', titulo='".$titulo."', nombres='".$nombres."', telefono='".$telefono."', correo='".$correo."', firma='".$firma."' WHERE id_facilita='".$id_facilita."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Datos del facilitador han sido actualizado satisfactoriamente.";
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
