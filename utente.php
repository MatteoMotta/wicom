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
if (isset($_REQUEST['livello']))
  $livello = mysqli_real_escape_string($link,$_REQUEST['livello']);
else
  $livello = "";
if (isset($_REQUEST['nome']))
  $nome = mysqli_real_escape_string($link,$_REQUEST['nome']);
else
  $nome = "";
if (isset($_REQUEST['email']))
  $email = mysqli_real_escape_string($link,$_REQUEST['email']);
else
  $email = "";
if (isset($_REQUEST['password']))
  $password = mysqli_real_escape_string($link,$_REQUEST['password']);
else
  $password = "";
if (isset($_REQUEST['attivo']))
  $attivo = mysqli_real_escape_string($link,$_REQUEST['attivo']);
else
  $attivo = "";

if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";

$msg_ko = $msg_ok = "";

# modifica
if ($todo and $id_utente)
{
  if (!$email)
    $msg_ko .= "E-mail, ";
  elseif (!email_validation($email))
    $msg_ko .= "Verifica E-mail, ";
  elseif (checkGia("utente", "email", $email, $id_utente))
    $msg_ko .= "E-mail già presente, ";

  if ($password and strlen($password)<6)
    $msg_ko .= "Password almeno 6 caratteri, ";

  if (!$nome)
    $msg_ko .= "Nome, ";
//  if (!$name)
//    $msg_ko .= "Cognome, ";

  if (!$msg_ko)
  {
    $sql_password = $password?" password = '".md5(MD5_SALT.$password)."', ":"";
    $query = "
    UPDATE utente SET
    livello = '$livello',
    nome = '$nome',
    email = '$email',
    $sql_password
    attivo = '$attivo'
    WHERE 1
      AND id = '$id_utente'
    ";
    doQuery($query);

    $msg_ok = "Utente modificato correttamente";
  }
}
# inserimento
elseif ($todo and !$id_utente)
{
  if (!$email)
    $msg_ko .= "E-mail, ";
  elseif (!email_validation($email))
    $msg_ko .= "Verifica E-mail, ";
  elseif (checkGia("utente", "email", $email))
    $msg_ko .= "E-mail già presente, ";

  if (!$password)
    $msg_ko .= "Password, ";
  elseif (strlen($password)<6)
    $msg_ko .= "Password almeno 6 caratteri, ";

  if (!$nome)
    $msg_ko .= "Nome, ";
//  if (!$name)
//    $msg_ko .= "Cognome, ";

  if (!$msg_ko)
  {
    $query = "
    INSERT INTO utente SET
    livello = '$livello',
    nome = '$nome',
    email = '$email',
    password = '".md5(MD5_SALT.$password)."',
    attivo = '$attivo',
    id_inserimento = '".$_SESSION["sess_id_utente"]."',
    data_inserimento = NOW()
    ";
    doQuery($query);
    $id_utente = mysqli_insert_id($link);

    $msg_ok = "Utente inserito correttamente";
  }
}

if ($id_utente and !$todo)
{
  $query = "
  SELECT U.id, U.livello, U.nome, U.email, U.attivo
  FROM utente U
  WHERE 1
    AND U.id = '$id_utente'
  ";
  $result = doQuery($query);
  list($id_utente, $livello, $nome, $email, $attivo) = mysqli_fetch_array($result);
}
elseif ($id_utente)
{
  $nome = stripslashes($nome);
  $email = stripslashes($email);
}

$title = "Utente ".($id_utente?" - $nome ":"");
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
            <h1><i class="icon-user"></i> </h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li><a href="utenti.php">Utenti</a></li>
            <li class="active">Utente</li>
          </ol>
          <div class="main-content">

<?if ($msg_ko){?>
<div class="widget">
  <div class="alert alert-danger alert-dismissable">
    <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
    <i class="icon-exclamation-sign"></i>
    <strong>Attenzione!</strong> Verifica <?=substr($msg_ko,0,-2)?>.
  </div>
</div>
<?}?>
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
              <h3 class="section-title first-title"><i class="icon-user"></i><?=$id_utente?"$nome":"Nuovo Utente"?></h3>
              <div class="widget-content-white glossed">
                <div class="padded">
                <form action="utente.php" name="frm" id="frm" method="post" role="form">
                  <input type="hidden" name="id_utente" id="id_utente" value="<?=$id_utente?>">
                  <input type="hidden" name="todo" id="todo" value="do">
                  <h3 class="form-title form-title-first"><i class="icon-terminal"></i><?=$id_utente?"Modifica":"Inserisci"?></h3>

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Attivo?</label><br>
                        <label class="checkbox-inline">
                          <input type="checkbox" id="attivo" name="attivo" value="1" <?=$attivo?"checked":""?>> Attivo
                        </label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label>Livello di accesso</label>
                      <select name="livello" id="livello" class="form-control">
<?
foreach ($arr_livello as $livello_t => $livello_txt_t)
{
  $sel = $livello_t==$livello?"selected":"";
  echo "<option value=\"$livello_t\" $sel>$livello_txt_t</option>\n";
}
?>
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label>*E-mail</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="E-mail" value="<?=$email?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>*Password</label>
                        <input type="text" id="password" name="password" class="form-control" placeholder="Password" value="">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>*Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Nominativo" value="<?=$nome?>">
                      </div>
                    </div>
                  </div>

                  <button id="btnDo" type="submit" class="btn btn-primary">Salva</button>
                  <button type="reset" class="btn btn-default">Annulla</button>
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