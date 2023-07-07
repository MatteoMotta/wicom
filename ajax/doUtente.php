<?
require "../inc_config.php";

if (isset($_REQUEST['id_utente']))
 $id_utente = mysqli_real_escape_string($link,$_REQUEST['id_utente']);
else
 $id_utente = "";

if ($id_utente)
{
  $query = "
  SELECT attivo
  FROM utente
  WHERE 1
    AND id = '$id_utente'
  ";
  $result = doQuery($query);
  list($attivo) = mysqli_fetch_array($result);
  if ($attivo)
    $attivo = 0;
  else
    $attivo = 1;

  $query = "
  UPDATE utente SET
  attivo = '$attivo'
  WHERE 1
    AND id = '$id_utente'
  ";
  doQuery($query);

  echo "OK|$attivo";
}
else
  echo "KO";
?>