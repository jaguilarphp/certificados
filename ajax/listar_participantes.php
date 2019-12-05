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
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
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
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table"  style="width: 90%;margin-left: 5%">
				<tr  class="info">
					<th class='col-xs-1'>
					<th>Cédula</th>
					<th>Nombres</th>
					<th class='text-center'>Agregar</th>
					<th class='col-xs-1'>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$id_participa=$row['id_participa'];
					$cedula=$row['cedula'];
					$nombres=utf8_encode($row['nombres']);
					?>
					<tr>
						<td class='col-xs-1'>
						<td><?php echo str_pad($cedula,8,"0",STR_PAD_LEFT);?></td>
						<td><?php echo $nombres; ?></td>
						<td class='text-center'><a class='btn btn-xs btn-info'href="#" onclick="agregar('<?php echo $id_participa ?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
						<td class='col-xs-1'>
					</tr>
					<?php
				}
				?>

			  </table>
			</div>
			<?php
		}
	}
?>