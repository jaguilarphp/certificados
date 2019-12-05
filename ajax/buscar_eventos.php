<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
function cortar_string ($string, $largo) { 
   $marca = "<!--corte-->"; 

   if (strlen($string) > $largo) { 
        
       $string = wordwrap($string, $largo, $marca); 
       $string = explode($marca, $string); 
       $string = $string[0]; 
	   return $string." ..."; 
   } else {
   return $string;} 

} 

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_evento=intval($_GET['id']);
		$del1="delete from cert_evento where id_evento='".$id_evento."'";
		if ($delete1=mysqli_query($con,$del1)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php
			
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre_evento');//Columnas de busqueda
		 $sTable = "cert_evento, cert_facilita";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE cert_evento.id_facilita=cert_facilita.id_facilita and (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		} else {
		$sWhere="WHERE cert_evento.id_facilita=cert_facilita.id_facilita";
		}
		$sWhere.=" order by nombre_evento";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 7; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './eventos.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table id="eventos" class="table">
				<tr  class="info">
					<th width="8%">Tipo</th>
					<th width="36%">Nombre</th>
					<th width="10%">Fecha</th>
					<th width="8%">Duración</th>
					<th width="8%">Formato</th>
					<th width="20%">Facilitador</th>
					<th width="10%"><span class="pull-right">Acciones</span></th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_evento=$row['id_evento'];
						$tipo_evento=utf8_encode($row['tipo_evento']);
						$nombre_evento=utf8_encode($row['nombre_evento']);
						$fecha_evento=strftime("%Y-%m-%d",strtotime($row['fecha_evento']));
						$fechaletras=utf8_encode($row['fechaletras']);
						$duracion=utf8_encode($row['duracion']);
						$formato=($row['formato']);
						$imgFormato="./formatos/".($row['formato']);
						$titulo=($row['titulo']);
						$id_facilita=($row['id_facilita']);
						$facilitador=utf8_encode($row['titulo']." ".$row['nombres']);
						$firma=($row['firma']);
						$cert_public=($row['cert_public']);
						if ($cert_public=="1"){$clase='btn btn-success btn-xs';}
						else{$clase='btn btn-warning btn-xs';}
						$date_added= date('d/m/Y', strtotime($row['date_added']));
					?>
					
					<input type="hidden" value="<?php echo $id_evento;?>" id="id_evento<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $tipo_evento;?>" id="tipo_evento<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $nombre_evento;?>" id="nombre_evento<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $fecha_evento;?>" id="fecha_evento<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $fechaletras;?>" id="fechaletras<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $duracion;?>" id="duracion<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $formato;?>" id="formato<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $imgFormato;?>" id="imgFormato<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $id_facilita;?>" id="id_facilita<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $facilitador;?>" id="facilitador<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $firma;?>" id="firma<?php echo $id_evento;?>">
					<input type="hidden" value="<?php echo $cert_public;?>" id="cert_public<?php echo $id_evento;?>">
				
					<tr>
						
						<td><?php echo $tipo_evento; ?></td>
						<td><?php echo cortar_string($nombre_evento,55);?></td>
						<td><?php echo $fecha_evento; ?></td>
						<td><?php echo $duracion; ?></td>						
						<td><?php echo $formato; ?></td>						
						<td><?php echo $facilitador; ?></td>

					<td class="text-right">
						<a href="certificados.php?cert_public=<?php echo $cert_public;?>&id_evento=<?php echo $id_evento;?>" class='<?php echo $clase;?>' title='Certificados'><i class="glyphicon glyphicon-certificate"></i></a> 
			    <?php
	        		if ($_SESSION['user_name']=='admin') { ?>
	        		<a href="#" class='btn btn-default btn-xs' title='Editar evento' onclick="obtener_datos('<?php echo $id_evento;?>');" data-toggle="modal" data-target="#Modal6"><i class="glyphicon glyphicon-edit"></i></a>
	        		<a href="#" class='btn btn-default btn-xs' title='Borrar evento' onclick="eliminar('<?php echo $id_evento; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
				<?php
					} ?>	
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=9 class="btn-xs"><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 3000);
</script>