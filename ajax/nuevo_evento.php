<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['tipo_evento'])) {
           $errors[] = "Escoja tipo de evento";
        } else if (empty($_POST['nombre_evento'])){
			$errors[] = "Nombre del evento vacío";
        } else if (empty($_POST['fecha_evento'])){
			$errors[] = "Escoja fecha del evento";
        } elseif (empty($_POST['fechaletras'])) {
            $errors[] = "Fecha en letras no puede estar vacío";
        } elseif (strlen($_POST['duracion']) > 64) {
            $errors[] = "La duracion no puede estar vacía";
        } else if (empty($_POST['formato'])){
			$errors[] = "Nombre del formato vacío";
		} else if (empty($_POST['id_facilita'])){
			$errors[] = "Nombre del facilitador vacío";
		} else if (
			!empty($_POST['tipo_evento']) &&
			!empty($_POST['nombre_evento']) &&
			!empty($_POST['fecha_evento']) &&
			!empty($_POST['fechaletras']) &&
			!empty($_POST['duracion']) &&
			!empty($_POST['formato']) &&
			!empty($_POST['id_facilita']) 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$tipo_evento=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["tipo_evento"]),ENT_QUOTES)));
		$nombre_evento=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["nombre_evento"]),ENT_QUOTES)));
		$fecha_evento=mysqli_real_escape_string($con,(strip_tags($_POST["fecha_evento"],ENT_QUOTES)));
		$fechaletras=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["fechaletras"]),ENT_QUOTES)));
		$duracion=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["duracion"]),ENT_QUOTES)));
		$formato=mysqli_real_escape_string($con,(strip_tags($_POST["formato"],ENT_QUOTES)));
		$id_facilita=mysqli_real_escape_string($con,(strip_tags($_POST["id_facilita"],ENT_QUOTES)));
//		$firma=mysqli_real_escape_string($con,(strip_tags($_POST["firma"],ENT_QUOTES)));
		date_default_timezone_set("America/Caracas");
		$date_added=date("Y-m-d H:i:s");
		$usuario=$_SESSION['user_name'];

		$sql="INSERT INTO cert_evento (tipo_evento, nombre_evento, fecha_evento, fechaletras, duracion, formato, id_facilita, date_added, usuario) VALUES ('$tipo_evento','$nombre_evento','$fecha_evento','$fechaletras','$duracion','$formato','$id_facilita','$date_added', '$usuario')";
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
