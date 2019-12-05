	<?php
	/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
		$tipo_evento=$_SESSION['tipo_evento'];
		if (isset($con))
		{
	?>	
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="EditarCertificado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar certificado</h4>
			  </div>
			  <div class="modal-body">
				<form class="form-horizontal"  method="post" id="editar_certificado" name="editar_certificado">
                  <div id="resultados_ajax2"></div>
				  <div class="form-group">
					<label for="mec_cedula" class="col-sm-3 control-label">Cédula</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mec_cedula" name="mec_cedula" readonly>
						<input type="hidden" name="mec_id" id="mec_id">
					</div>
				  </div>
				  <div class="form-group">
					<label for="mec_nombres" class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mec_nombres" name="mec_nombres" readonly>
					</div>
				  </div>

				  <div class="form-group">
					<label for="mec_participa" class="col-sm-3 control-label">Participación</label>
					<div class="col-sm-8">
					 <select class="form-control" id="mec_participa" name="mec_participa" onchange="seleccione(this)" required> 
								<option value="" selected>-- Selecciona tipo de participación --</option>
						<?php
							if ($tipo_evento=="jornada") { ?>
								<option value="participante">Participante</option>
								<option value="autor">Autor</option>
								<option value="coautor">Coautor</option>
								<option value="autora">Autora</option>
								<option value="coautora">Coautora</option>
								<option value="ponente">Ponente</option>
								<option value="moderador">Moderador</option>
								<option value="moderadora">Moderadora</option>
								<option value="relator">Relator</option>
								<option value="relatora">Relatora</option>
								<option value="expositor">Expositor</option>
								<option value="expositora">Expositora</option>									
								<option value="expositor Autodesarrollo">Expositor Autodesarrollo</option>
								<option value="conferencista">Conferencista</option>
								<option value="apoyo logístico">Apoyo logístico</option>
								<option value="comité organizador">Comité organizador</option>
								<option value="comité ejecutivo">Comité ejecutivo</option>
								<option value="comité académico">Comité académico</option>
								<option value="comité académico internacional">Comité académico internacional</option>
								<option value="coordinador de conversatorio">Coordinador de conversatorio</option>
								<option value="arbitro">Arbitro</option>									
							<?php
							} else { ?>
								<option value="aprobado">Aprobación</option>
								<option value="asistido">Asistencia</option>
								<option value="organizador">Organizador</option>
								<option value="facilitador">Facilitador</option>
								<option value="ponente">Ponente</option>
								<option value="participa en la logística">Logística</option>
							<?php								
							} ?>
					  </select>
					</div>
				  </div>
				  <div id="ecnivel" class="form-group" style="display: none;">
					<label for="mod_nivel" class="col-sm-3 control-label">Nivel</label>
					<div class="col-sm-8">
					  <select class="form-control" id="mec_nivel" name="mec_nivel"> 
							<option value="" selected>-- Selecciona tipo de participación --</option>
								<option value="Preformal">Preformal</option>
								<option value="Receptivo">Receptivo</option>
								<option value="Resolutivo">Resolutivo</option>
								<option value="Autónomo">Autónomo</option>
								<option value="Estratégico">Estratégico</option>
					  </select>
					</div>
				  </div>
					  <?php								
					if ($tipo_evento=="jornada") { ?>
				  <div id="ecponencia" class="form-group" style="display: none;">
						<label for="mec_ponencia" class="col-sm-3 control-label">Ponencia</label>
						<div class="col-sm-8">
						<input type="text" class="form-control" id="mec_ponencia" name="mec_ponencia">
					</div>
				  </div> 
				  <?php								
					} ?>

					  <?php								
					if ($_SESSION['user_name']=='admin') { ?>
				  <div id="ecvalidador" class="form-group" style="display: none;">
						<label for="mec_validador" class="col-sm-3 control-label">Validador</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="mec_validador" name="mec_validador">
					</div>
				  </div> 
				  <?php								
					} ?>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="actualizar_datos2">Actualizar datos</button>
			  </div>
				</form>
			  </div>

			</div>
		  </div>
		</div>
<?php
	}
?>
<script type="text/javascript">
function seleccione(sel) {
	var valore = sel.value;
	var	divEcNivel = document.getElementById("ecnivel");
	var	divEcPonencia = document.getElementById("ecponencia");
	switch (valore) {
		case "aprobado":
			divEcNivel.style.display = "";
			divEcPonencia.style.display = "none";
			break;
		case "autor":
		case "autora":
		case "coautor":
		case "coautora":
		case "conferencista":
			divEcNivel.style.display = "none";
			divEcPonencia.style.display = "";
			break;
		default:
			divEcNivel.style.display = "none";
			divEcPonencia.style.display = "none";
			break;
	}
}
</script>