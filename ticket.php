<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

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

	 
		############ TICKET
		# modifica
		

		
		if (isset($_REQUEST['id_ticket']))
		  $id_ticket = $_REQUEST['id_ticket'];
		else
		  $id_ticket = "";
		
		
		
		
		if (isset($_REQUEST['id_cliente']))
		  $id_cliente = mysqli_real_escape_string($link,$_REQUEST['id_cliente']);
		else
		  $id_cliente = "";
	  
	  	if (isset($_REQUEST['codice_articolo']))
		  $codice_articolo = mysqli_real_escape_string($link,$_REQUEST['codice_articolo']);
		else
		  $codice_articolo = "";
	  

		if (isset($_REQUEST['data_assistenza']))
		  $data_assistenza = mysqli_real_escape_string($link,$_REQUEST['data_assistenza']);
		else
		  $data_assistenza = "";

		if (isset($_REQUEST['allarme']))
		  $allarme = mysqli_real_escape_string($link,$_REQUEST['allarme']);
		else
		  $allarme = "";
	  
		if (isset($_REQUEST['fornitore']))
		  $fornitore = mysqli_real_escape_string($link,$_REQUEST['fornitore']);
		else
		  $fornitore = "";
	  
		if (isset($_REQUEST['progetto']))
		  $progetto = mysqli_real_escape_string($link,$_REQUEST['progetto']);
		else
		  $progetto = "";


	    	  
	  
	 
	  	 if (isset($_REQUEST['descrizione']))
		  $descrizione = mysqli_real_escape_string($link,$_REQUEST['descrizione']);
		else
		  $descrizione = "";	 

	  	 if (isset($_REQUEST['val_offerto']))
		  $val_offerto = mysqli_real_escape_string($link,$_REQUEST['val_offerto']);
		else
		  $val_offerto = "";	 	  

	  	 if (isset($_REQUEST['val_ordinato']))
		  $val_ordinato = mysqli_real_escape_string($link,$_REQUEST['val_ordinato']);
		else
		  $val_ordinato = "";	  

	  	 if (isset($_REQUEST['val_potenziale']))
		  $val_potenziale = mysqli_real_escape_string($link,$_REQUEST['val_potenziale']);
		else
		  $val_potenziale = "";	  	  
	  
	  
	  
	  	  	 if (isset($_REQUEST['successo']))
		  $successo = mysqli_real_escape_string($link,$_REQUEST['successo']);
		else
		  $successo = "";	
	  
	  
	  	  	 if (isset($_REQUEST['note']))
		  $note = mysqli_real_escape_string($link,$_REQUEST['note']);
		else
		  $note = "";	
	  
	  
	  	  	 if (isset($_REQUEST['commento']))
		  $commento = mysqli_real_escape_string($link,$_REQUEST['commento']);
		else
		  $commento = "";	
	  
	 

	  
	  //Todo
	  
		if (isset($_REQUEST['todo']))
		  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
		else
		  $todo = "";


		$msg_ticket_ko = $msg_ticket_ok = "";
		
		
		
		//Query Ticket
	
		if ($todo == "doTicket")
		{	
		
		if (!$msg_ticket_ko)
		  {
			if ($id_ticket)
			{
				$query = "
				UPDATE ticket SET
				id_cliente = '$id_cliente',
				codice_articolo = '$codice_articolo',
				data_assistenza = '$data_assistenza',
				fornitore = '$fornitore',
				progetto = '$progetto',
				descrizione = '$descrizione',
				val_offerto = '$val_offerto',
				val_ordinato = '$val_ordinato',
				val_ordinato = '$val_ordinato',
				successo = '$successo',
				note = '$note',
				commento = '$commento',
				allarme = '$allarme'
				WHERE 1
				  AND id = '$id_ticket'
				";
				mysqli_query($link, $query);
		  
				
				
				header("location:ticket.php?id_ticket=" .  $id_ticket); // redirects to all records page
				exit;
				
				$msg_ticket_ok = "Attività modificata correttamente";
					
			}
			# ins
			else
			{
			  # gia?
			  $query = "
			  SELECT id
			  FROM ticket
			  WHERE id = '$id_ticket'
			  ";
			  $result = doQuery($query);
			  list($id_ticket_gia) = mysqli_fetch_array($result);
			  if ($id_ticket_gia)
				$msg_ticket_ko = "Attività già presente #$id_ticket_gia";
			  else
			  {
					if(!$val_offerto){
						$val_offerto = 0;
					}
					
					if(!$val_ordinato){
						$val_ordinato = 0;
					}
					
					if(!$val_potenziale){
						$val_potenziale = 0;
					}
					
					if(!$successo){
						$successo = 0;
					}
					$query = "
					INSERT INTO ticket SET
					id_cliente = '$id_cliente',
					codice_articolo = '$codice_articolo',
					data_assistenza = '$data_assistenza',
					fornitore = '$fornitore',
					progetto = '$progetto',
					descrizione = '$descrizione',
					val_offerto = $val_offerto,
					val_ordinato = $val_ordinato,
					val_potenziale = $val_potenziale,
					successo = $successo,
					note = '$note',
					commento = '$commento',
					allarme = '$allarme',
					id_utente = '".$_SESSION["sess_id_utente"]."'
					";
					mysqli_query($link, $query);
					

					$id_ticket = mysqli_insert_id($link);
					

					header("location:ticket.php?id_ticket=" .  $id_ticket); // redirects to all records page
					exit;
					
					$msg_ticket_ok = "Attività inserita correttamente";				  
			  }
			}
		  }
		}
		
		
		if ($id_ticket and $todo!="doTicket")
		{
		  $query = "
		  SELECT T.id, T.id_cliente, T.codice_articolo, T.data_assistenza, T.fornitore, T.progetto, T.descrizione, T.val_offerto, T.val_ordinato, T.val_potenziale, T.successo, T.note, T.commento, T.allarme, C.ragsoc1
		  FROM ticket T
		  LEFT JOIN cliente C on C.id = T.id_cliente
		  WHERE 1
			AND T.id = '$id_ticket'
		  ";
		  $result = mysqli_query($link, $query);
		  list($id_ticket, $id_cliente, $codice_articolo, $data_assistenza, $fornitore, $progetto, $descrizione, $val_offerto, $val_ordinato, $val_potenziale, $successo, $note, $commento, $allarme, $ragsoc1) = mysqli_fetch_array($result);
		}
	


		$title = $id_ticket?"$id_ticket":"Nuovo ticket";
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
					<li><a href="tickets.php">Attività</a></li>
					<li class="active"><?=$id_ticket?:"Nuovo"?></li>
				  </ol>
				  <div class="main-content">



					<div class="widget">
					  <a name="ticket"></a>
					  <?=$menu_int?>

					  <div class="widget-content-white glossed">
						<div class="padded">
						
						 <h3 class="form-title form-title-first">Attività</h3>

						<?if ($msg_ticket_ko){?>
						<div class="widget">
						  <div class="alert alert-danger alert-dismissable">
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
							<i class="icon-exclamation-sign"></i>
							<strong>Attenzione!</strong> Verifica <?=substr($msg_ticket_ko,0,-2)?>.
						  </div>
						</div>
						<?}?>
						<?if ($msg_ticket_ok){?>
						<div class="widget">
						 <div class="alert alert-success alert-dismissable">
							<i class="icon-check-sign"></i>
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
							<strong>Perfetto!</strong> <?=$msg_ticket_ok?>.
						  </div>
						</div>
						<?}?>


						<form action="ticket.php#ticket" name="frmTicket" id="frmTicket" method="post" role="form">
						  <input type="hidden" name="id_ticket" id="id_ticket" value="<?=$id_ticket?>">
						  <input type="hidden" name="todo" id="todo" value="doTicket">
						  

							
								<div class="row">
									<div class="col-md-12">
									  <div class="form-group">
										<label>Cliente</label>
															
											<select class="form-control selectpicker" id="id_cliente" name ="id_cliente" data-live-search="true" data-none-selected-text required>		
													<option value=""></option>
													<?
													$query_r = "
													SELECT id, ragsoc1, nome, cognome
													FROM cliente
													WHERE valido = 1
													";
													$result = doQuery($query_r);
													while (list($id_cliente_t, $ragsoc1_t, $nome_t, $cognome_t) = mysqli_fetch_array($result))
													{
														$sel = $id_cliente_t == $id_cliente?"selected":"";


														 echo "<option value=\"$id_cliente_t\" data-token=\"$id_cliente_t\" $sel>$ragsoc1_t - $nome_t $cognome_t</option>";
													}
													?>
											</select>

									  </div>
									</div>
								</div>
								
					<div class="row" style="overflow-x:auto;">
					  <div class="padded">
					  <a name="clienti_attivita"></a>


					 
					  <table class="table table-striped table-bordered table-hover datatable">
						<thead>
						  <tr>
							<th style="width: 50%;">Ragione Sociale</th>
							<th style="width: 25%;">Nome</th>
							<th style="width: 25%;">Cognome</th>
							<th></th>
						  </tr>

						</thead>
						<tbody>

	
	
		<?

	  $query = "
      SELECT ragsoc1, nome, cognome
		FROM cliente C
		INNER JOIN ticket T on T.id_cliente = C.id
		WHERE T.id = '$id_ticket'
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
	

						</tbody>
					  </table>
					  <hr style="border-top: dotted 1px;" />
					  


					  </div>
					</div>

				<div class="row">						
				<div class="col-md-4">
							  <div class="form-group">
								<label>Data Start</label>
								<?php 
								if(!$data_assistenza){
										$cntrlDate = date("Y-m-d");
									}else{
										$cntrlDate = $data_assistenza;
									}
											
									
								?>
								<input type="date" id="data_assistenza" name="data_assistenza" class="form-control date" placeholder="Data start" value="<?=$cntrlDate?>">
							  </div>
							</div>

						<div class="col-md-8">
							  <div class="form-group">
								<label>Progetto</label>
								<input type="text" id="progetto" name="progetto" class="form-control" placeholder="Progetto" value="<?=$progetto?>">
							  </div>
						</div>

							
				</div>

				<div class="row">						
						<div class="col-md-4">
							  <div class="form-group">
								<label>Fornitore</label>
								<input type="text" id="fornitore" name="fornitore" class="form-control" placeholder="Fornitore" value="<?=$fornitore?>">
							  </div>
						</div>

						<div class="col-md-8">
							  <div class="form-group">
								<label>Descrizione</label>
								<input type="text" id="descrizione" name="descrizione" class="form-control" placeholder="Progetto" value="<?=$descrizione?>">
							  </div>
						</div>
							
				</div>
				

						
				
				<div class="row">

					<div class="col-md-12">
					  <div class="form-group">
						<label>Articolo</label>
											
							<select class="form-control selectpicker" id="codice_articolo" name ="codice_articolo" data-live-search="true" data-none-selected-text>		
									<option value=""></option>
									<?
									$query_r = "
									SELECT codice_articolo, descrizione
									FROM articoli
									WHERE valido = 1
									";
									$result = doQuery($query_r);
									while (list($codice_articolo_t, $descr_art_t) = mysqli_fetch_array($result))
									{
										$sel = $codice_articolo_t == $codice_articolo?"selected":"";


										 echo "<option value=\"$codice_articolo_t\" data-token=\"$codice_articolo_t\" $sel>$codice_articolo_t - $descr_art_t</option>";
									}
									?>
							</select>

					  </div>
					</div>

				</div>
				
				<div class="row" style="overflow-x:auto;">
					  <div class="padded">
					  <a name="articoli_attivita"></a>


					 
					  <table class="table table-striped table-bordered table-hover datatable">
						<thead>
						  <tr>
							<th style="width: 20%;">Codice Articolo</th>
							<th style="width: 80%;">Descrizione</th>
							<th></th>
						  </tr>

						</thead>
						<tbody>

	
	
		<?

	  $query = "
      SELECT A.codice_articolo, A.descrizione
		FROM articoli A
		INNER JOIN ticket T on T.codice_articolo = A.codice_articolo
		WHERE T.id = '$id_ticket'
		";
		$result = doQuery($query);

	  while (list($codice_articolo_t, $descr_art_t) = mysqli_fetch_array($result))
	  { 
	  


		
	?>
						  <tr>
							<td>
							  <?=$codice_articolo_t?> 
							</td>
							<td>
							  <?=$descr_art_t?>
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
					<div class="col-md-2">
					  <div class="form-group">
						<label>Valore offerto</label>
						<input type="number" id="val_offerto" name="val_offerto" class="form-control" placeholder="Valore Offerto"  step="any" value="<?=$val_offerto?>">
					  </div>
					</div>	

					<div class="col-md-2">
					  <div class="form-group">
						<label>Valore in base a %</label>
						<? 
						$val_percentuale = 0;
						if(!empty($val_offerto) && !empty($successo)){$val_percentuale = $val_offerto * $successo / 100;} ?>
						<input type="number" id="val_percentuale" name="val_percentuale" class="form-control" placeholder="Valore in base a %"  step="any" value="<?=$val_percentuale?>" readonly>
					  </div>
					</div>	

					<div class="col-md-2">
					  <div class="form-group">
						<label>Valore ordinato</label>
						<input type="number" id="val_ordinato" name="val_ordinato" class="form-control" placeholder="Valore Ordinato"  step="any" value="<?=$val_ordinato?>">
					  </div>
					</div>	

					<div class="col-md-2">
					  <div class="form-group">
						<label>Valore potenziale</label>
						<input type="number" id="val_potenziale" name="val_potenziale" class="form-control" placeholder="Valore Potenziale"  step="any" value="<?=$val_potenziale?>">
					  </div>
					</div>	

					<div class="col-md-2">
					  <div class="form-group">
						<label>Successo</label>
						<input type="number" id="successo" name="successo" class="form-control" placeholder="% Successo" value="<?=$successo?>">
					  </div>
					</div>
					
					<div class="col-md-2">
							  <div class="form-group">
								<label>Allarme</label>
								<input type="date" id="allarme" name="allarme" class="form-control date" placeholder="Allarme" value="<?=$allarme?>">
							  </div>
							</div>
					
				</div>
				
				<div class="row">
					<div class="col-md-12">
					  <div class="form-group">
						<label>Note</label>
						<textarea type="textarea" id="note" name="note" class="form-control" ><?=$note?></textarea>
					  </div>
					</div>		

					<div class="col-md-12">
					  <div class="form-group">
						<label>Commento WiCom</label>
						<textarea type="textarea" id="commento" name="commento" class="form-control" ><?=$commento?></textarea>
					  </div>
					</div>	
					
					
					
				</div>
				
				
				
					

						  
							<div class="row">
							<div class="col-md-12 text-center">
							<?if (isAdmin() and $id_ticket){?>
							  <button type="submit" name="submit" value="submit" class="btn btn-primary">Modifica</button>
							<?}elseif (!$id_ticket){?>
							  <button type="submit" name="submit" value="submit" class="btn btn-primary">Inserisci</button>
							<?}?>
							</div>
							
						  </div>
						  
						</form>
						
							
				</div>
				 </div>
				 
				 
				
				 
				 </div>
						
						</form>
						

						
							
				</div>
				 </div>				 
				
				 
				 </div>


</div>

		

					
				   </div>
				</div>



		
					





		<hr />
		
					
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



<script>
	$("#search").chosen({width: '100%'});
</script>

<script>
	$("#searchArticoli").chosen({width: '100%'});
</script>

		