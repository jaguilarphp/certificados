
	$(document).ready(function(){
		load(1);
		$( "#resultados" ).load( "ajax/buscar_certificados.php" );
	});

	function load(page){
		var q= $("#q").val();
		$("#loader").fadeIn('slow');
		$.ajax({
			url:'./ajax/listar_participantes.php?action=ajax&page='+page+'&q='+q,
			 beforeSend: function(objeto){
			 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
		  },
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$('#loader').html('');
				
			}
		})
	}

	function agregar (id)
		{
			var participa=$("#participa").val();
			var nivel=$("#inivel").val();
			var ponencia=$("#ponencia").val();
			$.ajax({
        type: "POST",
        url: "./ajax/buscar_certificados.php",
        data: {id:id,participa:participa,nivel:nivel,ponencia:ponencia},
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});
		}
		
	function eliminar (id)
		{
			
			$.ajax({
        type: "GET",
        url: "./ajax/buscar_certificados.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}
		

		



