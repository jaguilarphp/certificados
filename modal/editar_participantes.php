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
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar participante</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_participante" name="editar_participante">
			<div id="resultados_ajax2"></div>
			  <div class="form-group">
				<label for="mod_cedula" class="col-sm-3 control-label">Cédula</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_cedula" name="mod_cedula" placeholder="Cédula del participante" <?php if ($_SESSION['user_name']<>'admin'){echo "readonly";}?>>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_nombres" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nombres" name="mod_nombres" placeholder="Nombre del participante" <?php if ($_SESSION['user_name']<>'admin'){echo "readonly";}?>>
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
				  <input type="text" class="form-control" id="mod_correo" name="mod_correo" placeholder="Correo electrónico del participante" required>
				</div>
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