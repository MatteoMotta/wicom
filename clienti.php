<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />


<?
#### permessi
$req = 12; # admin

require "inc_config.php";
require "inc_sicurezza_bo.php";

if (0)
{
  echo "<pre>";
  print_r($_REQUEST);
  echo "</pre>";
}

#cliente
if (isset($_REQUEST['valido']))
  $valido = mysqli_real_escape_string($link,$_REQUEST['valido']);
else
  $valido = "";

if (isset($_REQUEST['id_cliente']))
  $id_cliente = mysqli_real_escape_string($link,$_REQUEST['id_cliente']);
else
  $id_cliente = "";

if (isset($_REQUEST['localita']))
  $localita = mysqli_real_escape_string($link,$_REQUEST['localita']);
else
  $localita = "";

if (isset($_REQUEST['provincia']))
  $provincia = mysqli_real_escape_string($link,$_REQUEST['provincia']);
else
  $provincia = "";

if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";
$msg_ok = "";



if (isAdmin() and $id_cliente and $todo=="del")
{
  $query = "
  DELETE FROM cliente
  WHERE 1
    AND id_cliente = '$id_cliente'
  ";
  doQuery($query);

  $query = "
  DELETE FROM cliente
  WHERE 1
    AND id_cliente = '$id_cliente'
  ";
  doQuery($query);

  $msg_ok = "Cliente rimosso definitivamente";
}

$title = "Clienti";
require "inc_header.php"
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
            <h1><i class="icon-group"></i> Clienti</h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li class="active">Clienti</li>
          </ol>
          <div class="main-content">
<?if ($msg_ok){?>
<div class="widget">
 <div class="alert alert-success alert-dismissable">
    <i class="icon-check-sign"></i>
    <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
    <strong>Perfetto!</strong> <?=$msg_ok?>.
  </div>
</div>
<?}?>
            <div class="widget">
              <h3 class="section-title first-title"><i class="icon-group"></i> Clienti
			  <a href="cliente.php" type="button" class="btn" style="float:right"><i class="icon-plus"></i>Aggiungi</a>
              </h3>
              <div class="widget-content-white glossed">
                <div class="padded" style="overflow-x: auto;">
				
				
					<form action="clienti.php" name="frmClienti" id="frmClienti" method="post" role="form">
						  <input type="hidden" name="todo" id="todo" value="do">
						  <div class="row">

							
							<div class="col-md-4">
							  <div class="form-group">
								<label>Località</label>
								<select name="localita" id="localita" class="form-control">

									<?
									$query_r = "
									SELECT distinct localita
									FROM cliente
									ORDER BY localita
									";
									$result = doQuery($query_r);
									while (list($localita_t) = mysqli_fetch_array($result))
									{
										$sel = $localita_t == $localita?"selected":"";


										 echo "<option value=\"$localita_t\" $sel>$localita_t</option>";
									}
									?>
								</select>
							  </div>
							</div>

							<div class="col-md-4">
							  <div class="form-group">
								<label>Provincia</label>
								<select name="provincia" id="provincia" class="form-control">

									<?
									$query_r = "
									SELECT distinct provincia
									FROM cliente
									ORDER BY provincia
									";
									$result = doQuery($query_r);
									while (list($provincia_t) = mysqli_fetch_array($result))
									{
										$sel = $provincia_t == $provincia?"selected":"";


										 echo "<option value=\"$provincia_t\" $sel>$provincia_t</option>";
									}
									?>
								</select>
							  </div>
							</div>
							
								<div class="col-md-4">									
									  <div class="form-group">
										<label>Valido</label>
										<select name="valido" id="valido" class="form-control">
											<?
											$query_r = "
											SELECT distinct valido
											FROM cliente
											ORDER BY valido desc
											";
											$result = doQuery($query_r);
											while (list($valido_t) = mysqli_fetch_array($result))
											{
												$sel = $valido_t == $valido?"selected":"";


												 	if($valido_t == 1){
														echo "<option value=\"$valido_t\" $sel>Si</option>";
													}else{
														echo "<option value=\"$valido_t\" $sel>No</option>";
													}
											}
											?>
										</select>
									  </div>
								</div>

							</div>
							

							


							
							<div class="row">
							<div class="col-md-12 text-center">							
							  <button type="submit"  id ="submit" class="btn btn-primary">Cerca</button>
							</div>
							
						  </div>
						  
					</form>
				
				
				
				
				
				
                <table class="table table-striped table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th width="10%">Codice Cliente</th>
                      <th width="30%">Ragione Sociale</th>
                      <th width="30%">Nome</th>
                      <th width="30%">Cognome</th>
                      <th width="30%">Indirizzo</th>
                      <th width="30%">Località</th>					  
 					  <th width="5%">Provincia</th>
					  <th width="10%">Telefono</th>
					  <th width="10%">Valido</th>
					  <th width="10%">Visualizza</th>
                   </tr>
                  </thead>
                  <tbody>
<?

if($valido==1 or $valido == 0){
	$my_valido = 1;
}else{
	$my_valido = 0;
}


$w_localita = $localita?" AND C.localita =  '$localita' ":"";
$w_provincia = $provincia?" AND C.provincia =  '$provincia' ":"";
$w_valido = $my_valido?" AND C.valido = '$valido' ":"";

$query_r = "
SELECT C.id, C.ragsoc1, C.indirizzo, C.localita, C.provincia, C.tel1, C.email, C.nome, C.cognome, C.valido
FROM cliente C
WHERE 1
$w_valido
$w_localita
$w_provincia
GROUP BY C.id
ORDER BY C.id ASC
";

$result = doQuery($query_r);
while (list($id_cliente_t, $ragsoc1_t, $indirizzo_t, $localita_t, $provincia_t, $tel1_t, $email_t, $nome_t, $cognome_t, $valido_t)= mysqli_fetch_array($result))
{
  $query = "
  SELECT COUNT(id)
  FROM cliente
  WHERE 1
    AND id = '$id_cliente_t'
  ";
  $result_c = doQuery($query);
  list($cnt_cliente_t) = mysqli_fetch_array($result_c);


 

?>
                    <tr>
                      <td align="center"><?=$id_cliente_t?></td>
					  <td align="center"><?=$ragsoc1_t?></td>
					  <td align="center"><?=$nome_t?></td>
					  <td align="center"><?=$cognome_t?></td>
					  <td align="center"><?=$indirizzo_t?></td>
					  <td align="center"><?=$localita_t?></td>
					  <td align="center"><?=$provincia_t?></td>
					  <td align="center"><?=$tel1_t?></td>
					  <? if($valido_t == 1){?> 
 					  <td align="center">Si</td>
					  <?}else{?>
					  <td align="center">No</td>
					  <?}?>
					  <td align="center">
					  <a href="cliente.php?id_cliente=<?=$id_cliente_t?>" class="btn btn-default btn-xs"><i class="icon-eye-open"></i></a>
                      </td> 
					  
                    </tr>
<?
}
?>

                  </tbody>
                </table>
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
<form id="fake" action="cliente.php" method="post">
  <input type="hidden" name="id_cliente" id="id_fake" />
</form>
<form id="fakeDel" action="clienti.php" method="post">
  <input type="hidden" name="todo" id="todo" value="del" />
  <input type="hidden" name="id_cliente" id="id_fakeDel" />
</form>
<?require "inc_footer.php"?>