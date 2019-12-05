<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$tActiva=$_SESSION['tActiva'];
$id_evento= $_SESSION['id_evento'];
$tipo_evento=$_SESSION['tipo_evento'];
$nombre_evento=utf8_encode($_SESSION['nombre_evento']);
$validador="1";

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

if (isset($_POST['id'])) {
	$id=intval($_POST['id']);
}
if (isset($_POST['participa'])){$participa=utf8_decode($_POST['participa']);
	if (empty($_POST['participa'])) {
	           echo '<script languaje="javasrcript">alert("Defina una participación para este registro")</script>';}}
$nivel_ponencia="";
if (isset($_POST['nivel']) and !empty($_POST['nivel'])){
	$nivel_ponencia.=utf8_decode($_POST['nivel']);}
if (isset($_POST['ponencia']) and !empty($_POST['ponencia'])){
	$nivel_ponencia.=utf8_decode($_POST['ponencia']);}
if (!empty($id) and !empty($participa)){
	$Where="WHERE $tActiva.id_participa='".$id."' and $tActiva.participa='".$participa."' and $tActiva.id_evento='".$id_evento."'";
	$count_pquery = mysqli_query($con, "SELECT count(*) AS registro FROM $tActiva $Where");
	$reg = mysqli_fetch_array($count_pquery);
	$nunreg=0;
	if ($participa=="autor" or $participa=="autora" or $participa=="coautor" or $participa=="coautora") {
			$numreg=0;
		} else {$nunreg = $reg['registro'];
	}
	if ($tipo_evento=="jornada" or $tipo_evento=="simposio" or $tipo_evento=="congreso") {
		$tipo_firmas="2";
	} else {
		$tipo_firmas="3";
	}
	if ($nunreg>0) {
		echo '<script languaje="javasrcript">alert("El registro ya existe para esta evento")</script>';
	} elseif ($tActiva=="cert_cert") {
			$query = mysqli_query($con, "SELECT * FROM cert_participa WHERE id_participa='".$id."'");
			$fila=mysqli_fetch_array($query);
				$cedula=$fila['cedula'];

			$insert_tmp=mysqli_query($con, "INSERT INTO $tActiva (id_evento, id_participa, participa, nivel_ponencia) VALUES ('$id_evento','$id','$participa','$nivel_ponencia')");
			$validador="";
			$query = mysqli_query($con, "SELECT * FROM cert_cert WHERE id_participa='".$id."' and participa='".$participa."' and validador='".$validador."'");
			$fila=mysqli_fetch_array($query);
				$id_cert=$fila['id_cert'];
			$validador=strtoupper(dechex($cedula + $id_cert));
			date_default_timezone_set("America/Caracas");
			$date_added=date("Y-m-d H:i:s");
			$usuario=$_SESSION['user_name'];
			$sql="UPDATE cert_cert SET validador='".$validador."', tipo_firmas='".$tipo_firmas."', date_added='".$date_added."', usuario='".$usuario."' WHERE id_cert='".$id_cert."'";
			$query_update = mysqli_query($con,$sql);
	} else {
		$insert_tmp=mysqli_query($con, "INSERT INTO $tActiva (id_evento, id_participa, participa, nivel_ponencia) VALUES ('$id_evento','$id','$participa','$nivel_ponencia')");
	}
}

if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_cert=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM $tActiva WHERE id_cert='".$id_cert."'");
}

	$qTablas="cert_participa, ".$tActiva;
	$qWhere="WHERE $tActiva.id_participa=cert_participa.id_participa and $tActiva.id_evento=$id_evento";
	include 'pagination.php'; //include pagination file
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	$per_page = 7; //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/
	$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $qTablas  $qWhere");
	$row= mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];
	$total_pages = ceil($numrows/$per_page);
	$reload = './certificados.php';
	//main query to fetch the data
	$sql="SELECT * FROM  $qTablas $qWhere order by participa desc, nombres";
	$query = mysqli_query($con, $sql);
	//loop through fetched data
	if ($numrows>0){
		echo mysqli_error($con);
?>
<div class="table-responsive" style="margin-top:0px;">
	<table class="table">
		<tr  class="info">
			<th width="10%">Cédula</th>
			<th width="30%">Nombres</th>
			<th width="20%">Correo</th>
			<th width="15%">Participación</th>
			<th width="10%">Estado</th>
			<th width="15%" class='text-right'>Acciones</th>
		</tr>
		<?php

			while ($row=mysqli_fetch_array($query))
			{
			$id_cert=$row["id_cert"];
			$cedula=$row["cedula"];
			$nombres=utf8_encode($row['nombres']);
			$correo=$row["correo"];
			$participa=utf8_encode($row["participa"]);
			if ($participa=="organizador" or $participa=="facilitador"){$label_class='label-warning';}
			else{$label_class='label-default';}
			$nivel_ponencia=utf8_encode($row["nivel_ponencia"]);
			if ($tActiva=="cert_cert"){$estado="Publicado";$label_class2='label-success';$validador=$row["validador"];$date_added=$row["date_added"];$usuario=$row["usuario"];}
			else{$estado="Pendiente";$label_class2='label-warning';}
		?>

			<input type="hidden" value="<?php echo $id_cert;?>" id="id_cert<?php echo $id_cert;?>">
			<input type="hidden" value="<?php echo $cedula;?>" id="cedula<?php echo $id_cert;?>">
			<input type="hidden" value="<?php echo $nombres;?>" id="nombres<?php echo $id_cert;?>">
			<input type="hidden" value="<?php echo $participa;?>" id="participa<?php echo $id_cert;?>">
			<input type="hidden" value="<?php echo $nivel_ponencia;?>" id="nivel_ponencia<?php echo $id_cert;?>">
			<input type="hidden" value="<?php echo $validador;?>" id="validador<?php echo $id_cert;?>">
			<input type="hidden" value="<?php echo $date_added;?>" id="date_added<?php echo $id_cert;?>">
			<input type="hidden" value="<?php echo $usuario;?>" id="usuario<?php echo $id_cert;?>">
			<input type="hidden" value="<?php echo $tipo_evento;?>" id="tipo_evento<?php echo $id_cert;?>">
			<input type="hidden" value="<?php echo $nombre_evento;?>" id="nombre_evento<?php echo $id_cert;?>">
			<input type="hidden" value="<?php echo $correo;?>" id="correo<?php echo $id_cert;?>">

			<tr>
				<td><?php echo str_pad($cedula,8,"0",STR_PAD_LEFT);?></td>
				<td><?php echo $nombres;?></td>
				<td><?php echo $correo;?></td>
				<td><span class="label <?php echo $label_class;?>"><?php echo $participa; ?></span></td>
				<td><span class="label <?php echo $label_class2;?>"><?php echo $estado; ?></span></td>

				<td><span class="pull-right">
						<?php
			        	if ($estado=="Publicado") { ?>
						<a href="certificado104.php?id_cert=<?php echo $id_cert;?>&id_evento=<?php echo $id_evento;?>" class='btn btn-default btn-xs' title='Ver certificado' data-toggle="modal" data-target=""><i class="glyphicon glyphicon-eye-open"></i></a> 
						<a href="#" class='btn btn-default btn-xs' title='Enviar correo' onclick="datos_correo('<?php echo $id_cert;?>')" data-toggle="modal" data-target="#EnviarCorreo"><i class="glyphicon glyphicon-envelope"></i></a>
						<?php } ?>
		        		<a href="#" class='btn btn-default btn-xs' title='Editar certificado' onclick="obtener_datos2('<?php echo $id_cert;?>')" data-toggle="modal" data-target="#EditarCertificado"><i class="glyphicon glyphicon-edit"></i></a>
					    <?php
			        	if ($_SESSION['user_name']=='admin' or $estado=="Pendiente") { ?>
						<a href="#" class='btn btn-default btn-xs' title='Borrar certificado' onclick="eliminar('<?php echo $id_cert; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						<?php } ?>
			</tr>		
			<?php
		}
	?>

	</table>
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