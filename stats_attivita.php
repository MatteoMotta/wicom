<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />


<br><br>



<script>
$(document).ready(function(){
 $('#id_giorni').multiselect({
  nonSelectedText: 'Seleziona Giorni',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'100%'
 });
 

 
 
});
</script>

<script>
$(document).ready(function(){
 $('#id_tecnico').multiselect({
  nonSelectedText: 'Seleziona Tecnico',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'100%'
 });
 

 
 
});
</script>

<script>
$(document).ready(function(){
 $('#id_stato').multiselect({
  nonSelectedText: 'Seleziona Stato',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'100%'
 });
 

 
 
});
</script>

<script>
$(document).ready(function(){
 $('#id_cliente').multiselect({
  nonSelectedText: 'Seleziona Cliente',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'100%'
 });
 

 
 
});
</script>

<?
#### permessi
$req = 2; # tutti

require "inc_config.php";
require "inc_sicurezza_bo.php";


	 unset($_SESSION['att_tecnico']);
	 unset($_SESSION['progressivi']);
	 unset($_SESSION['report']);
	 unset($_SESSION['articoli']);
	 unset($_SESSION['tipoIntervento']);

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
		
		
		
		
		if(isset($_POST['id_cliente'])){
		  foreach ($_POST['id_cliente'] as $clienti)
			{	
				if (isset($clienti))
				  $id_cliente = mysqli_real_escape_string($link,$clienti);
				else
				  $id_cliente = "";
			}
		}
		
	  
	
		if(isset($_POST['id_tecnico'])){
		  foreach ($_POST['id_tecnico'] as $tecnico)
			{	
				if (isset($tecnico))
				  $id_tecnico = mysqli_real_escape_string($link,$tecnico);
				else
				  $id_tecnico = "";
			}
		}
		
		
		if(isset($_POST['id_giorni'])){
		  foreach ($_POST['id_giorni'] as $giorni)
			{	
				if (isset($giorni))
				  $id_giorni = mysqli_real_escape_string($link,$giorni);
				else
				  $id_giorni = "";
			}
		}
			
		if(isset($_POST['id_stato'])){
		  foreach ($_POST['id_stato'] as $stato_array)
			{	
				if (isset($stato_array))
				  $id_stato = mysqli_real_escape_string($link,$stato_array);
				else
				  $id_stato = "";
			}	
		}

		if (isset($_REQUEST['id_orario']))
		  $id_orario = mysqli_real_escape_string($link,$_REQUEST['id_orario']);
		else
		  $id_orario = "";	  

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
	  
	  
	  //Todo
	  
		if (isset($_REQUEST['todo']))
		  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
		else
		  $todo = "";

		$msg_ko = $msg_ok = "";
		   
		// Joining array elements using
		// implode() function
		
		if(isset($_POST['id_cliente'])){
		$ids_cli = implode(', ', $_POST['id_cliente']);
		}
		
		if(isset($_POST['id_tecnico'])){
		$ids_tec = implode(', ', $_POST['id_tecnico']);
		}

		if(isset($_POST['id_stato'])){
		$ids_stato = implode(', ', $_POST['id_stato']);
		}

		if(isset($_POST['id_giorni'])){
		$ids_giorni = implode(', ', $_POST['id_giorni']);
}

# count risultati
if ($todo)
{
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

  $w_cliente = $id_cliente?" AND T.id_cliente IN ($ids_cli) ":"";
  $w_tecnico = $id_tecnico?" AND TEC.id IN ($ids_tec) ":"";
  $w_anno = $anno?" AND R.anno = '$anno' ":"";
  $w_stato = $id_stato?" AND T.stato in ($ids_stato) ":"";
  $w_priorità = $id_priorità?" AND T.priorità = '$id_priorità' ":"";
  $w_da_data_chiamata = $da_data_chiamata?" AND  T.data_chiamata >= '".giraData($da_data_chiamata, "in")."'":"";   
  $w_a_data_chiamata = $a_data_chiamata?" AND  T.data_chiamata <= '".giraData($a_data_chiamata, "in")."'":""; 
  $w_giorni = $id_giorni?" AND DAYOFWEEK(T.data_chiamata) in ($ids_giorni) ":"";
  $w_da_orario = $id_orario?" AND TIME(arrivo) >=  '$fasciaDaOra' ":"";  
  $w_a_orario = $id_orario?" AND TIME(partenza) <=  '$fasciaAOra' ":"";  
  $w_tipo_intervento = $tipo_intervento?" AND T.tipo_intervento =  $tipo_intervento ":""; 

  $query = "
			SELECT T.id, T.data_chiamata, T.apparecchiatura, T.motivo, T.nominativo, T.priorità, T.stato, C.ragsoc1, TEC.id, R.anno, R.progressivo
			FROM ticket T
			LEFT JOIN cliente C on C.id = T.id_cliente
			LEFT JOIN report R on R.id_ticket = T.id
			LEFT JOIN stato S on S.id = T.stato
			LEFT JOIN priorità P on P.id = T.priorità
			LEFT JOIN att_tecnico AT on AT.id_report = R.id_report
			LEFT JOIN tecnici TEC on TEC.id = AT.id_tecnico and TEC.attivo = 1
  WHERE 1
    $w_da_data_chiamata
    $w_a_data_chiamata
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
  $cnt = mysqli_num_rows($result);

  $msg_ok = "$cnt risultati";
}


$title = "Statistiche Attività";
require "inc_header.php";
?>
<div class="all-wrapper">
  <div class="row">
    <div class="col-md-3">
<?require "inc_menu_sx.php"?>
    </div>
    <div class="col-md-9">

      <div class="content-wrapper">
        <div class="content-inner <?=$content_inner_class?>">
          <div class="page-header <?=$page_header_class?>">
            <?require "inc_menu_oriz.php"?>
            <h1><i class="icon-phone"></i> </h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li>Statistiche</li>
          </ol>
          <div class="main-content">

            <div class="widget">
              <h3 class="section-title first-title"><i class="icon-bar-chart"></i>Statistiche</h3>
              <div class="widget-content-white glossed">
                <div class="padded">
                <form action="stats_attivita.php#stats" name="frm" id="frm" method="post" role="form">
                  <input type="hidden" name="todo" id="todo" value="do">
                  <h3 class="form-title form-title-first"><i class="icon-terminal"></i>Filtra</h3>

			<div class="row">	

				<div class="col-md-6">
                      <div class="form-group">
                        <label>Cliente</label><br>
						 <select id="id_cliente" name="id_cliente[]" multiple class="form-control"  placeholder="cliente">
<?

		$query_r = "
		SELECT id, ragsoc1, localita
		FROM cliente
		";
		$result = doQuery($query_r);
		while (list($id_cliente_t, $ragsoc1_t, $localita_t) = mysqli_fetch_array($result))
		{
			$contTec = 0;
			
			foreach ($_POST['id_cliente'] as $cliente){
				
				if($id_cliente_t == $cliente){
					$contCli = $contCli + 1;
				}
				
			}
			
			if($contTec > 0){
				echo "<option value=\"$id_cliente_t\" selected>$ragsoc1_t - $localita_t</option>";
			}else{
				echo "<option value=\"$id_cliente_t\">$ragsoc1_t - $localita_t</option>";
			}
}

?>						  
						 </select>
                      </div>
                 </div>		
			</div>
								
				  <div class="row">			
							<div class="col-md-3">
							  <div class="form-group">
								<label>Tecnico</label><br>
								<select name="id_tecnico[]"  multiple="multiple" id="id_tecnico" class="form-control">
		<?
		$query_r = "
		SELECT id, nome, cognome
		FROM tecnici
		";
		$result = doQuery($query_r);
		while (list($id_tecnico_t, $nome_t, $cognome_t) = mysqli_fetch_array($result))
		{
			$contTec = 0;
			
			foreach ($_POST['id_tecnico'] as $tecnico){
				
				if($id_tecnico_t == $tecnico){
					$contTec = $contTec + 1;
				}
				
			}
			
			if($contTec > 0){
				echo "<option value=\"$id_tecnico_t\" selected>$nome_t $cognome_t</option>";
			}else{
				echo "<option value=\"$id_tecnico_t\">$nome_t $cognome_t</option>";
			}

			
		}
		?>
								</select>
							  </div>
							</div>
				</div>
				

			
			<div class="row">	

				<div class="col-md-3">
                      <div class="form-group">
                        <label>Giorni</label><br>
						 <select id="id_giorni" name="id_giorni[]" multiple class="form-control"  placeholder="giorni">
<?

foreach($giorniArr as $id => $giorniArray){
	
	$contGiorni = 0;
	
	foreach($_POST['id_giorni'] as $giorni){
		if($id == $giorni){
			$contGiorni = $contGiorni + 1;
		}
		
	}
	
	if($contGiorni > 0){
		echo "<option value=\"".$id."\" selected>".$giorniArray."</option>";
	}else{
		echo "<option value=\"".$id."\">".$giorniArray."</option>";
	}
}

?>						  
						 </select>
                      </div>
                 </div>		
			</div>
			
			<div class="row">

				<div class="col-md-3">
                      <div class="form-group">
                        <label>Fascia oraria</label><br>
						 <select id="id_orario" name="id_orario" class="form-control"  placeholder="orario"><option value=""></option>
<?
						if($id_orario == 1){
							$selected1 = 'selected';
						} elseif($id_orario == 2){
							$selected2 = 'selected';
						}elseif($id_orario == 3){
							$selected3 = 'selected';
						}
					
						
						 echo "<option value=\"1\" " . $selected1 . " >08:00 - 14:00</option>";
						 echo "<option value=\"2\" " . $selected2 . " >14:00 - 18:00</option>";
						 echo "<option value=\"3\" " . $selected3 . " >18:00 - 08:00</option>";
						 

?>
						</select>
                      </div>
                 </div>	
				 
			</div>
			
			<div class="row">	
				<div class="col-md-3">
                      <div class="form-group">
                        <label>Da (Data Chiamata)</label>
                        <input type="text" id="da_data_chiamata" name="da_data_chiamata" class="form-control datepicker" placeholder="" value="<?=$da_data_chiamata?>">
                      </div>
                 </div>
				 
				 
			</div>

			
			
				 

	 
			<div class="row">
				<div class="col-md-3">
                      <div class="form-group">
                        <label>A (Data Chiamata)</label>
                        <input type="text" id="a_data_chiamata" name="a_data_chiamata" class="form-control datepicker" placeholder="" value="<?=$a_data_chiamata?>">
                      </div>
                 </div>
				 
			</div>
				  			
			<div class="row">
						<div class="col-md-3">
							  <div class="form-group">
								<label>Anno</label>
								<input type="text" id="anno" name="anno" class="form-control" placeholder="Anno" value="<?=$anno?>">
							  </div>
						</div>
			</div>
				
				<div class="row">
					<div class="col-md-3">
							  <div class="form-group">
								<label>Stato</label><br>
								<select name="id_stato[]" multiple="multiple" id="id_stato" class="form-control" ">
		<?
		$query_r = "
		SELECT id, descrizione
		FROM stato
		";
		$result = doQuery($query_r);
		while (list($id_stato_t, $stato_t) = mysqli_fetch_array($result))
		{
			
			$contStato = 0;
			
			foreach ($_POST['id_stato'] as $stato_array){
				
				if($id_stato_t == $stato_array){
					$contStato = $contStato + 1;
				}
				
			}
			
			if($contStato > 0){
			 echo "<option value=\"$id_stato_t\" selected>$stato_t</option>";
			}else{
			 echo "<option value=\"$id_stato_t\" >$stato_t</option>";
			}


		}
		?>
								</select>
							  </div>
							</div>

			</div>
			
			<div class="row">
					<div class="col-md-3">
							  <div class="form-group">
								<label>Priorità</label>
								<select name="id_priorità" id="id_priorità" class="form-control">
								  <option value=""></option>
		<?
		$query_r = "
		SELECT id, priorità
		FROM priorità
		";
		$result = doQuery($query_r);
		while (list($id_priorità_t, $priorità_t) = mysqli_fetch_array($result))
		{
			$sel = $id_priorità_t == $id_priorità?"selected":"";


			 echo "<option value=\"$id_priorità_t\" $sel>$priorità_t</option>";
		}
		?>
								</select>
							  </div>
							</div>

							
				</div>

				<div class="row">

				<div class="col-md-3">
                      <div class="form-group">
                        <label>Tipo intervento</label><br>
						 <select id="tipo_intervento" name="tipo_intervento" class="form-control"  placeholder="Tipo intervento"><option value=""></option>
<?
		$query_r = "
		SELECT id, tipo_intervento
		FROM tipo_intervento
		";
		$result = doQuery($query_r);
		while (list($id_intervento_t, $tipo_intervento_t) = mysqli_fetch_array($result))
		{
			$sel = $id_intervento_t == $tipo_intervento?"selected":"";


			 echo "<option value=\"$id_intervento_t\" $sel>$tipo_intervento_t</option>";
		}

?>
						</select>
                      </div>
                 </div>	
				 
			</div>				
				

                  <button id="btnDo" type="submit" class="btn btn-primary">Cerca</button>
                  <button type="reset" class="btn btn-default">Annulla</button>
				  </div>
                </form>
                </div>
              </div>
            </div>


<?
if ($msg_ok)
{
 ?>
  <div class="widget">
  <a name="stats"></a>
   <div class="alert alert-success alert-dismissable">
      <i class="icon-check-sign"></i>
      <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
      Trovati <?=$msg_ok?>. <a href="#" onclick="$('#frmCsv').submit();return false;">Clicca per scaricare Excel</a>
    </div>
  </div>

  <form action="stats_attivita_csv.php" name="frmCsv" id="frmCsv" method="post">
    <input type="hidden" name="debug" value="0">
    <input type="hidden" name="ids_cli" value="<?=$ids_cli?>">
    <input type="hidden" name="ids_tec" value="<?=$ids_tec ?>">	
    <input type="hidden" name="id_report" value="<?=$id_report?>">	
    <input type="hidden" name="id_ticket" value="<?=$id_ticket?>">	
	<input type="hidden" name="anno" value="<?=$anno?>">
	<input type="hidden" name="ids_stato" value="<?=$ids_stato?>">
	<input type="hidden" name="priorità" value="<?=$id_priorità?>">		
	<input type="hidden" name="da_data_chiamata" value="<?=$da_data_chiamata?>">
	<input type="hidden" name="a_data_chiamata" value="<?=$a_data_chiamata?>">
	<input type="hidden" name="ids_giorni" value="<?=$ids_giorni?>">
	<input type="hidden" name="id_orario" value="<?=$id_orario?>">
	<input type="hidden" name="tipo_intervento" value="<?=$tipo_intervento?>">	
  </form>
<?}?>


          </div>
        </div>
      </div>

    </div>
  </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

<script>
	$("#search").chosen({width: '100%'});
</script>