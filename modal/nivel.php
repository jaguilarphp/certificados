<?php
$html = "";
if ($_POST["elegido"]==1) {
	$html = '
	<div class="form-group">
		<label for="nivel" class="col-sm-3 control-label">Nivel</label>
	 	<div class="col-sm-8">
			<input type="text" class="form-control" id="nivel" name="nivel" placeholder="Nivel de aprobación">
		</div>
	</div>
	';	
}
echo $html;	
?>

	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script language="javascript">
	$(document).ready(function(){
	    $("#participa").on('change', function () {
	        $("#participa option:selected").each(function () {
	            elegido=$(this).val();
	            $.post("nivel.php", { elegido: elegido }, function(data){
	                $("#nivel").html(data);
	            });			
	        });
	   });
	});
	</script>