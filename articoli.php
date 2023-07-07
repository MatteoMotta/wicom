<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

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

#articolo

if (isset($_REQUEST['valido']))
  $valido = mysqli_real_escape_string($link,$_REQUEST['valido']);
else
  $valido = "";

if (isset($_REQUEST['codice_articolo']))
  $codice_articolo = mysqli_real_escape_string($link,$_REQUEST['codice_articolo']);
else
  $codice_articolo = "";
if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";
$msg_ok = "";

		if ($todo == "doValido")
		{	
				header("location:articoli.php?valido=" .  $valido ); // redirects to all records page
				exit;
			  		
		  
		}

if (isAdmin() and $codice_articolo and $todo=="del")
{
  $query = "
  DELETE FROM articoli
  WHERE 1
    AND codice_articolo = '$codice_articolo'
  ";
  doQuery($query);

  $query = "
  DELETE FROM articoli
  WHERE 1
    AND codice_articolo = '$codice_articolo'
  ";
  doQuery($query);

  $msg_ok = "Articolo rimosso definitivamente";
}

$title = "Articoli";
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
            <h1><i class="icon-group"></i> Articoli</h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li class="active">Articoli</li>
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
              <h3 class="section-title first-title"><i class="icon-group"></i> Articoli			  
              <a href="articolo.php" type="button" class="btn" style="float:right"><i class="icon-plus"></i>Aggiungi</a>
              </h3>
              <div class="widget-content-white glossed">
                <div class="padded">
				
						<form action="articoli.php" name="frmArticoli" id="frmArticoli" method="post" role="form">
							<input type="hidden" name="todo" id="todo" value="doValido">

							<div class="row">

								<div class="col-md-12">
								  <div class="form-group">
									<label>Valido</label>
														
										<select class="form-control selectpicker" id="valido" name ="valido" data-live-search="true" data-none-selected-text>		
												<?
												$query_r = "
												SELECT DISTINCT valido
												FROM articoli
												order by valido desc
												";
												$result = doQuery($query_r);
												while (list($valido_t) = mysqli_fetch_array($result))
												{
													if($valido_t == 1){
														echo "<option value=\"$valido_t\" data-token=\"$valido_t\" $sel>Si</option>";
													}else{
														echo "<option value=\"$valido_t\" data-token=\"$valido_t\" $sel>No</option>";
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
                      <th>Codice Articolo</th>
                      <th>Descrizione</th>
                      <th>Unità di misura</th>
                      <th>Venduti</th>
					  <th>Valido</th>
                    </tr>
                  </thead>
                  <tbody>
<?

$query = "
SELECT A.id_articolo,A.codice_articolo, A.descrizione, A.um, A.valido, (SELECT if(sum(qta) is null, 0, sum(qta)) FROM articoli_offerta WHERE codice_articolo = A.codice_articolo)
FROM articoli A
WHERE 1
AND A.valido = '$valido'
GROUP BY A.codice_articolo
ORDER BY A.codice_articolo ASC
";
$result = doQuery($query);
while (list($id_articolo_t, $codice_articolo_t, $descrizione_t, $um_t, $valido_t, $venduti_t)= mysqli_fetch_array($result))
{
  $query = "
  SELECT COUNT(codice_articolo)
  FROM articoli
  WHERE 1
    AND codice_articolo = '$codice_articolo_t'
  ";
  $result_c = doQuery($query);
  list($cnt_attivita_t) = mysqli_fetch_array($result_c);


 

?>
                    <tr>
                      <td align="center"><a href="articolo.php?id_articolo=<?=$id_articolo_t?>"><?=$codice_articolo_t?></a></td>
					  <td align="center"><?=$descrizione_t?></td>
 					  <td align="center"><?=$um_t?></td>
 					  <td align="center"><?=$venduti_t?></td>
					  <? if($valido_t == 1){?> 
 					  <td align="center">Si</td>
					  <?}else{?>
					  <td align="center">No</td>
					  <?}?>
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
<form id="fake" action="articolo.php" method="post">
  <input type="hidden" name="codice_articolo" id="codice_articolo_fake" />
</form>
<form id="fakeDel" action="articoli.php" method="post">
  <input type="hidden" name="todo" id="todo" value="del" />
  <input type="hidden" name="codice_articolo" id="codice_articolo_fakeDel" />
</form>
<?require "inc_footer.php"?>