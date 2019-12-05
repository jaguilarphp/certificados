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
	<div class="modal fade" id="EditarCertificado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar certificado</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_certificado" name="editar_certificado">
			  <div class="form-group">
				<label for="mod_cedula" class="col-sm-3 control-label">Cédula</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_cedula" name="mod_cedula" readonly>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_nombres" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nombres" name="mod_nombres" readonly>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="participa" class="col-sm-3 control-label">Participación</label>
				<div class="col-sm-8">
				 <select class="form-control" id="mod_participa" name="mod_participa" onchange="selector(this)" required> 
							<option value="" selected>-- Selecciona tipo de participación --</option>
					<?php
						if ($tipo_evento=="jornada") { ?>
							<option value="participante">Participante</option>
							<option value="autor">Autor</option>
							<option value="coautor">Coautor</option>
							<option value="autora">Autora</option>
							<option value="coautora">Coautora</option>
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
							<option value="coordinador de conversatorio">Coordinador de conversatorio</option>
							<option value="arbitro">Arbitro</option>									
							<option value="organizador">Organizador</option>									
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
			  <div id="nivel" class="form-group" style="display: none;">
				<label for="mod_nivel" class="col-sm-3 control-label">Nivel</label>
					<div class="col-sm-8">
					  <select class="form-control" id="mod_nivel" name="mod_nivel"> 
							<option value="" selected>-- Selecciona tipo de participación --</option>
							<option value="Asistido">Asistencia</option>
							<option value="Resolutivo">Resolutivo</option>
							<option value="Autónomo">Autónomo</option>
							<option value="Autónomo Plus">Autónomo Plus</option>
				  </select>
				</div>
			  </div>
				  <?php								
				if ($tipo_evento=="jornada") { ?>
			  <div id="dponencia" class="form-group" style="display: none;">
					<label for="mod_ponencia" class="col-sm-3 control-label">Ponencia</label>
					<div class="col-sm-8">
					<input type="text" class="form-control" id="mod_ponencia" name="mod_ponencia" placeholder="Título de la ponencia o conferencia">
				</div>
			  </div> 
			  <?php								
				} ?>

			
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

<script type="text/javascript">
function selector(sel) {
	var valor = sel.value;
	var	divNivel = document.getElementById("nivel");
	var	divPonencia = document.getElementById("dponencia");
	switch (valor) {
		case "aprobado":
			divNivel.style.display = "";
			divPonencia.style.display = "none";
			break;
		case "autor":
		case "autora":
		case "coautor":
		case "coautora":
		case "conferencista":
			divNivel.style.display = "none";
			divPonencia.style.display = "";
			break;
		default:
			divNivel.style.display = "none";
			divPonencia.style.display = "none";
			break;
	}
}
</script>