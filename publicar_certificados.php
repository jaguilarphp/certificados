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

$tActiva=$_SESSION['tActiva'];
$id_evento= $_SESSION['id_evento'];
	/* Certificado del facilitador u organizador*/
	if (isset($_GET['id_facilita']))
{	$id_facilita=intval($_GET['id_facilita']);
		$fQuery="select * from cert_evento,cert_facilita where id_evento='".$id_evento."' and cert_evento.id_facilita=cert_facilita.id_facilita";
		$sql_evento=mysqli_query($con,$fQuery);
		$count=mysqli_num_rows($sql_evento);
		if ($count==1)
		{
				$rw_evento=mysqli_fetch_array($sql_evento);
				$tipo_evento=$rw_evento['tipo_evento'];
				$nombre_evento=$rw_evento['nombre_evento'];
				$fecha_evento=$rw_evento['fecha_evento'];
				$fechaletras=$rw_evento['fechaletras'];
				$duracion=$rw_evento['duracion'];
				$formato=$rw_evento['formato'];
				$id_facilita=$rw_evento['id_facilita'];
				$cedula=$rw_evento['cedula'];
				$facilitador=$rw_evento['titulo'].$rw_evento['nombres'];
				$firma=$rw_evento['firma'];
				$cert_public=intval($rw_evento['cert_public']);
				date_default_timezone_set("America/Caracas");
				$date_added=date("Y-m-d H:i:s");
				$usuario=$_SESSION['user_name'];
		}	
}
if ($cert_public==0) {
	/* Buscar cedula del facilitador en cert_participa*/
		$pQuery="select * from cert_participa where cert_participa.cedula= $cedula";
 		$sql_participa=mysqli_query($con,$pQuery);
		$count=mysqli_num_rows($sql_participa);
		if ($count==1)
		{
				$rw_p=mysqli_fetch_array($sql_participa);
				$id_participa=$rw_p['id_participa'];
		}
		if ($tipo_evento=="jornada" or $tipo_evento=="simposio" or $tipo_evento=="congreso") {
			$participa="organizador";
		} else {
			$participa="facilitador";
		}

	/* Insertar datos a la tabla*/
		$sql="INSERT INTO cert_cert (id_participa, participa, id_evento, tipo_firmas, date_added, usuario) VALUES ('$id_participa', '$participa', '$id_evento', '$tipo_firmas', '$date_added', '$usuario')";
		$query_new_insert = mysqli_query($con,$sql);
		$ultimo="SELECT id_cert FROM cert_cert order by id_cert DESC limit 1";
 		$sql_ultimo=mysqli_query($con,$ultimo);
		$count=mysqli_num_rows($sql_ultimo);
		if ($count==1)
		{
				$rw_ult=mysqli_fetch_array($sql_ultimo);
				$ultimoReg=$rw_ult['id_cert'];
		}
		$validador=strtoupper(dechex($cedula + $ultimoReg));
		$sql="UPDATE cert_cert SET validador='".$validador."' WHERE id_cert='".$ultimoReg."'";
		$query_update = mysqli_query($con,$sql);

	/* Generar los certificados del grupo*/
		if ($tipo_evento=="jornada" or $tipo_evento=="simposio" or $tipo_evento=="congreso") {
			$tipo_firmas="2";
		} else {
			$tipo_firmas="3";
		}
		$sql="INSERT INTO cert_cert (id_participa, participa, nivel_ponencia, id_evento) 
				SELECT cert_temp.id_participa, cert_temp.participa, 
				cert_temp.nivel_ponencia, cert_temp.id_evento FROM cert_temp
				 WHERE cert_temp.id_evento='".$id_evento."'";
		$query_new_insert = mysqli_query($con,$sql);
		$campos="cert_cert.id_cert, cert_participa.cedula, cert_cert.id_participa";
		$tablas="cert_cert, cert_participa";
		$where="id_evento=$id_evento AND cert_cert.id_participa=cert_participa.id_participa";
		$sql="SELECT $campos FROM $tablas WHERE $where";
		$query = mysqli_query($con, $sql);
		
		while ($row=mysqli_fetch_array($query)){
			$id_c=$row['id_cert'];
			$id_part=$row['id_participa'];
			$validador=strtoupper(dechex($row['cedula'] + $row['id_cert']));
			$sql="UPDATE cert_cert SET validador='".$validador."', tipo_firmas='".$tipo_firmas."', date_added='".$date_added."', usuario='".$usuario."' 
					WHERE id_cert='".$id_c."'";
			$query_update = mysqli_query($con,$sql);
			$sql_del="DELETE FROM cert_temp WHERE id_participa='".$id_part."'";
			$query_del = mysqli_query($con,$sql_del);
		}
	/* Actualizar tipo de firma al facilitador u organizador*/
		if (strpos($facilitador, 'Yasmile Navarro')) {
			$tipo_firmas=1;
		} else {
			$tipo_firmas=2;
		}
		$sql="UPDATE cert_cert SET tipo_firmas='".$tipo_firmas."' WHERE id_cert='".$ultimoReg."'";
		$query_update = mysqli_query($con,$sql);

	/* Actualizar cert_public*/
			$sql_public="UPDATE cert_evento SET cert_public='1' WHERE id_evento=$id_evento"; 
			$query_public = mysqli_query($con,$sql_public);

}
header("Refresh:0; url=certificados.php?cert_public=1&id_evento=$id_evento");

?>

<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 3000);
</script>