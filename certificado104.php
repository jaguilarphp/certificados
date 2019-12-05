<?php 
 error_reporting(1);
 ini_set("memory_limit","256M");  

/* Connect To Database*/
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

 require_once('tcpdf/config/lang/eng.php');
 require_once('tcpdf/tcpdf.php');
// require_once('func.php');

	$id_cert=intval($_GET['id_cert']);
	$id_evento=intval($_GET['id_evento']);

    class MYPDF extends TCPDF {   
  	//Page header   
  	  public function Header() {	
  		global $ci,$nombres;
        $style6 = array('width' => 0.2, 'cap' => 'but', 'join' => 'miter', 'dash' => '0', 'color' => array(129,181,238));
  		$this->SetFont('helvetica', 'BU', 12);
  		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
  		//$img_file = './104/certificado108.jpg';
  				
  	  }
  	
    }

  $pdf = new MYPDF('L', PDF_UNIT,'letter', true, 'UTF-8', false);

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Unidad de Teleinformática');
  $pdf->SetTitle('Certificados');
  $pdf->SetSubject('Credencial');
  $pdf->SetDisplayMode('real','default'); 
  $pdf->setFontSubsetting(false); 
  
  $pdf->SetMargins(5, 50, 5);
  $pdf->SetAutoPageBreak(TRUE, 10);  
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  $pdf->Addpage();     
  $pdf->SetFontSize(9);


if (!empty($id_cert)) {
    $verbo= "haber";
    $articulo="el";
    $campos="cert_cert.id_cert, cert_participa.cedula, cert_participa.nombres, cert_cert.participa, cert_evento.tipo_evento, 
    		cert_evento.nombre_evento, cert_evento.fechaletras, cert_evento.duracion, cert_evento.formato, 
    		cert_cert.nivel_ponencia, cert_facilita.firma, cert_facilita.titulo, cert_facilita.nombres as facilitador,
    		cert_cert.validador, cert_cert.tipo_firmas, cert_evento.fecha_evento";
   	$tablas="cert_cert, cert_participa, cert_evento, cert_facilita";
    $query="SELECT $campos FROM $tablas WHERE cert_cert.id_cert=$id_cert AND cert_cert.id_participa=cert_participa.id_participa
			AND cert_cert.id_evento=cert_evento.id_evento AND cert_evento.id_facilita=cert_facilita.id_facilita";
	$sql_cert=mysqli_query($con,$query);
	$count=mysqli_num_rows($sql_cert);

	if ($count==1)
	{
			$row=mysqli_fetch_array($sql_cert);
			$nombres=utf8_encode($row['nombres']);
			$cedula=$row['cedula'];
			$participa=utf8_encode($row['participa']);
			$tipo_evento=utf8_encode($row['tipo_evento']);
			$nombre_evento=utf8_encode($row['nombre_evento']);
			$fechaletras=utf8_encode($row['fechaletras']);
			$duracion=utf8_encode($row['duracion']);
			$formato=$row['formato'];
			$nivel_ponencia=utf8_encode($row['nivel_ponencia']);
			$tipo_firmas=$row['tipo_firmas'];
			$firma=$row['firma'];
			$facilitador=utf8_encode($row['titulo']." ".$row['facilitador']);
			$validador=$row['validador'];
			$fecha=$row['fecha_evento'];
	}

 // imprime imagen de fondo----------------------------------	 
        $img_file = './formatos/'.$formato;
 		$pdf->Image($img_file, 0, 0, 280, 217, '', '', '', false, 960, '', false, false, 0); 

$string = $formato;
$y=50;
switch ($string[0]) {
	case 'A':
		$x=50;
		$hx=0;
		break;
	case 'B':
		$x=100;
		$hx=100;
		break;
	case 'C':
		$x=15;
		$hx=-70;
		break;
	
	default:
		# code...
		break;
}
 // imprime primera linea------------------------------------	   
       $pdf->SetTextColor(0,32,96) ;
       $pdf->SetXY($x,$y);
       $pdf->SetFont('helvetica', 'B', 25);
       $pdf->Cell(170,5,"Otorga el presente certificado a:",0,1,C);
 // imprime segunda linea (nombre)---------------------------
       	$y = $y + 14;
       	$longnombre = strlen($nombres);
       	switch ($longnombre) {
       		case $longnombre<=28:
       			$pdf->SetFont('dejavuserifb', 'B', 28);
       			break;
       		case $longnombre>28 && $longnombre<=31:
       			$pdf->SetFont('dejavuserifb', 'B', 26);
       			break;
       		case $longnombre>31 && $longnombre<=34:
       			$pdf->SetFont('dejavuserifb', 'B', 23);
       			break;
       		case $longnombre>34 && $longnombre<=40:
       			$pdf->SetFont('dejavuserifb', 'B', 20);
       			break;
       		case $longnombre>40 && $longnombre<=46:
       			$pdf->SetFont('dejavuserifb', 'B', 18);
       			break;
       		case $longnombre>46:
       			$pdf->SetFont('dejavuserifb', 'B', 18);
       			$nombres="El nombre es demasiado largo";
       			break;
       	}
       	$html .= '<div><span stroke="0.2" fill="true" strokecolor="#03056A" color="#1E81E3">'.$nombres.'</span><br /></div>';
// output the HTML content
	    $pdf->writeHTMLCell(0,0,$hx, $y, $html, 0, 2, false, true, 'C', true);
// imprime tercera linea (cedula)----------------------------
	    $y = $y + 14;
       if ($cedula > 1000) {
	       $pdf->SetTextColor(255,0,0) ;
	       $pdf->SetXY($x+20,$y);
	       $pdf->SetFont('helvetica', '', 14); 
	       $pdf->Cell(130,5,"C.I. ".$cedula,0,0,C);
	       $y=$y + 7;
       } else {
		   $y = $y;	      
       }
// Selecciona $verbo y $articulo)------------------------      
switch ($participa) {
	case 'facilitador':
	case 'organizador':
	case 'ponente': 
		$verbo="ser";
		$articulo="del";
		break;
	case 'aprobado':
		$verbo="haber";
		$articulo="el";
		break;
	case 'asistido':
		$verbo="haber";
		$articulo="al";
		break;
	case 'participado en la logística':
		$verbo="haber";
		$articulo="del";
		break;
	case 'comite organizador'||'comite ejecutivo':
	case 'conferencista':
	case 'moderador'||'moderadora':
	case 'relator'||'relatora':
	case 'arbitro':
	case 'expositor':
	case 'expositor Autodesarrollo':
	case 'autor'||'autora':
	case 'coautor'||'coautora':
	case 'participante':
	case 'apoyo logístico':
	case 'patrocinador':
		$verbo="haber asistido en calidad de";
		break;
}
// imprime cuarta linea (Por haber...)------------------------ 
       $pdf->SetTextColor(0,32,96) ;
       $pdf->SetFont('helvetica', '', 18);
       $pdf->SetXY($x+25,$y);
 
       switch ($tipo_evento) {
       	case 'jornada':
        	$pdf->Cell(120,5,"Por ".$verbo." ".$participa.",",0,0,'C');
       		break;       		
       	case 'congreso':
        	$pdf->Cell(120,5,"Por ".$verbo." ".$participa.",",0,0,'C');
       		break;
       	default:
       		$pdf->Cell(120,5,"Por ".$verbo." ".$participa." ".$articulo." ".$tipo_evento.":",0,0,'C');
       		break;
       }
 //imprime la quinta linea --> titulo del curso, taller... 	
 		$y = $y + 10;
 	   	$cadena = $nombre_evento;
       switch ($tipo_evento) {
	   	case 'jornada':
   	 	   if ($participa=='organizador') {
   	 	   		$articulo="de la ";
	 	   } else {
	   	   	$articulo="a la ";
	 	   }
	   	   	$realizado="realizada";
	   		break;
	   	case 'congreso':
   	 	   if ($participa=='organizador') {
   	 	   		$articulo="del ";
	 	   } else {
	   	   	$articulo="al ";
	   	   }
	 	   	$realizado="realizado";
	   		break;
	   	default:
	   	   	$articulo="";
	   	   	$realizado="realizado";
			break;   		
        }
 	   function contarpalabras($cadena)
	   {
	   	$cadena = explode(" ", $cadena);
	   	return count($cadena);	
	   }
	   $mitad = ceil(contarpalabras($cadena) / 2);
	   $tercio = ceil(contarpalabras($cadena) / 3);
	   $pdf->SetTextColor(0,0,0);
	   $palabra = explode(" ",$cadena);
	   $longitud = strlen($cadena);

	   switch ($longitud) {
	   	case $longitud<=57:
	   	    $unalinea="SI";
	   		$linea1=$cadena;
	   		$pdf->SetXY($x,$y);
      		$pdf->Cell(170,5,$articulo.$linea1,0,0,'C');
			$y= $y + 12;
 	   		break;
	   	case $longitud>57 && $longitud<=114:
 	   		$i=0;
		   	$linea1=" ";
		   	$linea2=" ";
			while ($i < $mitad ) {
	    	$linea1=$linea1.$palabra[$i++]." ";  
			}
			$i=$mitad;
			while ($i <= contarpalabras($cadena)) {
	    	$linea2=$linea2.$palabra[$i++]." ";  
			}
			$pdf->SetXY($x+10,$y);
      		$pdf->Cell(150,5,$articulo.$linea1,0,0,'C');
      		$pdf->SetXY($x+10,$y+7);
      		$pdf->Cell(150,5,$linea2,0,0,'C');
      		$y= $y + 18;
	   		break;
	   	case $longitud > 100:
	   		$i=0;
		   	$linea1=" ";
		   	$linea2=" ";
		   	$linea3=" ";
		   	//$pdf->Cell(30,5,3,0,1,C);
			while ($i <= $tercio ) {
	    	$linea1=$linea1.$palabra[$i++]." ";  
			}
			$i=$tercio + 1;
			while ($i <= 2 * $tercio) {
	    	$linea2=$linea2.$palabra[$i++]." ";  
			}
			$i= (2 * $tercio) + 1;
			while ($i <= contarpalabras($cadena)) {
	    	$linea3=$linea3.$palabra[$i++]." ";  
			}
			$pdf->SetXY($x+10,$y);
      		$pdf->Cell(150,5,$articulo.$linea1,0,0,'C');
      		$pdf->SetXY($x+10,$y+7);
      		$pdf->Cell(150,5,$linea2,0,0,'C');
      		$pdf->SetXY($x+10,$y+14);
      		$pdf->Cell(150,5,$linea3,0,0,'C');
      		$y= $y + 24;
	   }
 //imprime la sexta linea --> realizado en fecha...----------------
      // $pdf->SetXY($x,100);   
       $pdf->SetTextColor(0,32,96) ;
       $pdf->SetFont('helvetica', '', 18);
       $pdf->SetXY($x,$y);
       $pdf->Cell(170,1,$realizado." ".$fechaletras.",",0,0,'C'); 
//imprime la septima linea --> En maracaib/duracion...----------------
       $pdf->SetTextColor(0,32,96) ;
       $pdf->SetFont('helvetica', '', 18);
       $pdf->SetXY($x,$y+8);
       $pdf->Cell(170,1,"en Maracaibo estado Zulia. Duración: ".$duracion,0,0,'C'); 
//imprime la octava linea --> Nivel de aprobación...------------------
if ($participa=='autor' or $participa=='autora' or $participa=='coautor' or $participa=='coautora') {
       	$aprobacion="Trabajo científico: ";
} else {
	if ($participa=='aprobado' AND !empty($nivel_ponencia)) {
       	$aprobacion="Nivel de aprobación: ";
	} else {
       	$aprobacion="";
	}
}
       $pdf->SetTextColor(0,0,0) ;
       $pdf->SetFont('helvetica', '', 14);
       $pdf->SetXY($x,$y+18);
   	   $cadena = $aprobacion.$nivel_ponencia;
	   $mitad = ceil(contarpalabras($cadena) / 2);
	   $tercio = ceil(contarpalabras($cadena) / 3);
	   $pdf->SetTextColor(0,0,0);
	   $palabra = explode(" ",$cadena);
	   $longitud = strlen($cadena);

	   switch ($longitud) {
	   	case $longitud<=57:
	   	    $unalinea="SI";
	   		$linea1=$cadena;
	   		$pdf->SetXY($x,$y+18);
      		$pdf->Cell(170,5,$linea1,0,0,'C');
			$y= $y + 12;
 	   		break;
	   	case $longitud>57 && $longitud<=114:
 	   		$i=0;
		   	$linea1=" ";
		   	$linea2=" ";
			while ($i < $mitad ) {
	    	$linea1=$linea1.$palabra[$i++]." ";  
			}
			$i=$mitad;
			while ($i <= contarpalabras($cadena)) {
	    	$linea2=$linea2.$palabra[$i++]." ";  
			}
			$pdf->SetXY($x+10,$y+18);
      		$pdf->Cell(150,5,$linea1,0,0,'C');
      		$pdf->SetXY($x+10,$y+24);
      		$pdf->Cell(150,5,$linea2,0,0,'C');
      		$y= $y + 18;
	   		break;
	   	case $longitud > 100:
	   		$i=0;
		   	$linea1=" ";
		   	$linea2=" ";
		   	$linea3=" ";
		   	//$pdf->Cell(30,5,3,0,1,C);
			while ($i <= $tercio ) {
	    	$linea1=$linea1.$palabra[$i++]." ";  
			}
			$i=$tercio + 1;
			while ($i <= 2 * $tercio) {
	    	$linea2=$linea2.$palabra[$i++]." ";  
			}
			$i= (2 * $tercio) + 1;
			while ($i <= contarpalabras($cadena)) {
	    	$linea3=$linea3.$palabra[$i++]." ";  
			}
			$pdf->SetXY($x+10,$y+18);
      		$pdf->Cell(150,5,$linea1,0,0,'C');
      		$pdf->SetXY($x+10,$y+24);
      		$pdf->Cell(150,5,$linea2,0,0,'C');
      		$pdf->SetXY($x+10,$y+30);
      		$pdf->Cell(150,5,$linea3,0,0,'C');
      		$y= $y + 24;
	   }


/*       $pdf->MultiCell(170, 5, $aprobacion.$nivel_ponencia, 1, 'C', 0, 0, '', '', true);
*////imprime las firmas-------------------------------------------------- 
       switch ($tipo_firmas) {
       	case 1:
			$pdf->Image('./firmas/judithaular.png',$x+51,144,0,0,'PNG');
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetXY($x+55,165);
			$pdf->Cell(50,5,"Dra. Judith Aular de Duran",0,1,'C'); 
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetXY($x+55,170);
			$pdf->Cell(50,5,"Vicerrectora académica",0,1,'C');
       		break;
       	case 2:
			$pdf->Image('./firmas/judithaular.png',$x-4,144,0,0,'PNG');
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetXY($x,165);
			$pdf->Cell(50,5,"Dra. Judith Aular de Duran",0,1,'C'); 
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetXY($x,170);
			$pdf->Cell(50,5,"Vicerrectora académica",0,1,'C');
			//-----------------------------------
			$pdf->Image('./firmas/yasmilenavarro.png',$x+112,144,0,0,'PNG');
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetXY($x+115,165);
			$pdf->Cell(50,5,"Dra. Yasmile Navarro",0,1,'C'); 
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetXY($x+115,170);
			$pdf->Cell(50,5,"Coordinadora del Consejo Central de Pregrado",0,1,'C');
		     break;
       	case 3:
			$pdf->Image('./firmas/judithaular.png',$x-8,144,0,0,'PNG');
			$pdf->Image('./firmas/yasmilenavarro.png',$x+55,144,0,0,'PNG');
			$pdf->Image('./firmas/'.$firma,$x+118,144,0,0,'PNG');
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetXY($x-10,165);
			$pdf->Cell(60,5,"Dra. Judith Aular de Duran",0,1,'C'); 
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetXY($x-10,170);
			$pdf->Cell(60,5,"Vicerrectora académica",0,1,'C');
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetXY($x+55,165);
			$pdf->Cell(60,5,"Dra. Yasmile Navarro",0,1,'C'); 
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetXY($x+53,170);
			$pdf->Cell(60,5,"Coordinadora del Consejo Central de Pregrado",0,1,'C');
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetXY($x+117,165);
			$pdf->Cell(60,5,$facilitador,0,1,'C'); 
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetXY($x+117,170);
			$pdf->Cell(60,5,"Facilitador",0,1,'C');
       		break;
        case 4:
			$pdf->Image('./firmas/yasmilenavarro.png',$x-14,149,0,0,'PNG');
			$pdf->Image('./firmas/irenekunath.png',$x+50,149,0,0,'PNG');
			$pdf->Image('./firmas/'.$firma,$x+114,149,0,0,'PNG');
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetXY($x-10,170);
			$pdf->Cell(50,5,"Dra. Yasmile Navarro",0,1,'C'); 
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetXY($x-10,175);
			$pdf->Cell(50,5,"Coordinadora de Consejo Central de Pregrado",0,1,'C');
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetXY($x+55,170);
			$pdf->Cell(50,5,"Dra. Irene Kunath",0,1,'C'); 
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetXY($x+53,175);
			$pdf->Cell(50,5,"Coordinadora de Gestión Académica",0,1,'C');
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetXY($x+117,170);
			$pdf->Cell(50,5,utf8_encode($facilitador),0,1,'C'); 
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetXY($x+117,175);
			$pdf->Cell(50,5,"Facilitador",0,1,'C');
       		break;
       }
//imprime validador--------------------------------------------------       
	       $pdf->SetFont('helvetica', '', 12);
	       $pdf->SetTextColor(255,0,0) ; 
	       $pdf->SetXY($x+115,185);
	       $pdf->Cell(50,5,"Validador: ".$validador,0,1,'C');
//imprime Maracaibo, fecha--------------------------------------------              
  	    	setlocale(LC_ALL,"es_VE.UTF-8","es_VE","esp");
	    	$cfecha = strftime("%d de %B de %Y", strtotime($fecha));
        	$pdf->SetTextColor(0,0,0);
        	$pdf->SetFont('helvetica', '', 12);
       		$pdf->SetXY(110,210);
       		$pdf->Cell(50,1,"Maracaibo, ".utf8_encode($cfecha),0,1,'C');     

} else {
     $pdf->Cell(180,5,"Error: No se encontraron datos   ",0,1,'R');
   }     
    $pdf->lastPage();
    $pdf->Output('credencial','I'); 
 ?>

