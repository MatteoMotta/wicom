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

	#cliente
	if (isset($_REQUEST['id']))
	 $id = mysqli_real_escape_string($link,$_REQUEST['id']);
	else
	 $id = "";

	if (isset($_REQUEST['id_offerta']))
	 $id_offerta = mysqli_real_escape_string($link,$_REQUEST['id_offerta']);
	else
	 $id_offerta = "";
		
	if (isset($_REQUEST['codice_articolo']))
	  $codice_articolo = mysqli_real_escape_string($link,$_REQUEST['codice_articolo']);
	else $codice_articolo = "";

	if (isset($_REQUEST['qta']))
	  $qta = mysqli_real_escape_string($link,$_REQUEST['qta']);
	else $qta = "";

	if (isset($_REQUEST['prezzo']))
	  $prezzo = mysqli_real_escape_string($link,$_REQUEST['prezzo']);
	else $prezzo = "";

	if (isset($_REQUEST['data_consegna']))
	  $data_consegna = mysqli_real_escape_string($link,$_REQUEST['data_consegna']);
	else $data_consegna = "";

	if (isset($_REQUEST['sconto']))
	  $sconto = mysqli_real_escape_string($link,$_REQUEST['sconto']);
	else $sconto = "";
		
	
	if (isset($_REQUEST['todo']))
	  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
	else
	  $todo = "";

	$msg_articolo_ko = $msg_articolo_ok = "";
	
	//INSERISCI O MODIFICA ARTICOLO
	
		if ($todo == "doArt")
		{	

			if (isset($_POST['modifica'])){
				$query = "
				UPDATE articoli_offerta SET
				codice_articolo = '$codice_articolo',
				qta = '$qta',
				prezzo = '$prezzo',
				data_consegna = '$data_consegna',
				sconto = '$sconto'
				WHERE 1
				  AND id = '$id'
				";
				mysqli_query($link, $query);
		  
				header("location:offerta.php?id_offerta=".$id_offerta ); // redirects to all records page
				exit;
			}elseif(isset($_POST['indietro'])){
				header("location:offerta.php?id_offerta=".$id_offerta ); // redirects to all records page
				exit;
			}
		  

		}



	if ($id and $todo!="doArt")
	{
	  $query = "
	  SELECT codice_articolo, prezzo, qta, sconto, data_consegna
	  FROM articoli_offerta A
	  WHERE 1
		AND A.id = '$id'
	  ";
	  $result = doQuery($query);
	  list($codice_articolo, $prezzo, $qta, $sconto, $data_consegna
		   ) = mysqli_fetch_array($result);
	}

	$title = $codice_articolo?"$descrizione":"Nuovo Articolo";
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
				<li><a href="offerta.php?id_offerta=<?$id_offerta?>">Offerta</a></li>
				<li class="active"><?=$id_offerta?></li>
			  </ol>
			  <div class="main-content">


				<div class="widget">
				  <a name="articolo_offerta"></a>

				  <?=$menu_int?>

				  <div class="widget-content-white glossed">
					<div class="padded">

					  <h3 class="form-title form-title-first">Modifica riga articolo</h3>

					<?if ($msg_articolo_ko){?>
					<div class="widget">
					  <div class="alert alert-danger alert-dismissable">
						<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
						<i class="icon-exclamation-sign"></i>
						<strong>Attenzione!</strong> Verifica <?=substr($msg_articolo_ko,0,-2)?>.
					  </div>
					</div>
					<?}?>
					<?if ($msg_articolo_ok){?>
					<div class="widget">
					 <div class="alert alert-success alert-dismissable">
						<i class="icon-check-sign"></i>
						<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
						<strong>Perfetto!</strong> <?=$msg_articolo_ok?>.
					  </div>
					</div>
					<?}?>

					<form action="updArtOfferta.php#articolo_offerta" name="frmArt" id="frmArt" method="post" role="form">
					  <input type="hidden" name="id" id="id" value="<?=$id?>">
					  <input type="hidden" name="id_offerta" id="id_offerta" value="<?=$id_offerta?>">
					  <input type="hidden" name="todo" id="todo" value="doArt">

					  <div class="row">
						<div class="col-md-8">
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
							
						<div class="col-md-4">
						  <div class="form-group">
							<label>Quantità</label>
							<input   type="text" id="qta" name="qta" class="form-control" placeholder="Quantità" value="<?=$qta?>">
						  </div>
						</div>
						
						
					  </div>
					  
					  <div class="row">
						<div class="col-md-4">
						  <div class="form-group">
							<label>Prezzo</label>
							<input   type="text" id="prezzo" name="prezzo" class="form-control" placeholder="Prezzo" value="<?=$prezzo?>">
						  </div>
						</div>										

						<div class="col-md-4">
							  <div class="form-group">
								<label>Sconto</label>
								<input type="number" id="sconto" name="sconto" class="form-control" placeholder="Sconto"  step="any" value="<?=$sconto?>">
							  </div>
							</div>
							<div class="col-md-4">
							  <div class="form-group">
								<label>Data consegna</label>
								<input type="text" id="data_consegna" name="data_consegna" class="form-control" placeholder="Data consegna" value="<?=$data_consegna?>">
							  </div>
							</div>	
					  </div>
				  
					  
					<div class="row">
						<div class="col-md-6 text-right">					
								<button type="submit" name="indietro" class="btn btn-primary">Indietro</button>
						</div>
						<div class="col-md-6 text-left">
						
							  <button type="submit" name="modifica" value="submit" class="btn btn-primary" onclick="return confirm('Sei sicuro di voler modificare?')">Modifica</button>
						</div>
						
					 </div>
				

					</form>

				 </div>
			   </div>
			 </div>

		  </div>
		</div>
	  </div>
	</div>
	</div>
	</div>


	
<script>
	$("#searchArticoli").chosen({width: '100%'});
</script>
	
	