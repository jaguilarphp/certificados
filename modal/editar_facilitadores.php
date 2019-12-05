	<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="Modal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar facilitadores</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_facilitador" name="editar_facilitador">
			<div id="resultados_ajax2"></div>
			  <div class="form-group">
				<label for="mod_cedula" class="col-sm-3 control-label">Cédula</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_cedula" name="mod_cedula" placeholder="Cédula del facilitador" <?php if ($_SESSION['user_name']<>'admin'){echo "readonly";}?>>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_titulo" class="col-sm-3 control-label">Título</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_titulo" name="mod_titulo" placeholder="Ej.: Dr., Dra., MSc., Prof.">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_nombres" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nombres" name="mod_nombres" placeholder="Nombre del facilitador" <?php if ($_SESSION['user_name']!='admin'){echo "readonly";}?>>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mod_telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_telefono" name="mod_telefono">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mod_correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_correo" name="mod_correo" placeholder="Correo electrónico del facilitador" required>
				</div>
			  </div>
			  
		      <div class="form-group">
				<label for="mod_firma" class="col-sm-3 control-label">Firma</label>
				<?php
        		if ($_SESSION['user_name']=='admin') {
						$ruta="./firmas";
						if (is_dir($ruta)){
						$gestor = opendir($ruta);
						}	?>
					<div class="col-sm-8">
					  <select class="form-control" id="mod_firma" name="mod_firma">
					  <?php
						while ($archivo = readdir($gestor))  {
							if ($archivo != "." && $archivo != "..") { ?>
								<option value="<?php echo $archivo?>"><?php echo $archivo?></option>;
						<?php							
							}
						}
							closedir($gestor);?>
					  </select>
				  	</div>
				<?php
				} else { ?>
					<div class="col-sm-8">
						  <input type="text" class="form-control" id="mod_firma" name="mod_firma" readonly>
					</div>
				<?php
				} ?>
		  	  </div>

			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>