<style type="text/css">
    .zoom{
        /* Aumentamos la anchura y altura durante 2 segundos */
        transition: width 2s, height 2s, transform 2s;
        -moz-transition: width 2s, height 2s, -moz-transform 2s;
        -webkit-transition: width 2s, height 2s, -webkit-transform 2s;
        -o-transition: width 2s, height 2s,-o-transform 2s;
    }
    .zoom:hover{
        /* tranformamos el elemento al pasar el mouse por encima al doble de
           su tamaño con scale(2). */
        transform : scale(2);
        -moz-transform : scale(2);      /* Firefox */
        -webkit-transform : scale(2);   /* Chrome - Safari */
        -o-transform : scale(2);        /* Opera */
    }
</style>
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
		$id_participa=intval($_GET['id']);
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('validador', 'cedula', 'nombres');//Columnas de busqueda
		 $sTable = "cert_cert, cert_participa, cert_evento";
		 $sWhere="";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE cert_cert.id_participa=cert_participa.id_participa and cert_cert.id_evento=cert_evento.id_evento and (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		else {
			$sWhere="WHERE cert_cert.id_participa=cert_participa.id_participa and cert_cert.id_evento=cert_evento.id_evento";
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
					<th width="8%">Cédula</th>
					<th width="23%">Nombres</th>
					<th width="5%">Validador</th>
					<th width="5%">Participación</th>
					<th width="5%">Evento</th>
					<th width="30%">Nombre del evento</th>
					<th width="1%">Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_participa=$row['id_participa'];
						$correo=$row['correo'];
						$id_cert=$row['id_cert'];
						$id_evento=$row['id_evento'];
						$cedula=$row['cedula'];
						$nombres=utf8_encode($row['nombres']);
						$validador=$row['validador'];
						$participa=utf8_encode($row['participa']);
						$tipo_evento=utf8_encode($row['tipo_evento']);
						$nombre_evento=utf8_encode($row['nombre_evento']);
					?>
					
					<input type="hidden" value="<?php echo $cedula;?>" id="cedula<?php echo $id_cert;?>">
					<input type="hidden" value="<?php echo $nombres;?>" id="nombres<?php echo $id_cert;?>">
					<input type="hidden" value="<?php echo $validador;?>" id="validador<?php echo $id_cert;?>">
					<input type="hidden" value="<?php echo $participa;?>" id="participa<?php echo $id_cert;?>">
					<input type="hidden" value="<?php echo $tipo_evento;?>" id="tipo_evento<?php echo $id_cert;?>">
					<input type="hidden" value="<?php echo $nombre_evento;?>" id="nombre_evento<?php echo $id_cert;?>">
					<input type="hidden" value="<?php echo $correo;?>" id="correo<?php echo $id_cert;?>">
					<input type="hidden" value="<?php echo $id_cert;?>" id="id_cert<?php echo $id_cert;?>">
					<input type="hidden" value="<?php echo $id_evento;?>" id="id_evento<?php echo $id_cert;?>">
					
					<tr>
						
						<td><?php echo str_pad($cedula,8,"0",STR_PAD_LEFT);?></td>
						<td><?php echo $nombres; ?></td>
						<td class="zoom"><?php echo $validador; ?></td>
						<td><?php echo cortar_string($participa,12); ?></td>
						<td><?php echo $tipo_evento; ?></td>
						<td><?php echo cortar_string($nombre_evento,50); ?></td>

						<td><span class="pull-right">
							<a href="certificado104.php?id_cert=<?php echo $id_cert;?>&id_evento=<?php echo $id_evento;?>" class='btn btn-default btn-xs' title='Ver certificado' data-toggle="modal" data-target=""><i class="glyphicon glyphicon-eye-open"></i></a> 
							<a href="#" class='btn btn-default btn-xs' title='Enviar correo' onclick="datos_correo('<?php echo $id_cert;?>')" data-toggle="modal" data-target="#EnviarCorreo"><i class="glyphicon glyphicon-envelope"></i></a>
						</td>
						
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