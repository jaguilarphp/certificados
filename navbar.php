	<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
  	if (isset($title))
		{
	?>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img align="bottom" src="./img/logocert.png"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php echo $active_participantes;?>"><a href="participantes.php"><i class='glyphicon glyphicon-list-alt'></i> Participantes</a></li>
        <li class="<?php echo $active_facilitadores;?>"><a href="facilitadores.php"><i class='glyphicon glyphicon-list-alt'></i> Facilitadores</a></li>
        <li class="<?php echo $active_formatos;?>"><a href="formatos.php"><i class='glyphicon glyphicon-picture'></i> Formatos <span class="sr-only">(current)</span></a></li>
        <li class="<?php echo $active_firmas;?>"><a href="firmas.php"><i class='glyphicon glyphicon-barcode'></i> Firmas</a></li>
        <li class="<?php echo $active_eventos;?>"><a href="eventos.php"><i class='glyphicon glyphicon-pushpin'></i> Eventos</a></li>
        <li class="<?php echo $active_validador;?>"><a href="validador.php"><i class='glyphicon glyphicon-qrcode'></i> Validador</a></li>
        <?php
        if ($_SESSION['user_name']=='admin') { ?>
                  <li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-user'></i> Usuarios</a></li>
   <?php  } ?>
       </ul>
        <ul class="nav navbar-nav navbar-right">
        <li><a><i class='glyphicon glyphicon-user'></i> <?php echo $_SESSION['user_name'];?></a></li>
        <li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  <?php
    }
  ?>