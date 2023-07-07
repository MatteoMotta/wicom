<? 
#### permessi
$req = ""; # tutti
$livello_req = ""; # tutti

require "inc_config.php";
require "inc_sicurezza_bo.php";

# loggato
if (isLogged())
{
  header("Location: home.php");
  exit();
}

# ko login
if (isset($_REQUEST['ko']) and $_REQUEST['ko'])
 $ko = mysqli_real_escape_string($link,$_REQUEST['ko']);
else
 $ko = "";

$msg_ko = "";
switch ($ko) {
 	case 1:
 		$msg_ko = "Utente non riconosciuto";
 		break;
 	case 2:
 		$msg_ko = "Utente non attivo";
 		break;
 	case 3:
 		$msg_ko = "Verifica password";
 		break;
 	default:
 	  $msg_ko = "";
 		break;
 }

require "inc_header.php";
?>

<div class="all-wrapper no-menu-wrapper">
  <div class="login-logo-w">
    <a href="<?=BASE_URL?>" class="logo">
      <img src="<?=BASE_URL?>/img/logo-wicom.png">
      <!-- <span><?=SITE_NAME?></span> -->
    </a>
  </div>

  <div class="row">
    <div class="col-md-4 col-md-offset-4">

      <div class="content-wrapper bold-shadow">
        <div class="content-inner <?=$content_inner_class?>">
          <div class="main-content main-content-grey-gradient no-page-header">
            <div class="main-content-inner">
            <form action="#" id="frmLogin" role="form" method="post">
              <h3 class="form-title form-title-first"><i class="icon-lock"></i> Accesso riservato</h3>
              <div class="form-group">
                <label>Username</label>
                <input name="login_email" id="login_email" type="text" class="form-control" placeholder="Codice di accesso" >
              </div>
              <div class="form-group">
                <label>Password</label>
                <input name="login_password" id="login_password" type="password" class="form-control" placeholder="Password">
              </div>
              <div class="text-center">
                <button type="submit" href="#" onclick="$('#frmLogin').submit();return false;" class="btn btn-primary btn-lg">Accedi</button>
                <p class="help-block"><?=$msg_ko?></p>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

<?require "inc_footer.php"?>