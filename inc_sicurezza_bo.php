<?
$ko = "0";

if (0)
{
  echo "<pre>";
  print_r($_REQUEST);
  print_r($_SESSION);
  echo "</pre>";
  //exit();
}

if (isset($_GET["logout"]))
{
	$_SESSION = array();
	header("Location: index.php");
	exit();
}

if (!isLogged())
{
	if (isset($_POST['login_email']))
	 $login_email = mysqli_real_escape_string($link,$_POST['login_email']);
	else
	 $login_email = "";
	if (isset($_POST['login_password']))
	 $login_password = mysqli_real_escape_string($link,$_POST['login_password']);
	else
	 $login_password = "";

	# authenticaion
	if ($login_email and $login_password)
	{
	  # be users
	  $query = "
	  SELECT U.id, U.nome, U.livello, U.password, U.attivo, U.id_nazione
	  FROM utente U
	  WHERE email = '$login_email'
	  LIMIT 1
	  ";
	  $result = doQuery($query);
	  list($id_utente, $nome, $livello, $password_, $attivo, $id_nazione_str)= mysqli_fetch_array($result);
	  if ($id_utente)
	  {
	    # active?
      if (!$attivo)
        $ko = 2;
      # password
      elseif (md5(MD5_SALT.$login_password) != $password_)
        $ko = 3;
      else
      {
  	    $_SESSION['sess_id_utente'] = $id_utente;
  	    $_SESSION['sess_livello'] = $livello;
  	    $_SESSION['sess_utente'] = ucwords($nome);
        if ($id_nazione_str)
        {
          $_SESSION["sess_nazioni_str"] = $id_nazione_str;
          $_SESSION["sess_nazioni_arr"] = explode(",", $id_nazione_str);
        }
        else
        {
          $_SESSION["sess_nazioni_str"] = "";
  	      $_SESSION["sess_nazioni_arr"] = array();
        }

        # OK
  	    header("Location: home.php");
  	    exit();
      }
	  }
	  else
	   $ko = 1;

	  if ($ko)
	  {
    	$_SESSION = array();
    	header("Location: index.php?ko=$ko");
    	exit;
	  }
	}
}

### not able to see that page
if (isset($req) and $req and
   (!isset($_SESSION['sess_livello']) or $_SESSION['sess_livello'] > $req)
    )
{
	#print_r($_SESSION);
	header("Location: index.php?koP");
	exit;
}
?>
