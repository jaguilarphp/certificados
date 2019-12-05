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
	<div class="modal fade" id="EnviarCorreo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-envelope'></i> Enviar correo</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="enviar_correo" action="./ajax/ajax_correo.php" name="enviar_correo">
			<div id="resultados_ajax2"></div>

			   <div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Para:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="correo" name="correo" readonly>
				  <input type="hidden" name="nombres" id="nombres">
				  <input type="hidden" name="id_cert" id="id_cert">
				  <input type="hidden" name="mensaje2" id="mensaje2">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="asunto" class="col-sm-3 control-label">Asunto:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="asunto" name="asunto">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mensaje" class="col-sm-3 control-label">Mensaje</label>
				<div class="col-sm-8" id="mensaje">
				</div>
			  </div>

			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="ajax_correo">Enviar</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>
