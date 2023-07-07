<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<?
	#### permessi
	$req = 12; # tutti

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

	  print_r($_FILES);
	  echo "</pre>";
	}

	#tecnico
	if (isset($_REQUEST['id_tecnico']))
	  $id_tecnico = mysqli_real_escape_string($link,$_REQUEST['id_tecnico']);
	else
	  $id_tecnico = "";
  
	if (isset($_REQUEST['nome']))
	  $nome = mysqli_real_escape_string($link,$_REQUEST['nome']);
	else
	  $nome = "";
  
	if (isset($_REQUEST['cognome']))
	  $cognome = mysqli_real_escape_string($link,$_REQUEST['cognome']);
	else
	  $cognome = "";

	  //Todo
	  
		if (isset($_REQUEST['todo']))
		  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
		else
		  $todo = "";

	$msg_anag_ko = $msg_anag_ok = "";

	# Anagrafica
	if ($todo == "doAnag")
	{
	  if (!$nome)
		$msg_anag_ko .= "Nome, ";
	
	if (!$cognome)
		$msg_anag_ko .= "Cognome, ";


	# upd
	  if (!$msg_anag_ko)
	  {
		if ($id_tecnico)
		{
		  # gia?
		  $query = "
		  SELECT id
		  FROM tecnici
		  WHERE 1
			AND id <> '$id_tecnico'
			AND nome = '$nome'
			AND cognome = '$cognome'
		  ";
		  $result = doQuery($query);
		  list($id_tecnico_gia) = mysqli_fetch_array($result);
		  if ($id_tecnico_gia)
			$msg_anag_ko = "Tecnico già presente #$id_tecnico_gia  ";
		  else
		  {
			$query = "
			UPDATE tecnici SET
			nome = '$nome',
			cognome = '$cognome'
			WHERE 1
			  AND id = '$id_tecnico'
			";
			doQuery($query);
			$msg_anag_ok = "Tecnico modificato correttamente";
		  }
		}
		# ins
		else
		{
		  # gia?
		  $query = "
		  SELECT id
		  FROM tecnici
		  WHERE 1
			AND nome = '$nome'
			AND cognome = '$cognome'
		  ";
		  $result = doQuery($query);
		  list($id_tecnico_gia) = mysqli_fetch_array($result);
		  if ($id_tecnico_gia)
			$msg_anag_ko = "Tecnico già presente #$id_tecnico_gia  ";
		  else
		  {
			$query = "
			INSERT INTO tecnici SET
			nome = '$nome',
			cognome = '$cognome',
			attivo = 1
			";
			doQuery($query);
			$id_tecnico = mysqli_insert_id($link);
			$msg_anag_ok = "Tecnico inserito correttamente";
		  }
		}
	  }
	}




	if ($id_tecnico and $todo!="doAnag")
	{
	  $query = "
	  SELECT T.id, T.nome, T.cognome
	  FROM tecnici T
	  WHERE 1
		AND T.id = '$id_tecnico'
	  ";
	  $result = doQuery($query);
	  list($id_tecnico, $nome, $cognome
		   ) = mysqli_fetch_array($result);
	}

	$title = $id_tecnico?"$nome":"Nuovo Tecnico";
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
				<li><a href="clienti.php">Tecnici</a></li>
				<li class="active"><?=$id_tecnico?$nome:"Nuovo"?></li>
			  </ol>
			  <div class="main-content">


				<div class="widget">
				  <a name="anagrafica"></a>
				  <h3 class="section-title first-title"><i class="icon-group"></i><?=$id_tecnico?"$id_tecnico $nome $cognome":"Nuovo tecnico"?></h3>

				  <?=$menu_int?>

				  <div class="widget-content-white glossed">
					<div class="padded">

					  <h3 class="form-title form-title-first">Anagrafica</h3>

					<?if ($msg_anag_ko){?>
					<div class="widget">
					  <div class="alert alert-danger alert-dismissable">
						<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
						<i class="icon-exclamation-sign"></i>
						<strong>Attenzione!</strong> Verifica <?=substr($msg_anag_ko,0,-2)?>.
					  </div>
					</div>
					<?}?>
					<?if ($msg_anag_ok){?>
					<div class="widget">
					 <div class="alert alert-success alert-dismissable">
						<i class="icon-check-sign"></i>
						<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
						<strong>Perfetto!</strong> <?=$msg_anag_ok?>.
					  </div>
					</div>
					<?}?>

					<form action="tecnico.php#anag" name="frmAnag" id="frmAnag" method="post" role="form">
					  <input type="hidden" name="id_tecnico" id="id_tecnico" value="<?=$id_tecnico?>">
					  <input type="hidden" name="todo" id="todo" value="doAnag">

					  <div class="row">
						<div class="col-md-4">
						  <div class="form-group">
							<label>*Nome</label>
							<input <?=(isCopywriter() and $id_tecnico)?"readonly":""?> type="text" id="nome" name="nome" class="form-control" placeholder="Nome" value="<?=$nome?>">
						  </div>
						</div>
						<div class="col-md-4">
						  <div class="form-group">
							<label>*Cognome</label>
							<input <?=(isCopywriter() and $id_tecnico)?"readonly":""?> type="text" id="cognome" name="cognome" class="form-control" placeholder="Cognome" value="<?=$cognome?>">
						  </div>
						</div>
						
					   
					  </div>

					
  
						  
							<div class="row">
							<div class="col-md-12 text-center">
							  <button type="submit" class="btn btn-primary">Salva</button>
							  <!-- <button type="reset" class="btn btn-default">Annulla</button> -->
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
	
	