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
<html lang="en">
  <head>
<style type="text/css">
    #uploadPreview1{
    	padding: 2px;
        border: 1px solid #737373;
        height: 70px;
        width: 100px;
        box-shadow: 2px 2px 10px #666;
    }
    #uploadPreview1:hover{ 
    -webkit-transform: scale(1.5);
    transform: scale(1.5)
}
</style>
  </head>
  <body>
	<!-- Modal -->
	<div class="modal fade" id="nuevaFirma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nueva firma</h4>
		  </div>
		  <div class="modal-body">
			<form action="procesarfirma.php" enctype="multipart/form-data" method="post" form class="form-horizontal">
			<div id="resultados_ajax"></div>
                <div class="form-group col-md-12">
                    <div class="col-md-4">
                        <img id="uploadPreview1" class="img-responsive" width="150px" height="105px" src="img/firmaNoDisponible.jpg" />
                    </div>

                    <div class="form-group col-md-8">
                        <label>Archivo de firma</label>
                        <input class='filestyle' data-buttonText="" id="uploadImage1" type="file" name="imagen" onchange="previewImage(1);" />
                    </div>
                </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar archivo</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>
  </body>
</html>

<script>
function previewImage(nb) {        
    var reader = new FileReader();         
    reader.readAsDataURL(document.getElementById('uploadImage'+nb).files[0]);         
    reader.onload = function (e) {             
        document.getElementById('uploadPreview'+nb).src = e.target.result;         
    };     
}  
</script>