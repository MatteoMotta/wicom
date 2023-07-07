<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />



		
		<?
		#### permessi
		$req = 12; # tutti



		require "inc_config.php";
		require "inc_sicurezza_bo.php";

		if (0)
		{
		  echo "<pre>";
		  print_r($_REQUEST);

		  print_r($_FILES);
		  echo "</pre>";
		}
	

	  // begin the session
		session_start();
	
				
		if (!isset($_SESSION['offerta'])){
		$_SESSION['offerta']=array(array());
		}


		if (!isset($_SESSION['articoli'])){
		$_SESSION['articoli']=array(array());
		}  	

		############ TICKET
		# modifica
		
		if (isset($_REQUEST['id_offerta']))
		  $id_offerta = $_REQUEST['id_offerta'];
		else
		  $id_offerta = "";
		
		if (isset($_REQUEST['id_articolo_offerta']))
		  $id_articolo_offerta = mysqli_real_escape_string($link,$_REQUEST['id_articolo_offerta']);
		else
		  $id_articolo_offerta = "";	 
		
		
		if (isset($_REQUEST['id_cliente']))
		  $id_cliente = mysqli_real_escape_string($link,$_REQUEST['id_cliente']);
		else
		  $id_cliente = "";

		if (isset($_REQUEST['riferimento']))
		  $riferimento = mysqli_real_escape_string($link,$_REQUEST['riferimento']);
		else
		  $riferimento = "";
	  
	  	if (isset($_REQUEST['codice_articolo']))
		  $codice_articolo = mysqli_real_escape_string($link,$_REQUEST['codice_articolo']);
		else
		  $codice_articolo = "";
	  

		if (isset($_REQUEST['data_doc']))
		  $data_doc = mysqli_real_escape_string($link,$_REQUEST['data_doc']);
		else
		  $data_doc = "";

		if (isset($_REQUEST['allarme']))
		  $allarme = mysqli_real_escape_string($link,$_REQUEST['allarme']);
		else
		  $allarme = "";

		if (isset($_REQUEST['stato']))
		  $stato = mysqli_real_escape_string($link,$_REQUEST['stato']);
		else
		  $stato = "";
	  
		if (isset($_REQUEST['anno']))
		  $anno = mysqli_real_escape_string($link,$_REQUEST['anno']);
		else
		  $anno = "";

	  
		if (isset($_REQUEST['num_doc']))
		  $num_doc = mysqli_real_escape_string($link,$_REQUEST['num_doc']);
		else
		  $num_doc = "";
	  
		if (isset($_REQUEST['pos']))
		  $pos = mysqli_real_escape_string($link,$_REQUEST['pos']);
		else
		  $pos = "";
	  
	  	 if (isset($_REQUEST['qta']))
		  $qta = mysqli_real_escape_string($link,$_REQUEST['qta']);
		else
		  $qta = "";	  	    	  
	  	 
	  	 if (isset($_REQUEST['prezzo']))
		  $prezzo = mysqli_real_escape_string($link,$_REQUEST['prezzo']);
		else
		  $prezzo = "";	 
	  	 
	  	 if (isset($_REQUEST['sconto']))
		  $sconto = mysqli_real_escape_string($link,$_REQUEST['sconto']);
		else
		  $sconto = "";		  

	  	 if (isset($_REQUEST['data_consegna']))
		  $data_consegna = mysqli_real_escape_string($link,$_REQUEST['data_consegna']);
		else
		  $data_consegna = "";	 


	  	 if (isset($_REQUEST['note']))
		  $note = mysqli_real_escape_string($link,$_REQUEST['note']);
		else
		  $note = "";	 	 

	  
	  //Todo
	  
		if (isset($_REQUEST['todo']))
		  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
		else
		  $todo = "";

		$msg_offerta_ko = $msg_offerta_ok = "";		
		$msg_articoli_ko = $msg_articoli_ok = "";				
		
			
	
			
	
	//Query Articoli
		if ($todo == "doArt")
		{	
	
		 if (isset($_POST['inserisci'])) {
			
			if(!$id_offerta && count($_SESSION['offerta'])<=1){
				
					$new_offerta =array(
						'id_offerta'      => $id_offerta,
						'anno' => $anno,
						'data_doc'  => $data_doc,
						'num_doc' => $num_doc,
						'id_cliente' => $id_cliente,
						'riferimento' => $riferimento,
						'note' => $note,
						'stato' => $stato,
						'allarme' => $allarme);
					
					array_push($_SESSION['offerta'],$new_offerta);
				
			}
			
			

			
			if(empty($sconto)){
				$scontoOK = 0;
			}else{
				$scontoOK = $sconto;
			}
			
			if(empty($prezzo)){
				$prezzoOK = 0;
			}else{
				$prezzoOK = $prezzo;
			}

			if(empty($qta)){
				$qtaOK = 0;
			}else{
				$qtaOK = $qta;
			}
				
			if (!$msg_articoli_ko)
					  {
					$new_art =array(
						'id_offerta' 		=> $id_offerta,
						'codice_articolo'  	=> $codice_articolo,
						'prezzo'      		=> $prezzoOK,
						'qta'  				=> $qtaOK,
						'sconto' 			=> $scontoOK,
						'data_consegna' 	=> $data_consegna);
						

					array_push($_SESSION['articoli'],$new_art);

					$id_articolo_report = mysqli_insert_id($link);
					
					$msg_articoli_ok = "Articolo inserito correttamente";
					
					header("location:offerta.php?id_offerta=" .  $id_offerta); // redirects to all records page
					exit;

						
			  }
			}
		  
			if (isset($_POST['salva'])) {
		  
				  if(!$id_offerta){		
					
						// Per ogni offerta inserito
						foreach($_SESSION['offerta'] as $id => $offerta){

						
						//Escludi prima riga vuota
						if(count($offerta)>1){


								//INSERT all'interno della tabella report
								$insertOfferta = "
									INSERT INTO offerta SET
									num_doc=" . $_SESSION['offerta'][$id]['num_doc'] . ",
									data_doc='" . $_SESSION['offerta'][$id]['data_doc'] . "',
									anno = YEAR('" . $_SESSION['offerta'][$id]['data_doc'] . "'),
									id_cliente=" . $_SESSION['offerta'][$id]['id_cliente'] . ",
									riferimento='" . $_SESSION['offerta'][$id]['riferimento'] . "',
									stato='" . $_SESSION['offerta'][$id]['stato'] ."',
									allarme='" . $_SESSION['offerta'][$id]['allarme'] ."',
									note='" . $_SESSION['offerta'][$id]['note'] ."'
								";
								mysqli_query($link,$insertOfferta);
							
								//Associare il nuovo ID del report alla variabile $id_report
								$id_offerta = mysqli_insert_id($link);
								
						
						}else{
							$new_offerta =array(
							'id_offerta'      => $id_offerta,
							'anno' => $anno,
							'data_doc'  => $data_doc,
							'num_doc' => $num_doc,
							'id_cliente' => $id_cliente,
							'riferimento' => $riferimento,
							'note' => $note,
							'stato' => $stato,
							'allarme' => $allarme);
						
						array_push($_SESSION['offerta'],$new_offerta);	
						}
						}
						
					}else{


							//UPDATE all'interno della tabella report
								$updOfferta = "
									UPDATE offerta SET
									num_doc=" . $num_doc . ",
									data_doc='" . $data_doc . "',
									anno = YEAR('" . $data_doc . "'),
									id_cliente=" . $id_cliente . ",
									riferimento='" . $riferimento . "',
									stato='" . $stato . "',
									allarme='" . $allarme . "',
									note='" . $note."'
									WHERE id = ". $id_offerta ."
								";
								mysqli_query($link,$updOfferta);
							

						
					}
								
						
						// Per ogni articolo inserito
						foreach($_SESSION['articoli'] as $id => $articoli){	
						

							//Escludi prima riga vuota
							if(count($articoli)>1){
								
								$query = "
								  SELECT IF(max(pos) is null,1,max(pos)+1)
								  FROM articoli_offerta AO
								  WHERE 1
									AND AO.id_offerta = '$id_offerta'
								  ";
								  $result = mysqli_query($link, $query);
								  list($pos_max) = mysqli_fetch_array($result);
		 
								//Inserisci attività del tecnico
								$insertArt = "
										INSERT INTO articoli_offerta SET
										id_offerta = '$id_offerta',
										pos=". $pos_max . ",
										codice_articolo='". $_SESSION['articoli'][$id]['codice_articolo'] . "',
										qta= ". $_SESSION['articoli'][$id]['qta'] . ",
										prezzo=". $_SESSION['articoli'][$id]['prezzo'] . ",
										sconto=". $_SESSION['articoli'][$id]['sconto'] . ",
										data_consegna='". $_SESSION['articoli'][$id]['data_consegna'] . "'
										";
								
								mysqli_query($link,$insertArt);
								
								
								
							}
						}
								unset($_SESSION['articoli']);	 
								unset($_SESSION['offerta']);
						
								//header("location:offerta.php?id_offerta=" .  $id_offerta . "#offerta"); // redirects to all records page
								//exit;		
			}
		}
		

		


		
		

		if ($id_offerta and $todo!="doArt")
		{
		  $query = "
		  SELECT O.id, O.note, O.data_doc, O.num_doc, O.anno, O.id_cliente, O.riferimento, O.stato, O.allarme
		  FROM offerta O
		  WHERE 1
			AND O.id = '$id_offerta'
		  ";
		  $result = mysqli_query($link, $query);
		  list($id_offerta, $note, $data_doc, $num_doc, $anno, $id_cliente, $riferimento, $stato, $allarme) = mysqli_fetch_array($result);
		}


		$title = $id_offerta?"$num_doc/" . mb_substr($data_doc,0,4) . "":"Nuova offerta";
		
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
					<h1><i class="icon-group"></i> </h1>
				  </div>
				  <ol class="breadcrumb">
					<li><a href="home.php">Home</a></li>
					<li><a href="offerta.php">Offerte</a></li>
					<li class="active"><?=$num_doc?:"Nuovo"?></li>
				  </ol>
				  <div class="main-content">

				

					<div class="widget">
					  <a name="offerta"></a>
					  <?=$menu_int?>

					  <div class="widget-content-white glossed">
						<div class="padded">
						
						 <h3 class="form-title form-title-first">Offerta</h3>

						<?if ($msg_offerta_ko){?>
						<div class="widget">
						  <div class="alert alert-danger alert-dismissable">
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
							<i class="icon-exclamation-sign"></i>
							<strong>Attenzione!</strong> Verifica <?=substr($msg_offerta_ko,0,-2)?>.
						  </div>
						</div>
						<?}?>
						<?if ($msg_offerta_ok){?>
						<div class="widget">
						 <div class="alert alert-success alert-dismissable">
							<i class="icon-check-sign"></i>
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
							<strong>Perfetto!</strong> <?=$msg_offerta_ok?>.
						  </div>
						</div>
						<?}?>

		<form name="frmArt" id="frmArt" method="POST" role="form">
			<input type="hidden" name="id_offerta" id="id_offerta" value="<?=$id_offerta?>">
			<input type="hidden" name="todo" id="todo" value="doArt">
			

						
		
				<div class="row">
					<div class="col-md-2">
					<label>Numero Offerta</label>
							  <div class="form-group">
								
		<?
		
		$queryOff = "SELECT num_doc, data_doc, anno
		FROM offerta
		WHERE id = '$id_offerta'";
		$result = doQuery($queryOff);
		$resultQuery = mysqli_fetch_array($result);
		
		
		list($num_doc_t, $data_doc_t, $anno_t) = mysqli_fetch_array($result);
		
		
		//Se numero documento già presente nel database stampa paragrafo con numero documento
		if($resultQuery && !is_null($resultQuery[0])){
			
			echo "<input type=\"text\" id=\"num_doc\" name=\"num_doc\" class=\"form-control\" placeholder=\"Numero documento\" value=\"". $resultQuery[0] ."\" readonly>";
			
			
		}else{
			


			if(count($_SESSION['offerta'])>1){ 
					foreach($_SESSION['offerta'] as $id => $offerta){
						if($id == 1){
							echo "<input type=\"text\" id=\"num_doc\" name=\"num_doc\" class=\"form-control\" placeholder=\"Numero offerta\" value=\"".$offerta['num_doc']."\">";
						}
					}
				}else{			
					//Esegui select per trovare numero documento per quell'anno e quel bollettario
					$queryOff2 = "SELECT max(num_doc)
						FROM offerta
						WHERE anno = '" . date("Y") . "'";

					$result2 = doQuery($queryOff2);					
					list($num_doc_max) = mysqli_fetch_array($result2);
					
					
					if($num_doc_max){
						$num_doc_new = $num_doc_max + 1;
							echo "<input type=\"text\" id=\"num_doc\" name=\"num_doc\" class=\"form-control\" placeholder=\"Numero documento\" value=\"". $num_doc_new ."\" readonly>";
						//altrimenti stampa 1
						}else{			
								echo "<input type=\"text\" id=\"num_doc\" name=\"num_doc\" class=\"form-control\" placeholder=\"Numero documentoo\" value=\"1\" readonly>";
						}

					}
				}
			
				
				

		
		
		
		?>
					
							  </div>
					</div>
					

					<div class="col-md-4">
							  <div class="form-group">
								<label>Cliente</label>
								<select class="form-control selectpicker" id="id_cliente" name ="id_cliente" data-live-search="true" data-none-selected-text required>
								<option value=""></option>								
		<? 
		
		$queryCli = "SELECT O.id_cliente, C.ragsoc1, C.nome, C.cognome
		FROM offerta O
		INNER JOIN cliente C on C.id = O.id_cliente
		WHERE 
		C.valido = 1 AND
		O.id = '$id_offerta'";
		$resultCli = doQuery($queryCli);
		$resultQuery = mysqli_fetch_array($resultCli);
		
		
		list($id_cliente_t, $ragsoc1_t, $nome_t, $cognome_t) = mysqli_fetch_array($resultCli);	
		
		

		if($resultQuery && !is_null($resultQuery[0])){
			
				$sel = $id_cliente_t == $id_cliente?"selected":"";
				echo "<option value=\"". $resultQuery[0] . "\" selected>". $resultQuery[1]." - ". $resultQuery[2] . " " . $resultQuery[3]."</option>";		
				
		}else{	
			$queryCli2 = "SELECT C.ragsoc1, C.id, C.nome, C.cognome
			FROM cliente C 
			WHERE 
			C.valido = 1 AND
			C.id = '".$offerta['id_cliente']."'";
			$resultCli2 = doQuery($queryCli2);
			$resultQuery2 = mysqli_fetch_array($resultCli2);
			
			
			if($resultQuery2 && !is_null($resultQuery2[0])){
				
				foreach($_SESSION['offerta'] as $id => $offerta){
								if($id == 1){
									
									echo "<option value=\"".$offerta['id_cliente']."\" selected>".$resultQuery2[0]." - ". $resultQuery2[2] . " " . $resultQuery2[3]."</option>";
								}
							}
			}else{
				
				$query_r = "
			SELECT id, ragsoc1, nome, cognome
			FROM cliente C
			WHERE 1
			AND C.valido = 1
			ORDER BY ragsoc1 asc
			";
			
			$result = doQuery($query_r);
			while (list($id_cliente_t, $ragosc1_t, $nome_t, $cognome_t) = mysqli_fetch_array($result))
			{
				
				echo "<option value=\"$id_cliente_t\"  >$ragosc1_t - $nome_t $cognome_t</option>";					
					
					
			}
				
			}

		}
	
		?>
		

	</select>
	
	
							  </div>
							  </div>
					
					<div class="col-md-2">
						  <div class="form-group">
							<label>Stato</label>
							<select class="form-control" id="stato" name ="stato" required>
								
										<?
		
		$queryOff = "SELECT stato
		FROM offerta
		WHERE id = '$id_offerta'";
		$result = doQuery($queryOff);
		$resultQuery = mysqli_fetch_array($result);
		
		
		list($stato_t) = mysqli_fetch_array($result);
		
		
		//Se numero documento già presente nel database stampa paragrafo con numero documento
		if($resultQuery && !is_null($resultQuery[0])){
			
			$sel = $stato_t == $stato?"selected":"";
			
			if( $resultQuery[0] == 'In corso') { 
					echo "<option value=\"In corso\"  selected>In corso</option>";
					echo "<option value=\"OK\"  >Stato OK</option>";
					echo "<option value=\"KO\"  >Stato KO</option>";
					
			}elseif( $resultQuery[0] == 'OK') { 
					echo "<option value=\"In corso\" >In corso</option>";
					echo "<option value=\"OK\"  selected>Stato OK</option>";
					echo "<option value=\"KO\"  >Stato KO</option>";
					
			}elseif( $resultQuery[0] == 'KO') { 
					echo "<option value=\"In corso\"  >In corso</option>";
					echo "<option value=\"OK\"  >Stato OK</option>";
					echo "<option value=\"KO\"  selected>Stato KO</option>";
					
			}
		}else{
			
			$queryStato = "SELECT O.stato
			FROM offerta O
			WHERE 
			O.stato = '".$offerta['stato']."'";
			$resultStato = doQuery($queryStato);
			$resultQueryStato = mysqli_fetch_array($resultStato);

			if(count($_SESSION['offerta'])>1){ 
					foreach($_SESSION['offerta'] as $id => $offerta){
						if($id == 1){
							echo "<option value=\"".$offerta['stato']."\" selected>".$resultQueryStato[0]."</option>";
						}
					}
				}else{			
					echo "<option value=\"In corso\"  >In corso</option>";
					echo "<option value=\"OK\"  >Stato OK</option>";
					echo "<option value=\"KO\"  >Stato KO</option>";

					}
				}
			
				
				

		
		
		
		?>
					</select>					
						</div>
					</div>						

<?
	if(!$id_offerta && count($_SESSION['offerta'])>1){ 
					foreach($_SESSION['offerta'] as $id => $offerta){
						if($id == 1){
				
?>
				<div class="row">
					<div class="col-md-2">
						  <div class="form-group">
							<label>Data Offerta</label>
							<input type="date" id="data_doc" name="data_doc" class="form-control" placeholder="Data offerta" value="<?=$offerta['data_doc']?>" required>
						  </div>
					</div>
					<div class="col-md-2">
						  <div class="form-group">
							<label>Allarme</label>
							<input type="date" id="allarme" name="allarme" class="form-control" placeholder="Allarme" value="<?=$offerta['allarme']?>">
						  </div>
					</div>
			
				</div>

				</div>
				

				
				<div class="row">
				
					<div class="col-md-12">
					  <div class="form-group">
						<label>Note Pie di Pagina</label>
						<textarea maxlength="500" rows="5" wrap="hard" id="note" name="note" class="form-control" style="height:25%" placeholder=""><?=stripcslashes($offerta['note'])?></textarea>
					  </div>
					</div>	
				
				</div>
				


<?
						}
					}						
}else{
?>
				<div class="row">
					<div class="col-md-2">
						  <div class="form-group">
							<label>Data Offerta</label>
							<? if(!$id_offerta){?>
							<?php $newDate = date('Y-m-d');?>
							<? }else{ ?>
							<?php $newDate = date('Y-m-d', strtotime($data_doc));?>
							<? } ?>
							<input type="date" id="data_doc" name="data_doc" class="form-control" placeholder="Data offerta" value="<?=$newDate?>">
						  </div>
					</div>
					<div class="col-md-2">
						  <div class="form-group">
							<label>Allarme</label>
							<input type="date" id="allarme" name="allarme" class="form-control" placeholder="Allarme" value="<?=$allarme?>">
						  </div>
					</div>
				</div>
				</div>
				

				
				<div class="row">
				
					<div class="col-md-12">
					  <div class="form-group">
						<label>Note Pie di Pagina</label>
						<textarea id="note" name="note" class="form-control" placeholder="" maxlength="500" rows="10" cols="50" wrap="hard"><?=stripcslashes($note);?></textarea>
					  </div>
					</div>	
				
				</div>
				


<?
						
}
?>
<table class="table table-striped table-bordered table-hover datatable">
						<thead>
						  <tr>
							<th style="width: 50%;">Ragione Sociale</th>
							<th style="width: 25%;">Nome</th>
							<th style="width: 25%;">Cognome</th>
						  </tr>

						</thead>
						<tbody>

	
	
		<?

	  $query = "
      SELECT ragsoc1, nome, cognome
		FROM cliente C
		INNER JOIN offerta O on O.id_cliente = C.id
		WHERE O.id = '$id_offerta'
		";
		$result = doQuery($query);

	  while (list($ragsoc1_t, $nome_t, $cognome_t) = mysqli_fetch_array($result))
	  { 
	  


		
	?>
						  <tr>
							<td>
							  <?=$ragsoc1_t?> 
							</td>
							<td>
							  <?=$nome_t?>
							</td>
							<td>
							  <?=$cognome_t?>
							</td>
						  </tr>
						  	

						  
	<?
	  }
	?>
	
						  
						</tbody>
					  </table>
					  <br>
						
					
						<?if ($msg_articoli_ko){?>
						<div class="widget">
						  <div class="alert alert-danger alert-dismissable">
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
							<i class="icon-exclamation-sign"></i>
							<strong>Attenzione!</strong> Verifica <?=substr($msg_articoli_ko,0,-2)?>.
						  </div>
						</div>
						<?}?>
						<?if ($msg_articoli_ok){?>
						<div class="widget">
						 <div class="alert alert-success alert-dismissable">
							<i class="icon-check-sign"></i>
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
							<strong>Perfetto!</strong> <?=$msg_articoli_ok?>.
						  </div>
						</div>
						<?}?>


			
		

						
						 <h3 class="form-title form-title-first">Articoli utilizzati</h3>

						<?if ($msg_articoli_ko){?>
						<div class="widget">
						  <div class="alert alert-danger alert-dismissable">
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
							<i class="icon-exclamation-sign"></i>
							<strong>Attenzione!</strong> Verifica <?=substr($msg_articoli_ko,0,-2)?>.
						  </div>
						</div>
						<?}?>
						<?if ($msg_articoli_ok){?>
						<div class="widget">
						 <div class="alert alert-success alert-dismissable">
							<i class="icon-check-sign"></i>
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
							<strong>Perfetto!</strong> <?=$msg_articoli_ok?>.
						  </div>
						</div>
						<?}?>




							
							
				<div class="row">
					<div class="col-md-4">
							  <div class="form-group">
								<label>Articolo</label>
								<select class="form-control selectpicker" id="codice_articolo" name="codice_articolo" data-live-search="true" data-none-selected-text>		
								
		<? 
					
		$query_r = "
		SELECT codice_articolo, descrizione, um
		FROM articoli A
		WHERE 1
		AND A.valido = 1
		ORDER BY codice_articolo asc
		";
		
		$result = doQuery($query_r);
		while (list($codice_articolo_t, $descrizione_t, $um) = mysqli_fetch_array($result))
		{
			$sel = $codice_articolo_t == $codice_articolo?"selected":"";


			 echo "<option value=\"$codice_articolo_t\" $sel>$codice_articolo_t - $descrizione_t</option>";
		}
		
		
		
		?>
		

	</select>
							  </div>
							</div>
						
							<div class="col-md-2">
							  <div class="form-group">
								<label>Quantità</label>
								<input type="number" id="qta" name="qta" class="form-control" placeholder="Quantità"  step="any" value="<?=$qta?>" >
							  </div>
							</div>	
				
							<div class="col-md-2">
							  <div class="form-group">
								<label>Prezzo</label>
								<input type="number" id="prezzo" name="prezzo" class="form-control" placeholder="Prezzo"  step="any" value="<?=$prezzo?>" >
							  </div>
							</div>
							<div class="col-md-2">
							  <div class="form-group">
								<label>Sconto</label>
								<input type="number" id="sconto" name="sconto" class="form-control" placeholder="Sconto"  step="any" value="<?=$sconto?>">
							  </div>
							</div>
							<div class="col-md-2">
							  <div class="form-group">
								<label>Data consegna</label>
								<input type="text" id="data_consegna" name="data_consegna" class="form-control" placeholder="Data consegna" value="<?=$data_consegna?>">
							  </div>
							</div>				
							
							</div>

				
						<div class="row">
							<div class="col-md-12 text-center">
							<?if (isAdmin() and $id_articolo_offerta){?>
							  <button type="submit" name="inserisci" class="btn btn-primary">Modifica</button>
							<?}elseif (!$id_articolo_offerta){?>
							  <button type="submit" name="inserisci" class="btn btn-primary">Inserisci</button>
							<?}?>
							</div>
							
						</div>

			
			
					<div class="row" style="overflow-x:auto;">
					  <div class="padded">
					  <a name="articoli_report"></a>


					 
					  <table class="table table-striped table-bordered table-hover datatable">
						<thead>
						  <tr>
							<th style="width: 15%;">Codice Articolo</th>
							<th style="width: 13%;">Descrizione</th>
							<th style="width: 13%;">Quantità</th>							
							<th style="width: 13%;">Prezzo</th>								
							<th style="width: 13%;">Sconto</th>							
							<th style="width: 13%;">Totale</th>	
							<th style="width: 13%;">Data Consegna</th>
							<th></th>
						  </tr>

						</thead>
						<tbody>
		<?
		
		
	  foreach($_SESSION['articoli'] as $id => $articoli){
		  
		  
		  
	  if($articoli)  {
		  
			  $query = "
					  SELECT descrizione
					  FROM articoli A
					  WHERE 1
						AND A.codice_articolo = '" . $articoli['codice_articolo'] . "'";
	  $result = doQuery($query);
	  while (list($descrizione_t ) = mysqli_fetch_array($result))
	  { 

	?>
						  <tr>
							<td>
							 	<?=$_SESSION['articoli'][$id]['codice_articolo']?>
							</td>
							<td>
							  <?=$descrizione_t?>
							</td>
							<td>
							 	<?=$articoli['qta']?>
							</td>
							<td>
							  <?=$articoli['prezzo'];?>
							</td>
							<td>
							  <?=$articoli['sconto'];?>
							</td>
							<td>
							  <?=($articoli['prezzo'] * $articoli['qta']) - $articoli['sconto'];?>
							</td>
							<td>
							<?=$articoli['data_consegna'];?>
							</td>							
							<td class="text-center" nowrap>
							 <a class="del btn btn-danger btn-xs" href="deleteOffArt.php?id=<?=$id?>&id_offerta=<?=$id_offerta?>" ><i class="icon-remove"></i></a>
							</td>
							
						  </tr>
						  	

						  
	<?
	  }
	  }
	  }
	?>
	
	
		<?

	 $query = "
     SELECT AO.id, AO.codice_articolo, A.descrizione, AO.qta, AO.prezzo, AO.sconto, AO.data_consegna
	 FROM articoli_offerta AO
	 INNER JOIN articoli A on A.codice_articolo = AO.codice_articolo
	 WHERE 1
	AND AO.id_offerta = '$id_offerta'
	ORDER BY pos
	  ";
	  $result = doQuery($query);
	  while (list($id_t, $codice_articolo_t, $descr_art_t, $quantità_t, $prezzo_t, $sconto_t, $data_consegna_t ) = mysqli_fetch_array($result))
	  { 
	  


		
	?>
						  <tr>
							<td>
							  <?=$codice_articolo_t?> 
							</td>
							<td>
							  <?=$descr_art_t?>
							</td>
							<td>
							  <?=$quantità_t?>
							</td>
							<td>
							  <?=$prezzo_t?>
							</td>
							<td>
							  <?=$sconto_t?>
							</td>
							<td>
							  <?=($prezzo_t * $quantità_t)- $sconto_t?>
							</td>
							<td>
							  <?=$data_consegna_t?>
							</td>
							<td class="text-center" nowrap>
								<a class="upd btn btn-default btn-xs" href="updArtOfferta.php?id=<?=$id_t?>&id_offerta=<?=$id_offerta?>" ><i class="icon-pencil"></i></a>
								<a class="del btn btn-danger btn-xs" href="deleteArtOfferta.php?id=<?=$id_t?>&id_offerta=<?=$id_offerta?>" onclick="return confirm('Sei sicuro di voler eliminare questo articolo?')" ><i class="icon-remove"></i></a>
							</td>
						  </tr>
						  	

						  
	<?
	  }
	?>
	
						  
						</tbody>
					  </table>
	

						</tbody>
					  </table>
					  <hr style="border-top: dotted 1px;" />
					  


					  </div>
					</div>
												
						<div class="row">
							<div class="col-md-12 text-center">					
								<button type="submit" name="salva" class="btn btn-primary" onclick="return confirm('Sei sicuro di voler salvare?')" >SALVA</button>
							</div>
						</div>
						
						
						
					</form>
						
						
						<div class="row">
							<div class="col-md-12 text-center">
								<a class="btn btn-primary" href="pdf.php?&id_offerta=<?=$id_offerta?>">Scarica PDF</a>
							</div>
						</div>


							
				</div>
				
				
							
				</div>
				 </div>

				 
				 </div>

				 
				</div>
				 </div>
				 




		

					
				   </div>
				</div>





		<?
		if (0)
		{
		  echo "<pre>";
		  print_r($_REQUEST);

		  print_r($_FILES);
		  echo "</pre>";
		}
		?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

<script>
	$("#search").chosen({width: '100%'});
</script>

<script>
	$("#searchArticoli").chosen({width: '100%'});
</script>

<script>
	$("#searchTipoIntervento").chosen({width: '100%'});
</script>

<script>
	$("#searchSottogruppo").chosen({width: '100%'});
</script>

<script>
function reload(){
	var sgmerc = document.getElementById('id_sgmerc').value;
	var ticket_id_ticket = document.getElementById('ticket_id_ticket').value;
	//document.write(sgmerc);
	self.location=  'report.php?ticket_id_ticket=' + ticket_id_ticket +'&sgmerc=' + sgmerc + '#articoli';
}
</script>


<script>
function reloadBoll(){
	var ticket_id_ticket = document.getElementById('ticket_id_ticket').value;
	var id_report = document.getElementById('id_report').value;
	var id_bol = document.getElementById('id_bol').value;
	//document.write(id_bol);
	self.location=  'report.php?ticket_id_ticket=' + ticket_id_ticket + '&id_report=' + id_report + '&id_bollettario=' + id_bol;
}
</script>
<!--<script>
 $(window).on('beforeunload', function(){
                  return 'Are you sure you want to leave?';
           });
</script>-->
		