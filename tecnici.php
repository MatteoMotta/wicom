<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<?
#### permessi
$req = 12; # admin

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

#tecnici
if (isset($_REQUEST['id_tecnico']))
  $id_tecnico = mysqli_real_escape_string($link,$_REQUEST['id_tecnico']);
else
  $id_tecnico = "";
if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";
$msg_ok = "";

if (isAdmin() and $id_tecnico and $todo=="del")
{
  $query = "
  DELETE FROM tecnici
  WHERE 1
    AND id = '$id_tecnico'
  ";
  doQuery($query);

  $query = "
  DELETE FROM tecnici
  WHERE 1
    AND id = '$id_tecnico'
  ";
  doQuery($query);

  $msg_ok = "Tecnico rimosso definitivamente";
}

$title = "Tecnici";
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
            <h1><i class="icon-group"></i> Tecnici</h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li class="active">Tecnici</li>
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
              <h3 class="section-title first-title"><i class="icon-group"></i> Tecnici
              <a href="tecnico.php" type="button" class="btn" style="float:right"><i class="icon-plus"></i>Aggiungi</a>
              <?
              if($_SESSION["sess_nazioni_arr"])
              {
                echo "( solo in ";
                foreach ($_SESSION["sess_nazioni_arr"] as $id_nazione_t)
                  echo getSecco("nazione", $id_nazione_t)." ";
                echo " ) ";
              }
              ?>
              </h3>
              <div class="widget-content-white glossed">
                <div class="padded">
                <table class="table table-striped table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nome</th>
					  <th>Cognome</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
<?

$query = "
SELECT T.id, T.nome, T.cognome
FROM tecnici T
WHERE 1
and attivo = 1
GROUP BY T.id
ORDER BY T.id DESC
";
$result = doQuery($query);
while (list($id_tecnico_t, $nome_t, $cognome_t)= mysqli_fetch_array($result))
{
  $query = "
  SELECT COUNT(id)
  FROM tecnici
  WHERE 1
    AND id = '$id_tecnico_t'
	and attivo = 1
  ";
  $result_c = doQuery($query);
  list($cnt_tecnici_t) = mysqli_fetch_array($result_c);


 

?>
                    <tr>
                      <td align="center"><?=$id_tecnico_t?></td>
					  <td align="center"><?=$nome_t?></td>
					  <td align="center"><?=$cognome_t?></td>
					  


<?if (0){?>

<?}?>
                      <td class="text-center" nowrap>
					  <a href="tecnico.php?id_tecnico=<?=$id_tecnico_t?>" class="btn btn-default btn-xs"><i class="icon-pencil"></i></a>
                        <?if (isAdmin()){?>
                          &nbsp;&nbsp;							
							<a href="deleteTecnico.php?id_tecnico=<?=$id_tecnico_t?>" onclick="return confirm('Vuoi davvero eliminare questo tecnico?')">	
								<button class="del btn btn-danger btn-xs" id="del" ><i class="icon-remove"></i></button>
							</a>
                        <?}?>

                        <br /><br />
                        <!--<button onclick="window.open('scheda_cliente.php?id_tecnico=<?/*=$id_tecnico_t*/?>','scheda_<?/*=$id_tecnico_t*/?>','width=600, height=800,toolbar=no,scrollbars=yes,resizable=yes');return false" class="btn btn-success btn"><i class="icon-user"></i></button>-->
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
<form id="fake" action="tecnico.php" method="post">
  <input type="hidden" name="id_tecnico" id="id_tecnico_fake" />
</form>
<form id="fakeDel" action="tecnici.php" method="post">
  <input type="hidden" name="todo" id="todo" value="del" />
  <input type="hidden" name="id_tecnico" id="id_tecnico_fakeDel" />
</form>
<?require "inc_footer.php"?>