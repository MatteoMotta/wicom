<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
	if (isset($_REQUEST['codice_articolo']))
	  $codice_articolo = mysqli_real_escape_string($link,$_REQUEST['codice_articolo']);
	else $codice_articolo = "";
	
	if (isset($_REQUEST['id_articolo']))
	  $id_articolo = mysqli_real_escape_string($link,$_REQUEST['id_articolo']);
	else $id_articolo = "";

	
	if (isset($_REQUEST['descrizione'])) $descrizione = mysqli_real_escape_string($link,$_REQUEST['descrizione']); else $descrizione = "";
	
	if (isset($_REQUEST['um'])) $um = mysqli_real_escape_string($link,$_REQUEST['um']); else $um = "";
	
	if (isset($_REQUEST['valido'])) $valido = 1; else $valido = 0;
	
	if (isset($_REQUEST['todo']))
	  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
	else
	  $todo = "";

	$msg_articolo_ko = $msg_articolo_ok = "";

	//INSERISCI O MODIFICA ARTICOLO
		if ($todo == "doAnag")
		{	

	if (!$msg_articolo_ko)
		 {
			  
			  
			if ($id_articolo)
			{
				$query = "
				UPDATE articoli SET
				descrizione = '$descrizione',
				um = '$um',
				valido = '$valido'
				WHERE 1
				  AND id_articolo = '$id_articolo'
				";
				mysqli_query($link, $query);
		  
				$msg_articolo_ok = "Articolo modificato correttamente";
			}
			# ins
			else
			{
			  # gia?
			  $query = "
			  SELECT codice_articolo
			  FROM articoli
			  WHERE id_articolo = '$id_articolo'
			  ";
			  $result = doQuery($query);
			  list($id_articolo_gia) = mysqli_fetch_array($result);
			  if ($id_articolo_gia)
				$msg_ticket_ko = "Articolo già presente #$id_articolo_gia";
			  else
			  {
				 
					$query = "
					INSERT INTO articoli SET
					codice_articolo = '$codice_articolo',
					descrizione = '$descrizione',
					um = '$um',
					valido = '$valido'
					";
					mysqli_query($link, $query);
					

					
					$id_articolo = mysqli_insert_id($link);
					
					$msg_articolo_ok = "Articolo inserito correttamente";

					 
				  
			  }
			}
		  }
		}
		



	if ($id_articolo and $todo!="doAnag")
	{
	  $query = "
	  SELECT codice_articolo, descrizione, um, valido
	  FROM articoli A
	  WHERE 1
		AND A.id_articolo = '$id_articolo'
	  ";
	  $result = doQuery($query);
	  list($codice_articolo, $descrizione, $um, $valido
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
				<li><a href="articoli.php?valido=1">Articoli</a></li>
				<li class="active"><?=$codice_articolo?$descrizione:"Nuovo"?></li>
			  </ol>
			  <div class="main-content">


				<div class="widget">
				  <a name="anagrafica"></a>
				  <h3 class="section-title first-title"><i class="icon-group"></i><?=$codice_articolo?"$descrizione":"Nuovo articolo"?></h3>

				  <?=$menu_int?>

				  <div class="widget-content-white glossed">
					<div class="padded">

					  <h3 class="form-title form-title-first">Anagrafica</h3>

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

					<form action="articolo.php#anag" name="frmAnag" id="frmAnag" method="post" role="form">
					  <input type="hidden" name="id_articolo" id="id_articolo" value="<?=$id_articolo?>">
					  <input type="hidden" name="todo" id="todo" value="doAnag">

					  <div class="row">
						<div class="col-md-4">
						  <div class="form-group">
							<label>Codice Articolo</label>
							<input type="text" id="codice_articolo" name="codice_articolo" class="form-control" placeholder="Codice Articolo" value="<?=$codice_articolo?>" <?if($codice_articolo){?> readonly <?} ?> maxlength="17" required>
						  </div>
						</div>
						<div class="col-md-8">
						  <div class="form-group">
							<label>Unità di misura</label>
							<input   type="text" id="um" name="um" class="form-control" placeholder="Unità di misura" maxlength="5" value="<?=$um?>">
						  </div>
						</div>
						
						
					  </div>
					  
					  <div class="row">
						<div class="col-md-12">
						  <div class="form-group">
							<label>Descrizione</label>
							<input   type="text" id="descrizione" name="descrizione" class="form-control" placeholder="Descrizione" maxlength="114" value="<?=$descrizione?>">
						  </div>
						</div>										
					  </div>
					  
					  <div class="row">
						<div class="col-md-2">
						  <div class="form-group">
							<label>Valido</label><br>
								<input name="valido" type="checkbox" id="valido" value="valido" <? if($valido == 1){?>checked<?}?> >
						  </div>
						</div>										
					  </div>

				  
					  
					<div class="row">
						<div class="col-md-12 text-center">
							<?if (isAdmin() and $codice_articolo){?>
							  <button type="submit" name="submit" value="submit" class="btn btn-primary">Modifica</button>
							<?}elseif (!$codice_articolo){?>
							  <button type="submit" name="submit" value="submit" class="btn btn-primary">Inserisci</button>
							<?}?>
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


	<?require "inc_footer.php"?>
	<?
	if (0)
	{
	  echo "<pre>";
	  print_r($_REQUEST);

	  print_r($_FILES);
	  echo "</pre>";
	}
	?>
	
	