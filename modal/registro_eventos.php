	<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
		if (isset($con))
		{
	?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <style type="text/css">
    #imgFormato{
    	padding: 2px;
        border: 1px solid #737373;
        height: 70px;
        width: 100px;
        box-shadow: 2px 2px 10px #666;
    }
    #imgFormato:hover{ 
    -webkit-transform: scale(1.5);
    transform: scale(1.5)
}
</style>
</head>

<body>

	<!-- Modal -->
	<div class="modal fade" id="nuevoEvento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo evento</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_evento" name="guardar_evento">
			<div id="resultados_ajax_eventos"></div>

              <div class="row">
              	  <label for="estado" class="col-sm-3 control-label">Tipo</label>
                  <div class="col-sm-3 row align-items-center">
                      <div class="form-group"  style="margin-left:12%;">
						 <select class="form-control" id="tipo_evento" name="tipo_evento" required>
							<option value="">-- Selecciona tipo --</option>
							<option value="taller" selected>Taller</option>
							<option value="curso">Curso</option>
							<option value="simposio">Simposio</option>
							<option value="jornada">Jornada</option>
							<option value="congreso">Congreso</option>							
						  </select>
                      </div>
                  </div>

                  <div class="col-sm-5 col-sm-offset-1">
 			  			<div class="form-group"  style="margin-right:10%;">
			                <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-format="yyyy-mm-dd">
								<input type="text" class="form-control" id="fecha_evento" name="fecha_evento" placeholder="Fecha" readonly>
								<span class="input-group-addon  btn btn-info"><span class="glyphicon glyphicon-calendar"></span></span>				  
							</div>
			 			</div>
                  </div>
              </div>

			  <div class="form-group">
				<label for="nombres" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="nombre_evento" name="nombre_evento" placeholder="Nombre del evento" required maxlength="255" >
				</div>
			  </div>

			  <div class="form-group">
				<label for="fechaletras" class="col-sm-3 control-label">Fecha (letras)</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="fechaletras" name="fechaletras" placeholder="Ej. los dias 27 y 28 de abril de 2019" required>
				</div>
			  </div>

              <div class="row">
                  <div class="col-sm-3" style="margin-left:3%;">
                              <img src="./img/Z01.jpg" width="100px" height="70px" id="imgFormato" title=""/>
                  </div>
                  <div class="col-sm-3 row align-items-center">
                      <div class="form-group" style="margin-left:-2%;">

						<label for="formato" class="col-sm-3 control-label">Formato</label>
						<?php
							$gestor = opendir("./formatos");
						?>
						  <select class="form-control" id="formato" name="formato" onchange="mostrar(this)" required>
						  <?php
							while ($archivo = readdir($gestor))  {
								if ($archivo != "." && $archivo != "..") { ?>
									<option value="<?php echo $archivo?>"><?php echo substr($archivo, 0, 3)?></option>;
							<?php							
								}
							}
								closedir($gestor);?>
						  </select>
			             
                      </div>
                  </div>

			      <div class="form-group">
					<label for="duracion" class="col-sm-3 control-label">Duración</label>
					<div class="col-sm-4" style="margin-left:8%;">
						<input type="text" class="form-control" id="duracion" name="duracion" placeholder="Ej. 40 horas" required>
					</div>
				  </div>
              </div>


			  <div class="form-group">
				<label for="id_facilita" class="col-sm-3 control-label">Facilitador</label>
				<?php
					$query=mysqli_query($con, "SELECT id_facilita, nombres, titulo FROM cert_facilita order by nombres");
				?>
				<div class="col-sm-8">
				  <select class="form-control" id="id_facilita" name="id_facilita" required>
				 	<?php
				 		while ($row = mysqli_fetch_assoc($query)) { ?>
							<option value="<?php echo ($row['id_facilita']);?>"><?php echo ($row['titulo']);?> <?php echo utf8_encode($row['nombres']); ?></option>
							<?php
					}
					?>
				  </select>
				</div>
			  </div>
	  </div>

		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

<script type="text/javascript" src="./js/jquery.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<script type="text/javascript">
	$('.form_date').datetimepicker({
        language:  'es',
		format:"yyyy-mm-dd",
		todayBtn: true,
		pickerPosition:"bottom left",
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 1
    });

	function mostrar(sel) {
		document.getElementById('imgFormato').src = "./formatos/" + sel.value;
	}
</script>
</body>
</html>