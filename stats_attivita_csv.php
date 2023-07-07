<?
#### permessi
$req = 2; # tutti

require "inc_config.php";
require "inc_sicurezza_bo.php";

	 unset($_SESSION['att_tecnico']);
	 unset($_SESSION['progressivi']);
	 unset($_SESSION['report']);
	 unset($_SESSION['articoli']);

if (isset($_REQUEST['debug']))
  $debug = $_REQUEST['debug'];
else
  $debug = "";

if (0)
{
  echo "<pre>";
  print_r($_REQUEST);
  echo "</pre>";
}

############ ATTIVITA
		# modifica
				if (isset($_REQUEST['ticket_id_ticket']))
		  $ticket_id_ticket = $_REQUEST['ticket_id_ticket'];
		else
		  $ticket_id_ticket = "";
		
		
		
		
		if (isset($_REQUEST['ids_cli']))
		  $ids_cli = mysqli_real_escape_string($link,$_REQUEST['ids_cli']);
		else
		  $ids_cli = "";
	  
		if (isset($_REQUEST['ids_tec']))
		  $ids_tec = mysqli_real_escape_string($link,$_REQUEST['ids_tec']);
		else
		  $ids_tec = "";

		if (isset($_REQUEST['ids_giorni']))
		  $ids_giorni = mysqli_real_escape_string($link,$_REQUEST['ids_giorni']);
		else
		  $ids_giorni = "";

		if (isset($_REQUEST['ids_stato']))
		  $ids_stato = mysqli_real_escape_string($link,$_REQUEST['ids_stato']);
		else
		  $ids_stato = "";
	  
		if (isset($_REQUEST['da_data_chiamata']))
		  $da_data_chiamata = mysqli_real_escape_string($link,$_REQUEST['da_data_chiamata']);
		else
		  $da_data_chiamata = "";
	  
	  	if (isset($_REQUEST['a_data_chiamata']))
		  $a_data_chiamata = mysqli_real_escape_string($link,$_REQUEST['a_data_chiamata']);
		else
		  $a_data_chiamata = "";
	  
		if (isset($_REQUEST['apparecchiatura']))
		  $apparecchiatura = mysqli_real_escape_string($link,$_REQUEST['apparecchiatura']);
		else
		  $apparecchiatura = "";
	  
		if (isset($_REQUEST['motivo']))
		  $motivo = mysqli_real_escape_string($link,$_REQUEST['motivo']);
		else
		  $motivo = "";


		if (isset($_REQUEST['id_priorità']))
		  $id_priorità = mysqli_real_escape_string($link,$_REQUEST['id_priorità']);
		else
		  $id_priorità = "";

	  
		if (isset($_REQUEST['priorità']))
		  $priorità = mysqli_real_escape_string($link,$_REQUEST['priorità']);
		else
		  $priorità = "";
	  
		if (isset($_REQUEST['id_stato']))
		  $id_stato = mysqli_real_escape_string($link,$_REQUEST['id_stato']);
		else
		  $id_stato = "";

		if (isset($_REQUEST['stato']))
		  $stato = mysqli_real_escape_string($link,$_REQUEST['stato']);
		else
		  $stato = "";
	  
	  	if (isset($_REQUEST['id_utente']))
		  $id_utente = mysqli_real_escape_string($link,$_REQUEST['id_utente']);
		else
		  $id_utente = "";
	  
	  	 if (isset($_REQUEST['ragsoc1']))
		  $ragsoc1 = mysqli_real_escape_string($link,$_REQUEST['ragsoc1']);
		else
		  $ragsoc1 = "";	  
	  
	  	 if (isset($_REQUEST['ragsoc2']))
		  $ragsoc2 = mysqli_real_escape_string($link,$_REQUEST['ragsoc2']);
		else
		  $ragsoc2 = "";
	  
	  	 if (isset($_REQUEST['nominativo']))
		  $nominativo = mysqli_real_escape_string($link,$_REQUEST['nominativo']);
		else
		  $nominativo = "";	  
	  
	  
	  	 if (isset($_REQUEST['id_report']))
		  $id_report = mysqli_real_escape_string($link,$_REQUEST['id_report']);
		else
		  $id_report = "";	  	  
	  
	 
	  	 if (isset($_REQUEST['id_bollettario']))
		  $id_bollettario = mysqli_real_escape_string($link,$_REQUEST['id_bollettario']);
		else
		  $id_bollettario = "";	 

	  	 if (isset($_REQUEST['id_progressivo']))
		  $id_progressivo = mysqli_real_escape_string($link,$_REQUEST['id_progressivo']);
		else
		  $id_progressivo = "";	 	  

	  	 if (isset($_REQUEST['anno']))
		  $anno = mysqli_real_escape_string($link,$_REQUEST['anno']);
		else
		  $anno = "";	  

	  	 if (isset($_REQUEST['progressivo']))
		  $progressivo = mysqli_real_escape_string($link,$_REQUEST['progressivo']);
		else
		  $progressivo = "";	  	  
	  
	  
	  
	  	  	 if (isset($_REQUEST['id_att_tecnico']))
		  $id_att_tecnico = mysqli_real_escape_string($link,$_REQUEST['id_att_tecnico']);
		else
		  $id_att_tecnico = "";	
	  
	  
	  	  	 if (isset($_REQUEST['descrizione']))
		  $descrizione = mysqli_real_escape_string($link,$_REQUEST['descrizione']);
		else
		  $descrizione = "";	
	  
	  
	  	  	 if (isset($_REQUEST['arrivo']))
		  $arrivo = mysqli_real_escape_string($link,$_REQUEST['arrivo']);
		else
		  $arrivo = "";	
	  
	  
	  	 if (isset($_REQUEST['partenza']))
		  $partenza = mysqli_real_escape_string($link,$_REQUEST['partenza']);
		else
		  $partenza = "";	
	  
	  	if (isset($_REQUEST['id_articolo_report']))
		  $id_articolo_report = mysqli_real_escape_string($link,$_REQUEST['id_articolo_report']);
		else
		  $id_articolo_report = "";	
	  
	  	if (isset($_REQUEST['codice_articolo']))
		  $codice_articolo = mysqli_real_escape_string($link,$_REQUEST['codice_articolo']);
		else
		  $codice_articolo = "";		  
	  
	  
	  	if (isset($_REQUEST['descr_art']))
		  $descr_art = mysqli_real_escape_string($link,$_REQUEST['descr_art']);
		else
		  $descr_art = "";	

	  	if (isset($_REQUEST['quantità']))
		  $quantità = mysqli_real_escape_string($link,$_REQUEST['quantità']);
		else
		  $quantità = "";

	  
	  	if (isset($_REQUEST['id_orario']))
		  $id_orario = mysqli_real_escape_string($link,$_REQUEST['id_orario']);
		else
		  $id_orario = "";

	  	if (isset($_REQUEST['tipo_intervento']))
		  $tipo_intervento = mysqli_real_escape_string($link,$_REQUEST['tipo_intervento']);
		else
		  $tipo_intervento = "";


$csv = "
<html xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns=\"http://www.w3.org/TR/REC-html40\">
<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">
<meta name=ProgId content=Excel.Sheet>
<table border=\"1\">
	<tr>
		<th>ID Ticket</th>
		<th>Cliente</th>
		<th>Bollettario</th>		
		<th>Numero</th>		
		<th>Anno</th>		
		<th>Motivo</th>		
		<th>Data arrivo</th>
		<th>Data partenza</th>
		<th>Durata</th>		
		<th>Tecnico</th>
		<th>Descrizione</th>
		<th>Tipo Intervento</th>		
		<th>Stato</th>
		
	</tr>
";

	if($id_orario == 1){
		
		$fasciaDaOra = "08:00";
		$fasciaAOra = "13:59";
		
	}elseif($id_orario == 2){
		
		$fasciaDaOra = "14:00";
		$fasciaAOra = "18:00";
		
	}elseif($id_orario == 3){
		
		$fasciaDaOra = "18:00";
		$fasciaAOra = "08:00";		
		
	}
	


	
  $w_cliente = $ids_cli?" AND T.id_cliente IN ($ids_cli) ":"";
  $w_tecnico = $ids_tec?" AND TEC.id IN ($ids_tec) ":"";
  $w_anno = $anno?" AND R.anno = '$anno' ":"";
  $w_stato = $ids_stato?" AND T.stato in ($ids_stato) ":"";
  $w_priorità = $priorità?" AND T.priorità = '$priorità' ":"";
  $w_da_data_chiamata = $da_data_chiamata?" AND  T.data_chiamata >= '".giraData($da_data_chiamata, "in")."'":"";   
  $w_a_data_chiamata = $a_data_chiamata?" AND  T.data_chiamata <= '".giraData($a_data_chiamata, "in")."'":""; 
  $w_giorni = $ids_giorni?" AND DAYOFWEEK(T.data_chiamata) in ($ids_giorni) ":"";
  $w_da_orario = $id_orario?" AND TIME(arrivo) >=  '$fasciaDaOra' ":"";  
  $w_a_orario = $id_orario?" AND TIME(partenza) <=  '$fasciaAOra' ":"";  
  $w_tipo_intervento = $tipo_intervento?" AND T.tipo_intervento =  $tipo_intervento ":""; 
  

  $query = "
			SELECT T.id, C.ragsoc1, R.progressivo, R.anno, T.motivo, AT.arrivo, AT.partenza, TEC.nome, TEC.cognome,
			AT.descrizione, AR.codice_articolo, S.descrizione
			FROM ticket T
			LEFT JOIN report R on R.id_ticket = T.id
			LEFT JOIN cliente C on C.id = T.id_cliente
			LEFT JOIN stato S on S.id = T.stato
			LEFT JOIN priorità P on P.id = T.priorità
			LEFT JOIN att_tecnico AT on AT.id_report = R.id_report
			LEFT JOIN tecnici TEC on TEC.id = AT.id_tecnico and TEC.attivo = 1
			LEFT JOIN articoli_report AR on AR.id_report = R.id_report and AR.codice_articolo like 'RIP%'
  WHERE 1
    $w_data_chiamata
	$w_cliente
	$w_tecnico
	$w_anno
	$w_stato
	$w_priorità
	$w_giorni
	$w_da_orario
	$w_a_orario	
	$w_tipo_intervento
  ";
$result = doQuery($query);
while (list( $id_ticket_t, $ragsoc1_t, $progressivo_t, $anno_t, $motivo_t, $arrivo_t, $partenza_t, $nome_t, $cognome_t, $descrizione_t, $codice_articolo_t, $stato_t) = mysqli_fetch_array($result))
{

	$differenza= date_diff(date_create($partenza_t),date_create($arrivo_t)); 
	$durata = $differenza->format("%Hh %imin");

  $csv .= "
  <tr>
		<th>$id_ticket_t</th>
		<th>$ragsoc1_t</th>
		<th>W</th>
		<th>$progressivo_t</th>
		<th>$anno_t</th>
		<th>$motivo_t</th>
		<th>$arrivo_t</th>
		<th>$partenza_t</th>
		<th>$durata</th>
		<th>$nome_t $cognome_t</th>
		<th>$descrizione_t</th>
		<th>$codice_articolo_t</th>
		<th>$stato_t</th>	

 </tr>
 ";
}

$csv .= "</table></html>";

if (!$debug)
{
  $nome_file = "Statistiche";

  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  #header("Content-Type: application/force-download");
  header("Content-Type: application/octet-stream");
  #header("Content-Type: application/download");;
  header("Content-Disposition: attachment;filename={$nome_file}_".time().".xls ");
  header("Content-Transfer-Encoding: binary ");
}
echo $csv;