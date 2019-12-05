	<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
 	if(!empty($_GET['imgFormato'])) {
 		$mod_imgFormato=$_GET['imgFormato'];}
 	if(!empty($_GET['facilitador'])) {
 		alert(facilitador);
 	}
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
    #mod_imgFormato{
    	padding: 2px;
        border: 1px solid #737373;
        height: 70px;
        width: 100px;
        box-shadow: 2px 2px 10px #666;
    }
    #mod_imgFormato:hover{ 
    -webkit-transform: scale(1.5);
    transform: scale(1.5)
}
</style>
</head>

<body>

	<!-- Modal -->
	<div class="modal fade" id="Modal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar evento</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_evento" name="editar_evento">
			<div id="resultados_ajax2"></div>

              <div class="row">
              	  <label for="mod_tipo_evento" class="col-sm-3 control-label">Tipo</label>
                  <div class="col-sm-3 row align-items-center">
                      <div class="form-group"  style="margin-left:12%;">
						 <select class="form-control" id="mod_tipo_evento" name="mod_tipo_evento" required>
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
								<input type="text" class="form-control" id="mod_fecha_evento" name="mod_fecha_evento" placeholder="Fecha" readonly>
								<span class="input-group-addon  btn btn-info"><span class="glyphicon glyphicon-calendar"></span></span>				  
							</div>
			 			</div>
                  </div>
              </div>

			   <div class="form-group">
				<label for="mod_nombre_evento" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nombre_evento" name="mod_nombre_evento" placeholder="Nombre del evento" required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mod_fechaletras" class="col-sm-3 control-label">Fecha (letras)</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_fechaletras" name="mod_fechaletras" placeholder="Ej. 23 y 24 de abril de 2019" required>
				</div>
			  </div>

			  <div class="row">
			  	  <div for="mod_imgFormato" class="col-sm-3"  style="margin-left:3%;">
                        <img width="100px" height="70px" id="mod_imgFormato" name="mod_imgFormato" title=""/>
                  </div> 
                  <div class="col-sm-3 row align-items-center">
                      <div class="form-group" style="margin-left:-2%;">

						<label for="formato" class="col-sm-3 control-label">Formato</label>
						<?php
							$gestor = opendir("./formatos");
						?>
						  <select class="form-control" id="mod_formato" name="mod_formato" onchange="editar(this)" required>
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
					<label for="mod_duracion" class="col-sm-3 control-label">Duración</label>
					<div class="col-sm-4" style="margin-left:8%;">
					  <input type="text" class="form-control" id="mod_duracion" name="mod_duracion" placeholder="40 horas" required>
					</div>
				  </div>
              </div>

			  <div class="form-group">
				<label for="mod_facilitador" class="col-sm-3 control-label">Facilitador</label>
				<?php
					$query=mysqli_query($con, "SELECT id_facilita, nombres, titulo FROM cert_facilita order by id_facilita");
				?>
				<div class="col-sm-8">
				  <select class="form-control" id="mod_facilitador" name="mod_facilitador" onchange="mostrarId(this)" required>
				 	<?php
				 		while ($row = mysqli_fetch_assoc($query)) { ?>
							<option value="<?php echo ($row['id_facilita']);?>"><?php echo ($row['titulo']);?> <?php echo utf8_encode($row['nombres']); ?></option>
							<?php
					}
					?>
				  </select>
				</div>
			  </div>

  				  <div class="form-group" style="display: none;">
					<label for="mod_id_facilita" class="col-sm-2 control-label">Id facilita</label>
					<div class="col-sm-3" style="margin-left:2%;">
					  <input type="text" class="form-control" id="mod_id_facilita" name="mod_id_facilita" placeholder="40 horas" required>
					</div>
				  </div>



		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos2">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>
<script type="text/javascript">
	function mostrarId(sel) {
		document.getElementById('mod_id_facilita').value = sel.value;
	}

	function editar(sel) {
		document.getElementById('mod_imgFormato').src = "./formatos/" + sel.value;
	}

</script>

<script type="text/javascript" src="./js/jquery.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<script type="text/javascript">
	$('.form_date').datetimepicker({
        language:  'es',
        format:"yyyy-mm-dd",
		todayBtn: true,
		pickerPosition:"bottom left",
        format:"yyyy-mm-dd",
		todayBtn: true,
		pickerPosition:"bottom left"
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 1
    });
</script>
</body>
</html>