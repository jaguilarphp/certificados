<?php
 	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
 
	// Ruta donde se guardarán las imágenes
	$directorio = $_SERVER['DOCUMENT_ROOT'].'/certificados/firmas/';
 
	// Recibo los datos de la imagen
	$nombre = $_FILES['imagen']['name'];
	$tipo = $_FILES['imagen']['type'];
	$tamano = $_FILES['imagen']['size'];
 
	// Muevo la imagen desde su ubicación
	// temporal al directorio definitivo
	move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre);

 // Guardamos en la BBDD
//	$sql = "INSERT into clientes (nombre_cliente) values ('$nombre')";
//	$resultado = mysql_query($sql);
 
	// Por si queremos la ID asignada a la imagen
//	$id = mysql_insert_id();
header("Location: firmas.php"); 
?>
