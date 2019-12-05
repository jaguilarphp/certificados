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
		<div class="modal fade bs-example-modal-lg" id="Modal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Buscar participante</h4>
			  </div>
			  <div class="modal-body">
				<form class="form-horizontal"  method="POST">
				  <div class="form-group">
					<label for="participa" class="col-sm-3 control-label">Participación</label>
					<div class="col-sm-8">
					 <select class="form-control" id="participa" name="participa" onchange="seleccion(this)" required> 
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
				  <div id="nivel" class="form-group" style="display: none;">
					<label for="inivel" class="col-sm-3 control-label">Nivel</label>
						<div class="col-sm-8">
						  <select class="form-control" id="inivel" name="inivel"> 
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
				  <div id="dponencia" class="form-group" style="display: none;">
						<label for="ponencia" class="col-sm-3 control-label">Ponencia</label>
						<div class="col-sm-8">
						<input type="text" class="form-control" id="ponencia" name="ponencia" placeholder="Título de la ponencia o conferencia">
					</div>
				  </div> 
				  <?php								
					} ?>



				  <div class="form-group row">
						<label for="q" class="col-sm-3 control-label">Participante</label>
						<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" id="q" autocomplete="off" placeholder="Cédula o nombre del participante" onkeyup='load(1);'>
							<span class="input-group-btn">
								<button class="btn btn-info" type="button" id="loader1" onclick='load(1);'>
									<i class="glyphicon glyphicon-search"></i>
								</button> </span>
						</div>
					</div>
				  </div>
				</form>
				<div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 80%;display:none;"></div><!-- Carga gif animado -->
				<div class="outer_div" ></div><!-- Datos ajax Final -->
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				
			  </div>
			</div>
		  </div>
		</div>
<?php
	}
?>
<script type="text/javascript">
function seleccion(sel) {
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