<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['cedula'])) {
           $errors[] = "Cédula vacía";
        } else if (empty($_POST['nombres'])){
			$errors[] = "Nombre del facilitador vacío";
        } else if (empty($_POST['telefono'])){
			$errors[] = "El número telefónico vacío";
        } elseif (empty($_POST['correo'])) {
            $errors[] = "El correo electrónico no puede estar vacío";
        } elseif (strlen($_POST['correo']) > 64) {
            $errors[] = "El correo electrónico no puede ser superior a 64 caracteres";
       } else if (empty($_POST['firma'])){
			$errors[] = "Firma vacía";
		} else if (
			!empty($_POST['cedula']) &&
			!empty($_POST['nombres']) &&
			!empty($_POST['telefono']) &&
			!empty($_POST['firma']) &&
			!empty($_POST['correo']) &&
			 strlen($_POST['correo']) <= 64 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$cedula=mysqli_real_escape_string($con,(strip_tags($_POST["cedula"],ENT_QUOTES)));
		$titulo=mysqli_real_escape_string($con,(strip_tags($_POST["titulo"],ENT_QUOTES)));
		$nombres=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["nombres"]),ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));
		$correo=mysqli_real_escape_string($con,(strip_tags($_POST["correo"],ENT_QUOTES)));
		$firma=mysqli_real_escape_string($con,(strip_tags($_POST["firma"],ENT_QUOTES)));
		date_default_timezone_set("America/Caracas");
		$date_added=date("Y-m-d H:i:s");
		$usuario=$_SESSION['user_name'];
		$sql="INSERT INTO cert_facilita (cedula, titulo, nombres, telefono, correo, firma, date_added, usuario) VALUES ('$cedula','$titulo','$nombres','$telefono','$correo','$firma','$date_added', '$usuario')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Los datos han sido ingresados satisfactoriamente.";
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
