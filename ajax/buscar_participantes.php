<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_participa=intval($_GET['id']);
		$query=mysqli_query($con, "select * from detalle_factura where id_participa='".$id_participa."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM cert_participa WHERE id_participa='".$id_participa."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar este participante.  
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('cedula', 'nombres');//Columnas de busqueda
		 $sTable = "cert_participa";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by nombres";
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
		$reload = './participantes.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th width="10%">Cédula</th>
					<th width="30%">Nombres</th>
					<th width="15%">Teléfono</th>
					<th width="25%">Correo</th>
					<th width="10%">Agregado</th>
					<th width="10%"><span class="pull-right">Acciones</span></th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_participa=$row['id_participa'];
						$cedula=$row['cedula'];
						$nombres=utf8_encode($row['nombres']);
						$telefono=$row['telefono'];
						$correo=$row['correo'];
						$date_added= date('d/m/Y', strtotime($row['date_added']));
					?>
					
					<input type="hidden" value="<?php echo $cedula;?>" id="cedula<?php echo $id_participa;?>">
					<input type="hidden" value="<?php echo $nombres;?>" id="nombres<?php echo $id_participa;?>">
					<input type="hidden" value="<?php echo $telefono;?>" id="telefono<?php echo $id_participa;?>">
					<input type="hidden" value="<?php echo $correo;?>" id="correo<?php echo $id_participa;?>">
				
					<tr>
						
						<td><?php echo str_pad($cedula,8,"0",STR_PAD_LEFT);?></td>
						<td><?php echo $nombres; ?></td>
						<td><?php echo $telefono; ?></td>
						<td><?php echo $correo; ?></td>
						<td><?php echo $date_added; ?></td>
						
						
					<td><span class="pull-right">
					<a href="#" class='btn btn-default btn-xs' title='Editar participante' onclick="obtener_datos('<?php echo $id_participa;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
				    <?php
		        	if ($_SESSION['user_name']=='admin') { ?>
					<a href="#" class='btn btn-default btn-xs' title='Borrar participante' onclick="eliminar('<?php echo $id_participa; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
					<?php } ?>
						
					</tr>
					
					<?php
				}
				?>

					<tr>
						<td colspan=6 class="btn-xs"><span class="pull-right">
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