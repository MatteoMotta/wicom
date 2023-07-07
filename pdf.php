<?php
require "inc_config.php";

// dichiarare il percorso dei font
define('FPDF_FONTPATH','./font/');
//questo file e la cartella font si trovano nella stessa directory
require('fpdf.php');






		if (isset($_REQUEST['id_offerta']))
		  $id_offerta = mysqli_real_escape_string($link,$_REQUEST['id_offerta']);
		else
		  $id_offerta = "";

	
	  
		if ($id_offerta)
		{
		  $query = "
		  SELECT O.num_doc, O.anno, O.data_doc, O.id_cliente, O.note, C.ragsoc1, C.titolo, C.nome, C.cognome, C.localita, C.indirizzo, C.provincia, C.cap, C.tel1, C.email, O.riferimento
		  FROM offerta O
		  LEFT JOIN cliente C on C.id = O.id_cliente
		  WHERE 1
			AND O.id = '$id_offerta'
		  ";
		  $result = doQuery($query);
		  list($num_doc, $anno, $data_doc, $id_cliente, $note, $ragsoc1, $titolo, $nome, $cognome, $localita, $indirizzo, $provincia, $cap, $tel1, $email, $riferimento) = mysqli_fetch_array($result);
		}

		
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image("./img/logo-wicom.png", 20,15,50);
	
	//Importing Font and it's variations
	$this->AddFont('PTSans','','ptsans.php'); //Regular
	$this->AddFont('PTSans','B','ptsansb.php'); //Bold
	$this->AddFont('PTSans','I','ptsansi.php'); //Italic
	$this->AddFont('PTSans','BI','ptsansbi.php'); //Bold_Italic
	
	global $ragsoc1;
	global $indirizzo;
	global $cap;
	global $localita;
	global $provincia;
	global $titolo;
	global $nome;
	global $cognome;
	global $data_doc;
	global $num_doc;
	global $anno;
	

	 // PTSans  9

    // Line break
	
	//Crea intestazione tabella con dati offerta e dati cliente

    $this->Ln(20);
	
	$this->SetFont('Helvetica','',10);	

	$this->Text( 136, 15, 'Spettabile' ); 

	$this->SetFont('Helvetica','B',11);
	//$this->Text (135, 29, iconv('UTF-8', 'windows-1252', $ragsoc1));
	$this->SetXY(135,18);
	$this->MultiCell(50,4,$ragsoc1,0,'L');
	
	$height = $this->getY();
	$this->SetXY(135,$height+2);
	$this->SetFont('Helvetica','',10);	
	$this->MultiCell(50,4, em(mb_convert_encoding(em($indirizzo), 'HTML-ENTITIES', 'UTF-8')),0,'L');
	
	$height = $this->getY();
	$this->SetXY(135,$height);
	$this->MultiCell(50,4,$cap.' '.$localita.' '.'('.$provincia.')',0,'L');
	
	$height = $this->getY();
	$this->SetXY(135,$height+2);
	$this->MultiCell(50,4,'Cortese Attenzione: ',0,'L');
	$this->SetXY(135,$height+6);
	if($titolo){
		$titoloSpazio = ' ';
	}else{
		$titoloSpazio = '';
	}
	$this->MultiCell(50,4,$titolo . $titoloSpazio . $nome . ' ' . $cognome ,0,'L');

	$this->SetFont('Helvetica','',10);	
	//$this->Text( 135, 33, iconv('UTF-8', 'windows-1252', $indirizzo)); 
	//$this->Text( 135, 37, iconv('UTF-8', 'windows-1252', $cap.' '.$localita.' '.'('.$provincia.')')); 


	


	$this->SetFont('Helvetica','B',12);
	$newDate = date('d-m-Y', strtotime($data_doc));

	$this->SetXY(10,50);
	$this->setFillColor(242,242,242); 
	$this->SetTextColor(188,0,76);
	$this->Cell(100,8, ' OFFERTA N. ' . $num_doc . '/' . $anno . ' del ' . $newDate,1,1,'L',1); //your cell

	
	
}

// Page footer
function Footer()
{
	global $note;
	//Footer string
	//Se la tabella è troppo lunga, spostare le note (condizioni di vendita) nella seconda pagina perchè altrimenti non ci starebbero
		$this->setFillColor(255,255,255); 
		$this->SetFont('Helvetica','',9);
		$this->SetXY(10,195);

		$note2 = em(mb_convert_encoding(em($note), 'HTML-ENTITIES', 'UTF-8'));

		$this->MultiCell( 190, 4, urldecode($note2) ,0,'L',1);
	
	

		$height = $this->getY();
		//Footer string

	

		 
	
	//Stampa footer
	$this->setFillColor(255,255,255);
	$this->SetFont('Helvetica','',7);
	$this->SetXY(10,270);	
	$this->Cell(0, 10, 'Pagina '.$this->PageNo().'/{nb}', 0, 0, 'C');
	$this->SetXY(10,280);
	$this->MultiCell( 190, 4, iconv('UTF-8', 'windows-1252',"Wi-Com Solutions S.r.l. - Via L. da Vinci 11 - 20813 BOVISIO MASCIAGO (MB)\nTel. 0362/1722878 – 1722877 – e-mail : info@wicomsolutions.it – web: www.wicomsolutions.it\nC.F. / P.IVA : 07628770963 – R.E.A. 1880777 – Capitale Sociale € 20.000 i.v"),0,'C',1);



}
}

	// Instanciation of inherited class
	$p = new PDF();
	$p->AliasNbPages();
	$p->AddPage();
	$p->SetMargins(0,0,0);
	$p->SetAutoPageBreak(false,0);

	//Inizializza numero di pagine
	$numPage = 1;

	$p->SetTextColor(0,0,0);
	$p->SetFont('Helvetica','',9);

if ($numPage == 1){
	$p->Text( 10, 62, 'A seguito della vs. gradita richiesta, abbiamo il piacere di inoltrarvi ns. migliore offerta, netta e a voi 		riservata, per i prodotti di' );
	$p->Text( 10, 66, 'vs. interesse:' );
}
	
	//Intestazione tabella
	$p->setFillColor(242,242,242); 
	$p->SetFont('Helvetica','B',6);
	$p->SetXY(10,70);
	$p->MultiCell(7,10,'POS',1,'C',1);

	$p->SetXY(17,70);
	$p->MultiCell(31,10,'COD. ARTICOLO',1,'C',1);

	$p->SetXY(48,70);
	$p->MultiCell(55,10,'DESCRIZIONE',1,'C',1);

	$p->SetXY(103,70);
	$p->MultiCell(7,10,'U.M.',1,'C',1);

	$p->SetXY(110,70);
	$p->MultiCell(10,5,"Q.TA' (MOQ)",1,'C',1);

	$p->SetXY(120,70);
	$p->MultiCell(15,5,iconv('UTF-8', 'windows-1252', "PREZZO\nUNIT. (€)"),1,'C',1);

	$p->SetXY(135,70);
	$p->MultiCell(10,10,iconv('UTF-8', 'windows-1252', 'SC.%'),1,'C',1);

	$p->SetXY(145,70);
	$p->MultiCell(15,10,iconv('UTF-8', 'windows-1252', 'TOT. €'),1,'C',1);

	$p->SetXY(160,70);
	$p->MultiCell(40,10,'CONSEGNA',1,'C',1);

	//Creazione Struttura Tabella pagina precedente
	$p->Line(10,70, 200, 70);
	$p->Line(10,70, 10, 180);
	$p->Line(17,70, 17, 180);
	$p->Line(48,70, 48, 180);
	$p->Line(103,70, 103, 180);
	$p->Line(110,70, 110, 180);
	$p->Line(120,70, 120, 180);
	$p->Line(135,70, 135, 180);
	$p->Line(145,70, 145, 180);
	$p->Line(160,70, 160, 180);
	$p->Line(200,70, 200, 180);
	$p->Line(10,180, 200, 180);	



//Stampa dettaglio articoli
	$length = 82;
	$contaRighe = 0;
	$p->SetFont('Helvetica','',7);

	  $query = "
      SELECT AO.codice_articolo, AO.qta, AO.prezzo, AO.data_consegna, AO.pos, A.um, A.descrizione, AO.sconto
	  FROM articoli_offerta AO
	  INNER JOIN articoli A on A.codice_articolo = AO.codice_articolo
	  WHERE 1
		AND AO.id_offerta = '$id_offerta'
		ORDER BY AO.pos ASC
	  ";
	  $result = doQuery($query);
	  while (list($codice_articolo_t, $qta_t, $prezzo_t, $data_consegna_t, $pos_t, $um_t, $descrizione_t, $sconto_t) = mysqli_fetch_array($result))
	  { 
		$contaRighe = $contaRighe+1;
		  
		if ($contaRighe > 10){	
			//Aggiungi nuova pagina			
			$p->AddPage();
			$p->SetMargins(0,0,0);
			$p->SetAutoPageBreak(false,0);

			//Creazione Struttura Tabella pagina precedente
			$p->Line(10,70, 200, 70);
			$p->Line(10,70, 10, 180);
			$p->Line(17,70, 17, 180);
			$p->Line(48,70, 48, 180);
			$p->Line(103,70, 103, 180);
			$p->Line(110,70, 110, 180);
			$p->Line(120,70, 120, 180);
			$p->Line(135,70, 135, 180);
			$p->Line(145,70, 145, 180);
			$p->Line(160,70, 160, 180);
			$p->Line(200,70, 200, 180);
			$p->Line(10,180, 200, 180);	

			//Intestazione tabella nuova pagina
			$p->setFillColor(242,242,242); 
			$p->SetFont('Helvetica','B',6);
			$p->SetXY(10,70);
			$p->MultiCell(7,10,'POS',1,'C',1);

			$p->SetXY(17,70);
			$p->MultiCell(31,10,'COD. ARTICOLO',1,'C',1);

			$p->SetXY(48,70);
			$p->MultiCell(55,10,'DESCRIZIONE',1,'C',1);

			$p->SetXY(103,70);
			$p->MultiCell(7,10,'U.M.',1,'C',1);

			$p->SetXY(110,70);
			$p->MultiCell(10,5,"QT.A (MOQ)",1,'C',1);

			$p->SetXY(120,70);
			$p->MultiCell(15,5,iconv('UTF-8', 'windows-1252', "PREZZO\nUNIT. (€)"),1,'C',1);

			$p->SetXY(135,70);
			$p->MultiCell(10,10,iconv('UTF-8', 'windows-1252', 'SC.%'),1,'C',1);

			$p->SetXY(145,70);
			$p->MultiCell(15,10,iconv('UTF-8', 'windows-1252', 'TOT. €'),1,'C',1);

			$p->SetXY(160,70);
			$p->MultiCell(40,10,'CONSEGNA',1,'C',1);
			
			//resettare valore iniziale di inizio tabella
			$p->SetFont('Helvetica','',7);
			$contaRighe = 0;
			
			//incremento valore della variabile del numero pagine
			$numPage = $numPage + 1;
				
			$length = 82;
		}
		
		$descrizione2_t = em(mb_convert_encoding(em($descrizione_t), 'HTML-ENTITIES', 'UTF-8'));
		$codice_articolo2_t = em(mb_convert_encoding(em($codice_articolo_t), 'HTML-ENTITIES', 'UTF-8'));
		$data_consegna2_t = em(mb_convert_encoding(em($data_consegna_t), 'HTML-ENTITIES', 'UTF-8'));
		
		$p->setFillColor(255,255,255); 
		
		$p->SetXY(10,$length);
		$p->MultiCell(7,3,$pos_t,'L,R','C',1);

		$p->SetXY(17,$length);
		$p->MultiCell(31,3,urldecode($codice_articolo2_t),'L,R','L',1);

		$p->SetXY(48,$length);
		$p->MultiCell(55,3,urldecode($descrizione2_t),'L,R','L',1);

		$p->SetXY(103,$length);
		$p->MultiCell(7,3,$um_t,'L,R','C',1);

		$p->SetXY(110,$length);
		$p->MultiCell(10,3,$qta_t,'L,R','C',1);

		$p->SetXY(120,$length);
		$p->MultiCell(15,3,iconv('UTF-8', 'windows-1252', number_format($prezzo_t, 2, ',', '.')),'L,R','R',1);

		$p->SetXY(135,$length);
		$p->MultiCell(10,3,iconv('UTF-8', 'windows-1252', number_format($sconto_t, 1, ',', '.')) . '%','L,R','C',1);
		
		$p->SetXY(145,$length);
		$p->MultiCell(15,3,iconv('UTF-8', 'windows-1252', number_format(($prezzo_t  * $qta_t) - ((($prezzo_t  * $qta_t)/100) * $sconto_t), 2, ',', '.')),'L,R','R',1);

		$p->SetXY(160,$length);
		$newDateConsegna = date('d-m-Y', strtotime($data_consegna2_t));
		$p->MultiCell(40,3,urldecode($data_consegna2_t),'L,R','L',1);
		
		$length = $length + 10;
		


  
	  }
	  
	  
		  		//Creazione Struttura Tabella ultima pagina
				$p->Line(10,80, 200, 80);
				$p->Line(10,80, 10, 190);
				$p->Line(17,80, 17, 190);
				$p->Line(48,80, 48, 190);
				$p->Line(103,80, 103, 190);
				$p->Line(110,80, 110, 190);
				$p->Line(120,80, 120, 190);
				$p->Line(135,80, 135, 190);
				$p->Line(145,80, 145, 190);
				$p->Line(160,80, 160, 190);
				$p->Line(200,80, 200, 190);
				$p->Line(10,190, 200, 190);
		  

	  

		  
		  	
	  
	  
	//Footer tabella

	  $query = "
      SELECT SUM((AO.qta * AO.prezzo) - (((AO.qta * AO.prezzo)/100) * AO.sconto))
	  FROM articoli_offerta AO
	  WHERE 1
		AND AO.id_offerta = '$id_offerta'
	  ";
	  $result = doQuery($query);
	  while (list($totale_t) = mysqli_fetch_array($result))
	  { 
		$p->setFillColor(242,242,242); 
		$p->SetFont('Helvetica','B',8);
		$p->SetXY(10,180);
		$p->MultiCell(110,12,'',1,'C',1);


		$p->SetXY(110,180);
		$p->MultiCell(50,6,"IMPORTO TOTALE\n(IVA ESCLUSA):",1,'C',1);


		$p->SetFont('Helvetica','B',10);
		$p->SetXY(160,180);
		$p->MultiCell(40,12,number_format($totale_t, 2, ',', '.') . iconv('UTF-8', 'windows-1252',' €') ,1,'C',1);

  
	  }

		$p->SetFont('Helvetica','',9);
		$p->SetXY(10, 235);
	 	$p->MultiCell( 240, 4, "\n\n" . "Restiamo in attesa di vs. cortese riscontro e con l'occasione porgiamo cordiali saluti." ,0,'L',0);

		$height = $p->getY();  
		$p->SetFont('Helvetica','',9);
		$p->SetXY(10, 250);
		$p->MultiCell( 190, 4, $p->Image("./img/firma.jpg", null,null,40),0,'L',0);






// Senza parametri rende il file al browser
$p->output('I','Offerta'  . '.pdf');

function em($word) {

    $word = str_replace("@","%40",$word);
    $word = str_replace("`","%60",$word);
    $word = str_replace("¢","%A2",$word);
    $word = str_replace("£","%A3",$word);
    $word = str_replace("¥","%A5",$word);
    $word = str_replace("|","%7C",$word);
    $word = str_replace("«","%AB",$word);
    $word = str_replace("¬","%AC",$word);
    $word = str_replace("¯","%AD",$word);
    $word = str_replace("º","%B0",$word);
    $word = str_replace("±","%B1",$word);
    $word = str_replace("ª","%B2",$word);
    $word = str_replace("µ","%B5",$word);
    $word = str_replace("»","%BB",$word);
    $word = str_replace("¼","%BC",$word);
    $word = str_replace("½","%BD",$word);
    $word = str_replace("¿","%BF",$word);
    $word = str_replace("À","%C0",$word);
    $word = str_replace("Á","%C1",$word);
    $word = str_replace("Â","%C2",$word);
    $word = str_replace("Ã","%C3",$word);
    $word = str_replace("Ä","%C4",$word);
    $word = str_replace("Å","%C5",$word);
    $word = str_replace("Æ","%C6",$word);
    $word = str_replace("Ç","%C7",$word);
    $word = str_replace("È","%C8",$word);
    $word = str_replace("É","%C9",$word);
    $word = str_replace("Ê","%CA",$word);
    $word = str_replace("Ë","%CB",$word);
    $word = str_replace("Ì","%CC",$word);
    $word = str_replace("Í","%CD",$word);
    $word = str_replace("Î","%CE",$word);
    $word = str_replace("Ï","%CF",$word);
    $word = str_replace("Ð","%D0",$word);
    $word = str_replace("Ñ","%D1",$word);
    $word = str_replace("Ò","%D2",$word);
    $word = str_replace("Ó","%D3",$word);
    $word = str_replace("Ô","%D4",$word);
    $word = str_replace("Õ","%D5",$word);
    $word = str_replace("Ö","%D6",$word);
    $word = str_replace("Ø","%D8",$word);
    $word = str_replace("Ù","%D9",$word);
    $word = str_replace("Ú","%DA",$word);
    $word = str_replace("Û","%DB",$word);
    $word = str_replace("Ü","%DC",$word);
    $word = str_replace("Ý","%DD",$word);
    $word = str_replace("Þ","%DE",$word);
    $word = str_replace("ß","%DF",$word);
    $word = str_replace("à","%E0",$word);
    $word = str_replace("á","%E1",$word);
    $word = str_replace("â","%E2",$word);
    $word = str_replace("ã","%E3",$word);
    $word = str_replace("ä","%E4",$word);
    $word = str_replace("å","%E5",$word);
    $word = str_replace("æ","%E6",$word);
    $word = str_replace("ç","%E7",$word);
    $word = str_replace("è","%E8",$word);
    $word = str_replace("é","%E9",$word);
    $word = str_replace("ê","%EA",$word);
    $word = str_replace("ë","%EB",$word);
    $word = str_replace("ì","%EC",$word);
    $word = str_replace("í","%ED",$word);
    $word = str_replace("î","%EE",$word);
    $word = str_replace("ï","%EF",$word);
    $word = str_replace("ð","%F0",$word);
    $word = str_replace("ñ","%F1",$word);
    $word = str_replace("ò","%F2",$word);
    $word = str_replace("ó","%F3",$word);
    $word = str_replace("ô","%F4",$word);
    $word = str_replace("õ","%F5",$word);
    $word = str_replace("ö","%F6",$word);
    $word = str_replace("÷","%F7",$word);
    $word = str_replace("ø","%F8",$word);
    $word = str_replace("ù","%F9",$word);
    $word = str_replace("ú","%FA",$word);
    $word = str_replace("û","%FB",$word);
    $word = str_replace("ü","%FC",$word);
    $word = str_replace("ý","%FD",$word);
    $word = str_replace("þ","%FE",$word);
    $word = str_replace("ÿ","%FF",$word);
    $word = str_replace("&bull;","%95",$word);	
    $word = str_replace("&#9679;","%95",$word);
    $word = str_replace("&#x2022;","%95",$word);
    $word = str_replace("&#8226;","%95",$word);
	$word = str_replace("&deg;","%B0",$word);
	$word = str_replace("&rdquo;","%22",$word);
	$word = str_replace("&nbsp;"," ",$word);
	$word = str_replace("&euro;","%80",$word);
	$word = str_replace("&sect;","%A7",$word);
	$word = str_replace("&#8209;","-",$word);
    return $word;
}



?>