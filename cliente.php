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
	
	if (isset($_REQUEST['valido']))
	  $valido = mysqli_real_escape_string($link,$_REQUEST['valido']);
	else
	  $valido = "";

	#cliente
	if (isset($_REQUEST['id_cliente']))
	  $id_cliente = mysqli_real_escape_string($link,$_REQUEST['id_cliente']);
	else
	  $id_cliente = "";
  
 	if (isset($_REQUEST['valido'])) $valido = 1; else $valido = 0;
  
	if (isset($_REQUEST['ragsoc1']))
	  $ragsoc1 = mysqli_real_escape_string($link,$_REQUEST['ragsoc1']);
	else
	  $ragsoc1 = "";
   
	if (isset($_REQUEST['titolo']))
	  $titolo = mysqli_real_escape_string($link,$_REQUEST['titolo']);
	else
	  $titolo = "";
   
	if (isset($_REQUEST['nome']))
	  $nome = mysqli_real_escape_string($link,$_REQUEST['nome']);
	else
	  $nome = "";
  
  	if (isset($_REQUEST['cognome']))
	  $cognome = mysqli_real_escape_string($link,$_REQUEST['cognome']);
	else
		$cognome = "";

	if (isset($_REQUEST['indirizzo']))
	  $indirizzo = mysqli_real_escape_string($link,$_REQUEST['indirizzo']);
	else
	  $indirizzo = "";

	if (isset($_REQUEST['localita']))
	  $localita = mysqli_real_escape_string($link,$_REQUEST['localita']);
	else
	  $localita = "";
  
	if (isset($_REQUEST['cap']))
	  $cap = mysqli_real_escape_string($link,$_REQUEST['cap']);
	else
	  $cap = "";

	if (isset($_REQUEST['provincia']))
	  $provincia = mysqli_real_escape_string($link,$_REQUEST['provincia']);
	else
	  $provincia = "";
 
	if (isset($_REQUEST['regione']))
	  $regione = mysqli_real_escape_string($link,$_REQUEST['regione']);
	else
	  $regione = "";
 
	if (isset($_REQUEST['ruolo']))
	  $ruolo = mysqli_real_escape_string($link,$_REQUEST['ruolo']);
	else
	 $ruolo = "";


	if (isset($_REQUEST['categoria']))
	  $categoria = mysqli_real_escape_string($link,$_REQUEST['categoria']);
	else
		$categoria = "";

	if (isset($_REQUEST['note']))
	  $note = mysqli_real_escape_string($link,$_REQUEST['note']);
	else
		$note = "";
	
	if (isset($_REQUEST['tel1']))
	  $tel1 = mysqli_real_escape_string($link,$_REQUEST['tel1']);
	else
		$tel1 = "";

	if (isset($_REQUEST['tel2']))
	  $tel2 = mysqli_real_escape_string($link,$_REQUEST['tel2']);
	else
		$tel2 = "";

	if (isset($_REQUEST['email']))
	  $email = mysqli_real_escape_string($link,$_REQUEST['email']);
	else
		$email = "";


	  //Todo
	  
		if (isset($_REQUEST['todo']))
		  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
		else
		  $todo = "";

	$msg_anag_ko = $msg_anag_ok = "";

	# Anagrafica
	if ($todo == "doAnag")
	{
	  if (!$ragsoc1)
		$msg_anag_ko .= "ragsoc1, ";
	
	


	# upd
	  if (!$msg_anag_ko)
	  {
		if ($id_cliente)
		{		  
			$query = "
			UPDATE cliente SET
			ragsoc1 = '$ragsoc1',
			titolo = '$titolo',
			nome = '$nome',
			cognome = '$cognome',
			indirizzo = '$indirizzo',
			localita = '$localita',
			cap = '$cap',
			provincia = '$provincia',
			regione = '$regione',
			ruolo = '$ruolo',			
			email = '$email',
			tel1 = '$tel1',
			tel2 = '$tel2',
			categoria = '$categoria',			
			note = '$note',
			valido = '$valido'
			WHERE 1
			  AND id = '$id_cliente'
			";
			doQuery($query);
			$msg_anag_ok = "Cliente modificato correttamente";
		  
		}
		# ins
		else
		{
		  # gia?
		  $query = "
		  SELECT id
		  FROM cliente
		  WHERE 1
			AND ragsoc1 = '$ragsoc1'
			AND nome = '$nome'
			AND cognome = '$cognome'
		  ";
		  $result = doQuery($query);
		  list($id_cliente_gia) = mysqli_fetch_array($result);
		  if ($id_cliente_gia)
			$msg_anag_ko = "Cliente già presente #$id_cliente_gia  ";
		  else
		  {
			$query = "
			INSERT INTO cliente SET
			ragsoc1 = '$ragsoc1',
			titolo = '$titolo',
			nome = '$nome',
			cognome = '$cognome',
			indirizzo = '$indirizzo',
			localita = '$localita',
			cap = '$cap',
			provincia = '$provincia',
			regione = '$regione',
			ruolo = '$ruolo',			
			email = '$email',
			tel1 = '$tel1',
			tel2 = '$tel2',
			categoria = '$categoria',			
			note = '$note',
			valido = '$valido'
			";
			doQuery($query);
			$id_cliente = mysqli_insert_id($link);
			$msg_anag_ok = "Cliente inserito correttamente";
		  }
		}
	  }
	}




	if ($id_cliente and $todo!="doAnag")
	{
	  $query = "
	  SELECT id, ragsoc1, titolo, nome, cognome, ruolo, indirizzo, localita, cap, provincia, regione, tel1, tel2, email, categoria, note, valido
	  FROM cliente C
	  WHERE 1
		AND C.id = '$id_cliente'
	  ";
	  $result = doQuery($query);
	  list($id, $ragsoc1, $titolo, $nome, $cognome, $ruolo, $indirizzo, $localita, $cap, $provincia, $regione, $tel1, $tel2, $email, $categoria, $note, $valido
		   ) = mysqli_fetch_array($result);
	}

	$title = $id_cliente?"$nome":"Nuovo Cliente";
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
				<li><a href="clienti.php?valido=1">Clienti</a></li>
				<li class="active"><?=$id_cliente?$nome:"Nuovo"?></li>
			  </ol>
			  <div class="main-content">


				<div class="widget">
				  <a name="anagrafica"></a>
				  <h3 class="section-title first-title"><i class="icon-group"></i><?=$id_cliente?"$id_cliente - $ragsoc1":"Nuovo cliente"?></h3>

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

					<form action="cliente.php#anag" name="frmAnag" id="frmAnag" method="post" role="form">
					  <input type="hidden" name="id_cliente" id="id_cliente" value="<?=$id_cliente?>">
					  <input type="hidden" name="todo" id="todo" value="doAnag">

					  <div class="row">
						<div class="col-md-4">
						  <div class="form-group">
							<label>Ragione Sociale</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="ragsoc1" name="ragsoc1" class="form-control" placeholder="Ragione Sociale" value="<?=$ragsoc1?>" required>
						  </div>
						</div>
						<div class="col-md-2">
						  <div class="form-group">
							<label>Titolo</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?>  type="text" id="titolo" name="titolo" class="form-control" placeholder="Titolo" value="<?=$titolo?>" >
						  </div>
						</div>						
						<div class="col-md-2">
						  <div class="form-group">
							<label>Nome</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?>  type="text" id="nome" name="nome" class="form-control" placeholder="Nome" value="<?=$nome?>" >
						  </div>
						</div>
						<div class="col-md-2">
						  <div class="form-group">
							<label>Cognome</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?>  type="text" id="cognome" name="cognome" class="form-control" placeholder="Cognome" value="<?=$cognome?>" >
						  </div>
						</div>
						<div class="col-md-2">
						  <div class="form-group">
							<label>Ruolo</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="ruolo" name="ruolo" class="form-control" placeholder="Ruolo" value="<?=$ruolo?>" >
						  </div>
						</div>
						
					  </div>
				
					  <div class="row">
						<div class="col-md-4">
						  <div class="form-group">
							<label>Città</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="localita" name="localita" class="form-control" placeholder="Città" value="<?=$localita?>" >
						  </div>
						</div>
						<div class="col-md-2">
						  <div class="form-group">
							<label>Indirizzo</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="indirizzo" name="indirizzo" class="form-control" placeholder="Indirizzo" value="<?=$indirizzo?>" >
						  </div>
						</div>							
						<div class="col-md-2">
						  <div class="form-group">
							<label>CAP</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?>  type="text" id="cap" name="cap" class="form-control" placeholder="CAP" value="<?=$cap?>">
						  </div>
						</div>
						<div class="col-md-2">
						  <div class="form-group">
							<label>Provincia</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="provincia" name="provincia" class="form-control" placeholder="Provincia" value="<?=$provincia?>" >
						  </div>
						</div>	
						<div class="col-md-2">
						  <div class="form-group">
							<label>Regione</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="regione" name="regione" class="form-control" placeholder="Regione" value="<?=$regione?>" >
						  </div>
						</div>							
					  </div>  
					  
					  <div class="row">
						<div class="col-md-4">
						  <div class="form-group">
							<label>Telefono</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="tel1" name="tel1" class="form-control" placeholder="Telefono" value="<?=$tel1?>" >
						  </div>
						</div>
						<div class="col-md-4">
						  <div class="form-group">
							<label>Telefono2</label>
							<input  <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="tel2" name="tel2" class="form-control" placeholder="Telefono 2" value="<?=$tel2?>" >
						  </div>
						</div>
						<div class="col-md-4">
						  <div class="form-group">
							<label>Email</label>
							<input  <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="email" name="email" class="form-control" placeholder="Email" value="<?=$email?>" >
						  </div>
						</div>
					   
					  </div>					  

					  <div class="row">
						<div class="col-md-12">
						  <div class="form-group">
							<label>Categoria</label>
							<input <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="categoria" name="categoria" class="form-control" placeholder="Categoria" value="<?=$categoria?>" >
						  </div>
						</div>
					  </div>
					  <div class="row">
						<div class="col-md-12">
						  <div class="form-group">
							<label>Note</label>
							<textarea <?=(isCopywriter() and $id_cliente)?"readonly":""?> type="text" id="categoria" name="note" class="form-control" placeholder="Note" value="<?=$note?>" ><?=$note?></textarea>
						  </div>
						</div>
					  </div>	
					  <div class="row">
						<div class="col-md-2">
						  <div class="form-group">
							<label>Valido</label><br>
								<input name="valido" type="checkbox" id="valido" value="valido" <? if($valido == 1){?>checked<?}?>>
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
	
	