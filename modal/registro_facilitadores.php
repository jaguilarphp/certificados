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
	<div class="modal fade" id="nuevoFacilitador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo facilitador</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_facilitador" name="guardar_facilitador">
			<div id="resultados_ajax_facilitadores"></div>
			  <div class="form-group">
				<label for="cedula" class="col-sm-3 control-label">Cédula</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula de identidad del facilitador" required>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="titulo" class="col-sm-3 control-label">Título</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Dr., Dra., MSC., Prof.">
				  
				</div>
			  </div>

			  <div class="form-group">
				<label for="nombres" class="col-sm-3 control-label">Nombres</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombre del facilitador" required maxlength="255" >
				  
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Número telefónico del facilitador" required maxlength="255" >
				  
				</div>
			  </div>
			 
				  <div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="correo" name="correo" placeholder="Correo electrónico" required>
				</div>
			  </div>

		      <div class="form-group">
				<label for="firma" class="col-sm-3 control-label">Firma</label>
				<?php
					$ruta="./firmas";
					if (is_dir($ruta)){
					$gestor = opendir($ruta);
				}	?>
				<div class="col-sm-8">
				  <select class="form-control" id="firma" name="firma" required>
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