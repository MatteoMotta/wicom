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

	 unset($_SESSION['att_tecnico']);
	 unset($_SESSION['progressivi']);
	 unset($_SESSION['report']);
	 unset($_SESSION['articoli']);
	 unset($_SESSION['tipoIntervento']);
	 
		############ TICKET
		# modifica
		

		
		

	  	if (isset($_REQUEST['id_progressivo']))
		  $id_progressivo = mysqli_real_escape_string($link,$_REQUEST['id_progressivo']);
		else
		  $id_progressivo = "";	
	  
	  
	  	if (isset($_REQUEST['progressivo']))
		  $progressivo = mysqli_real_escape_string($link,$_REQUEST['progressivo']);
		else
		  $progressivo = "";	

	  	if (isset($_REQUEST['anno']))
		  $anno = mysqli_real_escape_string($link,$_REQUEST['anno']);
		else
		  $anno = "";	
	  
	  //Todo
	  
		if (isset($_REQUEST['todo']))
		  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
		else
		  $todo = "";


		$msg_progressivo_ko = $msg_progressivo_ok = "";
		$msg_report_ko = $msg_report_ok = "";		
		$msg_attivita_ko = $msg_attivita_ok = "";	
		$msg_articoli_ko = $msg_articoli_ok = "";	
		
		
		
		//Query Ticket
	
		if ($todo == "doProgressivo")
		{	
		
		if (!$msg_progressivo_ko)
		  {
				$query = "
				UPDATE progressivi SET
				anno = '$anno',
				progressivo = '$progressivo'
				WHERE 1
				  AND id_progressivo = '$id_progressivo'
				";
				mysqli_query($link, $query);
		  
		  $msg_progressivo_ok = "Ticket modificato correttamente";
		  
			header("location:progressivo.php?id_progressivo=" .  $id_progressivo ); // redirects to all records page
			exit;
			
		  }
		}
		
		
		if ($id_progressivo and $todo!="doProgressivo")
		{
		  $query = "
		  SELECT P.anno, P.id_bollettario, P.progressivo, B.bollettario
		  FROM progressivi P
		  INNER JOIN bollettario B on B.id_bollettario = P.id_bollettario
		  WHERE 1
			AND P.id_progressivo = '$id_progressivo'
		  ";
		  $result = mysqli_query($link, $query);
		  list($anno, $id_bollettario, $progressivo, $bollettario) = mysqli_fetch_array($result);
		}
	


		$title = $id_progressivo?"$id_progressivo":"Nuovo ticket";
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
					<li><a href="progressivi.php">Progressivi</a></li>
					<li class="active"><?=$id_progressivo?:"Nuovo"?></li>
				  </ol>
				  <div class="main-content">



					<div class="widget">
					  <a name="progressivo"></a>
					  <?=$menu_int?>

					  <div class="widget-content-white glossed">
						<div class="padded">
						
						 <h3 class="form-title form-title-first">Servizio di assistenza - Progressivi</h3>

						<?if ($msg_progressivo_ko){?>
						<div class="widget">
						  <div class="alert alert-danger alert-dismissable">
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
							<i class="icon-exclamation-sign"></i>
							<strong>Attenzione!</strong> Verifica <?=substr($msg_progressivo_ko,0,-2)?>.
						  </div>
						</div>
						<?}?>
						<?if ($msg_progressivo_ok){?>
						<div class="widget">
						 <div class="alert alert-success alert-dismissable">
							<i class="icon-check-sign"></i>
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
							<strong>Perfetto!</strong> <?=$msg_progressivo_ok?>.
						  </div>
						</div>
						<?}?>

						<form action="progressivo.php#progressivo" name="frmProg" id="frmProg" method="post" role="form">
						  <input type="hidden" name="id_progressivo" id="id_progressivo" value="<?=$id_progressivo?>">
						  <input type="hidden" name="todo" id="todo" value="doProgressivo">
						  
						 <div class="row">	
							<div class="col-md-5">
							  <div class="form-group">
								<label>Bollettario</label>
								<p style="font-size: 21px;"><?=$bollettario?></p>
							  </div>
							</div>				
						</div>

		
				<div class="row">
						<div class="col-md-5">
							  <div class="form-group">
								<label>Anno</label>
								<input type="number" id="anno" name="anno" class="form-control" placeholder="Anno" value="<?=$anno?>">
							  </div>
						</div>

						<div class="col-md-5">
							  <div class="form-group">
								<label>Progressivo</label>
								<input type="number" id="progressivo" name="progressivo" class="form-control" placeholder="Progressivo" value="<?=$progressivo?>">
							  </div>
						</div>

							
				</div>

						  
							<div class="row">
							<div class="col-md-12 text-center">
							<?if (isAdmin() and $id_progressivo){?>
							  <button type="submit" name="submit" value="submit" class="btn btn-primary">Modifica</button>
							<?}elseif (!$id_progressivo){?>
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



		
					





		<hr />
		
					
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


		