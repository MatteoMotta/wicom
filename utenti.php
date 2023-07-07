<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?
#### permessi
$req = 1; # admin

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

#utente
if (isset($_REQUEST['id_utente']))
  $id_utente = mysqli_real_escape_string($link,$_REQUEST['id_utente']);
else
  $id_utente = "";
if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";
$msg_ok = "";

if ($id_utente and $todo=="del")
{
  $query = "
  DELETE FROM utente
  WHERE id = '$id_utente'
  ";
  doQuery($query);

  $msg_ok = "Utente rimosso definitivamente";
}

$title = "Utenti";
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
            <h1><i class="icon-utente"></i> Utenti</h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li class="active">Utenti</li>
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
              <h3 class="section-title first-title"><i class="icon-utente"></i> Utenti
               <a href="utente.php" type="button" class="btn" style="float:right"><i class="icon-plus"></i>Aggiungi</a>
              </h3>
              <div class="widget-content-white glossed">
                <div class="padded">
                <table class="table table-striped table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th>Livello</th>
                      <th>Nominativo</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
<?
$query = "
SELECT U.id, U.livello, U.nome, U.email, U.attivo,
       U.data_inserimento
FROM utente U
WHERE 1
  AND U.email != 'mario@mario-online.com'
ORDER BY U.livello
";
$result = doQuery($query);
while (list($id_utente_t, $livello_t, $nome_t, $email_t, $attivo_t,
            $data_inserimento_t)= mysqli_fetch_array($result))
{
  $status_t = $attivo_t?"<button id=\"status_$id_utente_t\" class=\"status label label-success\">Attivo</button>":"<button id=\"status_$id_utente_t\" class=\"status label label-danger\">Non Attivo</button>";

?>
                    <tr>
                      <td><?=$arr_livello[$livello_t]?></td>
                      <td><?=$nome_t?></td>
                      <td><?=$email_t?></td>
                      <td><?=$status_t?></td>
                      <td class="text-center" nowrap>
                        <button id="go_<?=$id_utente_t?>" class="goUtente btn btn-default btn-xs"><i class="icon-pencil"></i></button>
                        &nbsp;&nbsp;
                        <button id="del_<?=$id_utente_t?>" class="delUtente btn btn-danger btn-xs"><i class="icon-remove"></i></button>
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
<form id="fake" action="utente.php" method="post">
  <input type="hidden" name="id_utente" id="id_utente_fake" />
</form>
<form id="fakeDel" action="utenti.php" method="post">
  <input type="hidden" name="todo" id="todo" value="del" />
  <input type="hidden" name="id_utente" id="id_utente_fakeDel" />
</form>
<?require "inc_footer.php"?>