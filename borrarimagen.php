<?php
$pathimage = $_GET['path'];  
    if (is_file($pathimage))
    { 
      unlink($pathimage);
    }
    else
    {
      echo 'El archivo no existe: ', $pathimage;
    }
 if (strpos($pathimage, 'formatos')) {
 	header("Location: formatos.php");  
 } else {
 	header("Location: firmas.php");  
 }
 
 
?>