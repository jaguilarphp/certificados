<?php
/*------------------------------------
  Autor: José Luis Aguilar Gómez
  Web: pregrado.luz.edu.ve
  Mail: jaguilarphp@gmail.com
  --------------------------------------*/
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	require_once('../libraries/class.phpmailer.php');
	
	include("../libraries/class.smtp.php");
if (isset($_POST['id_cert'])) {
	$id=intval($_POST['id_cert']);

}
$para=mysqli_real_escape_string($con,(strip_tags($_POST["correo"],ENT_QUOTES)));
$nombres=mysqli_real_escape_string($con,(strip_tags(utf8_decode($_POST["nombres"]),ENT_QUOTES)));
$mensaje=$_POST["mensaje2"];
$id_cert=$_POST["id_cert"];

$mail  = new PHPMailer();
$mail->SingleTo = true;

$mail->Host="smtp.gmail.com"; 
$mail->Port=465; 
$mail->SMTPSecure="ssl"; 
$mail->Timeout=20; 
$mail->CharSet = "UTF-8"; 

$mail->IsSMTP();
$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False
$mail->Username = "certificados.ccpluz@gmail.com";
$mail->IsHTML(true); 

// Tu cuenta de e-mail
$mail->Password = "yasmin5064"; // El Password de tu casilla de correos
$mail->From = "certificados.ccpluz@gmail.com";
$mail->FromName = "Consejo Central de Pregrado";
$mail->Subject = "Certificado del Consejo Central de Pregrado";
$mail->AddAddress($para, $nombres);

$mail->WordWrap = 50;


$body = $mensaje;

$mail->Body = $body;


// Notificamos al usuario del estado del mensaje
if (!$mail->Send()){ 
	echo '<script languaje="javasrcript">alert("Error en el envío del correo electrónico.")</script>';
} else {
	echo '<script languaje="javasrcript">alert("Correo electrónico enviado con éxito.")</script>';
}
$mail->ClearAddresses(); 
$mail->ClearAllRecipients()

?>
<script type="text/javascript">
history.back();
</script>