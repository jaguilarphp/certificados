<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
	include('is_logged.php');//Archivo verifica que el usuario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("./config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("./config/conexion.php");//Contiene funcion que conecta a la base de datos
?>
<!DOCTYPE html>
<html lang="es-es">
	<head>
		<meta charset="utf-8">
		<title>Participantes</title>
	<head>
	<body>
		<?php
		// Definimos el archivo exportado
		$archivo = 'participantes.xls';
		
		// Crear la tabla HTML
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="5">Lista de participantes</tr>';
		$html .= '</tr>';
		
		
		$html .= '<tr>';
		$html .= '<td><b>ID</b></td>';
		$html .= '<td><b>Cédula</b></td>';
		$html .= '<td><b>Nombres</b></td>';
		$html .= '<td><b>Teléfono</b></td>';
		$html .= '<td><b>Correo</b></td>';
		$html .= '<td><b>Fecha de ingreso</b></td>';
		$html .= '</tr>';
		
		//Seleccionar todos los elementos de la tabla
		$result_msg_participa = "SELECT * FROM cert_participa order by id_participa";
		$resultado_msg_participa = mysqli_query($con,$result_msg_participa);
		while($row_msg_participa = mysqli_fetch_assoc($resultado_msg_participa)){
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_participa["id_participa"].'</td>';
			$html .= '<td>'.$row_msg_participa["cedula"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_participa["nombres"]).'</td>';
			$html .= '<td>'.$row_msg_participa["telefono"].'</td>';
			$html .= '<td>'.$row_msg_participa["correo"].'</td>';
			$data = date('d/m/Y',strtotime($row_msg_participa["date_added"]));
			$html .= '<td>'.$data.'</td>';
			$html .= '</tr>';
			;
		}
		// Configuración en la cabecera
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M Y") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$archivo}\"" );
		header ("Content-Description: PHP Generado Data" );
		// Envia contenido al archivo
		echo $html;
		exit; ?>
	</body>
</html>