<?php
require "inc_config.php";

// dichiarare il percorso dei font
define('FPDF_FONTPATH','./font/');
//questo file e la cartella font si trovano nella stessa directory
require('fpdf.php');





		if (isset($_REQUEST['id_report']))
		  $id_report = mysqli_real_escape_string($link,$_REQUEST['id_report']);
		else
		  $id_report = "";

		if (isset($_REQUEST['id_ticket']))
		  $id_ticket = mysqli_real_escape_string($link,$_REQUEST['id_ticket']);
		else
		  $id_ticket = "";		
	  
		if ($id_report)
		{
		  $query = "
		  SELECT R.id_report, T.id, T.id_cliente, R.id_bollettario, R.progressivo, R.anno, AR.codice_articolo, AR.quantità, B.bollettario, min(DATE_FORMAT(arrivo, '%d-%m-%Y')), C.ragsoc1, C.tipocliente, C.piva, 
		  DATE_FORMAT(T.data_chiamata,'%d%m%Y'), C.indirizzo, C.localita, C.cap, C.tel1, C.email, C.codfisc, C.provincia
		  FROM ticket T
		  LEFT JOIN cliente C on C.id = T.id_cliente
		  LEFT JOIN report R on R.id_ticket = T.id
		  LEFT JOIN articoli_report as AR on AR.id_report = R.id_report
		  LEFT JOIN bollettario B on B.id_bollettario = R.id_bollettario
		  LEFT JOIN att_tecnico AT on AT.id_Report = R.id_report
		  WHERE 1
			AND R.id_report = '$id_report'
		  ";
		  $result = doQuery($query);
		  list($id_report, $id_ticket, $id_cliente, $id_bollettario, $progressivo, $anno, $codice_articolo, $quantità, $bollettario, $arrivo, $ragsoc1, $tipocliente, $piva, $data_chiamata,
		  $indirizzo, $localita, $cap, $tel1, $email, $codfisc, $provincia) = mysqli_fetch_array($result);
		}

		
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image("./img/enneeffe_logo.png", 10,10,-100);
    $this->Image("./img/logo-boumatic.png", 120,10,-150);	
    $this->Image("./img/logo-holme-laue.png", 170,10,-150);	
	
	//Importing Font and it's variations
	$this->AddFont('PTSans','','ptsans.php'); //Regular
	$this->AddFont('PTSans','B','ptsansb.php'); //Bold
	$this->AddFont('PTSans','I','ptsansi.php'); //Italic
	$this->AddFont('PTSans','BI','ptsansbi.php'); //Bold_Italic

	 // PTSans  9
    $this->SetFont('PTSans','',9);	
	$this->Text( 125, 16, 'Mungitura e gestione mandria ad elevate prestazioni' ); 
	
	$this->SetFont('PTSans','B',12);
	$this->Text( 10, 40, 'EnneEffe Srl'); 
	$this->SetFont('PTSans','',11);
	$this->Text( 10, 45, 'Via Seminario, 1 - 26100 Cremona'); 
	$this->Text( 10, 50, 'P.IVA: 00254470198', 0, 0, 'L'); 
	$this->Text( 10, 55, 'Tel. 0372 560902 - info@enneeffe.com'); 
	$this->Text( 10, 60, 'Fax: 0372 560905 - www.enneeffe.com'); 
	


    // Line break
    $this->Ln(20);


}

// Page footer
function Footer()
{
//Stampa footer
$this->SetFont('PTSans','',8);
$this->Text(100,258,'Km. percorsi');
$this->Line(120,258, 140, 258);

$this->Text(150,258,'Ore lavorative');
$this->Line(170,258, 190, 258);

$this->SetXY(100,265);
$this->Cell(45,10,'Firma del conducente',0,0,'C');
$this->Line(105,280, 142, 280);

$this->SetXY(145,265);
$this->Cell(45,10,'Firma del destinatario',0,0,'C');
$this->Line(150,280, 187, 280);


}
}

// Instanciation of inherited class
$p = new PDF();
$p->AliasNbPages();
$p->AddPage();


$p->Text(10,70, 'Cremona,');
$p->SetFont('PTSans','U',14);
$p->Text(27,70,'      ' .$arrivo . '      ');

//Dati cliente
$p->SetFont('PTSans','B',12);
$p->SetXY(120,36);
$p->Cell(80,5,iconv('UTF-8', 'windows-1252', $ragsoc1),0,0,'R');

$p->SetFont('PTSans','',11);
$p->SetXY(120,41);
$p->Cell(80,5,iconv('UTF-8', 'windows-1252', $indirizzo . ', ' . $localita . ' - '. $cap . ' (' . $provincia . ')') ,0,0,'R');

$p->SetXY(120,46);
$p->Cell(80,5,iconv('UTF-8', 'windows-1252', 'P.IVA:  ' . $piva) ,0,0,'R');

$p->SetXY(120,51);
$p->Cell(80,5,iconv('UTF-8', 'windows-1252', 'Tel.  ' . $tel1) ,0,0,'R');

$p->SetXY(120,56);
$p->Cell(80,5,iconv('UTF-8', 'windows-1252', 'Email  ' . $email) ,0,0,'R');

//Fine dati cliente


$p->SetFont('PTSans','B',12);
$p->Text(12,79,'SERVIZIO ASSISTENZA');
$p->Text(12,84,'N.');

$p->SetFont('PTSans','',18);
$p->Text(25,85,$progressivo . '-' . $bollettario);

//Rettangolo servizio assistenza
$p->Line(10,75, 85, 75);
$p->Line(10,75, 10, 86);
$p->Line(57,75, 57, 86);
$p->Line(10,86, 85, 86);
$p->Line(85,75, 85, 86);

$p->SetFont('PTSans','',7);
$p->SetXY(57,75);
$p->Cell(28,11,$tipocliente,0,0,'C');




$p->Text(10,95,'Destinazione Azienda Agricola');
$p->Line(45,95, 195, 95);

//Partita IVA
$p->Text(130,84,'Partita IVA cliente');
$p->SetFont('PTSans','',10);
$p->Text(152,84,'IT' . $piva);


//Creazione Struttura Tabella
$p->Line(10,100, 195, 100);
$p->Line(10,100, 10, 252);
$p->Line(195,100, 195, 252);
$p->Line(35,100, 35, 252);
$p->Line(170,100, 170, 252);


//Tabella Footer
$p->Line(10,252, 10, 285);
$p->Line(195,252, 195, 285);
$p->Line(10,285, 195, 285);

//Creazione righe tabella
$x=108;
    for($i=0;$i<25;$i++){
        $p->Line(10,$x, 195, $x);
		$x = $x + 6;
    }

$p->SetFont('PTSans','',8);
$p->SetXY(10,100);
$p->Cell(25,8,'Quantita\'',0,0,'C');

$p->SetXY(35,100);
$p->Cell(135,8,'DESCRIZIONE DEL GUASTO E DEL MATERIALE IMPIEGATO',0,0,'C');

$p->SetXY(170,100);
$p->Cell(25,8,'Articolo',0,0,'C');


//Stampa dettaglio articoli
	$length = 108;
	$p->SetFont('PTSans','',8);

	  $query = "
      SELECT AR.codice_articolo, A.descrizione, AR.quantità
	  FROM articoli_report AR
	  INNER JOIN articoli A on A.codice_articolo = AR.codice_articolo
	  WHERE 1
		AND AR.id_report = '$id_report'
	  ";
	  $result = doQuery($query);
	  while (list($codice_articolo_t, $descr_art_t, $quantità_t) = mysqli_fetch_array($result))
	  { 
		
		$p->SetXY(10,$length);
		$p->Cell(25,6,$quantità_t,0,0,'C');
		
		$p->SetXY(35,$length);
		$p->Cell(135,6,$descr_art_t,0,0,'L');

		$p->SetXY(170,$length);
		$p->Cell(25,6,$codice_articolo_t,0,0,'C');
		
		
		$length = $length + 6;
  
	  }


//Stampa nomi tecnici

		$p->SetXY(10,255);
		$p->Cell(40,4,'Tecnico',0,0,'C');
		
		$p->SetXY(50,255);
		$p->Cell(20,4,'Arrivo',0,0,'C');

		$p->SetXY(70,255);
		$p->Cell(20,4,'Partenza',0,0,'C');
		

	$length = 259;
	$p->SetFont('PTSans','',6);

	  $query = "
      SELECT T.nome, T.cognome, DATE_FORMAT(AT.arrivo,'%d-%m-%Y %H:%i'), DATE_FORMAT(AT.partenza,'%d-%m-%Y %H:%i')
	  FROM att_tecnico AT
	  INNER JOIN tecnici T on T.id = AT.id_tecnico
	  WHERE 1
		AND AT.id_report = '$id_report'
	  ";
	  $result = doQuery($query);
	  while (list($nome_t, $cognome_t, $arrivo_t, $partenza_t) = mysqli_fetch_array($result))
	  { 
		
	
		$p->SetXY(10,$length);
		$p->Cell(40,4,$nome_t . ' ' . $cognome_t,0,0,'C');
		
		$p->SetXY(50,$length);
		$p->Cell(20,4,$arrivo_t,0,0,'C');

		$p->SetXY(70,$length);
		$p->Cell(20,4,$partenza_t,0,0,'C');
		
		
		$length = $length + 4;
  
	  }


//Calcolo ore lavorative
	$p->SetFont('PTSans','',8);

	  $query = "
      SELECT sum(TIMESTAMPDIFF(MINUTE,arrivo,partenza))
	  FROM att_tecnico AT
	  WHERE 1
		AND AT.id_report = '$id_report'
	  ";
	  $result = doQuery($query);
	  list($durata_t) = mysqli_fetch_array($result);
	  
		 	$hours = floor($durata_t / 60);
			$minutes = $durata_t - $hours*60;
			$minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

	  
$p->SetFont('PTSans','',8);
$p->Text(171,257, $hours . ":" . $minutes);

// email stuff (change data below)
$to = "d.lauria@mottasistemi.it"; 
$cc = "m.bortolin@mottasistemi.it";
$from = "info@enneeffe.com"; 
$subject = "EnneEffe Srl - Servizo di assistenza";
$message = "In allegato il pdf del Servizio di assistenza n.". $progressivo . " del ". $data_chiamata;

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = "ServizioAssistenza_" .$progressivo . "_" . $data_ticket . ".pdf";

// encode data (puts attachment in proper format)
$pdfdoc = $p->Output($filename, "S");
$attachment = chunk_split(base64_encode($pdfdoc));

// main header
$headers  = "From: ".$from.$eol;
$headers .= "CC: ".$cc.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //

$body = "--".$separator.$eol;
$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
$body .= $message.$eol;



// attachment
$body .= "--".$separator.$eol;
$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$body .= "Content-Transfer-Encoding: base64".$eol;
$body .= "Content-Disposition: attachment".$eol.$eol;
$body .= $attachment.$eol;
$body .= "--".$separator."--";

// send message
mail($to, $subject, $body, $headers);


header("location:report.php?ticket_id_ticket=" .  $ticket_id_ticket . "&id_report=" . $id_report . "#articoli_report"); // redirects to all records page
exit;
				
// Senza parametri rende il file al browser
//$p->output('I','ServizioAssistenza_' .$progressivo . '_' . $anno . '.pdf');
?>