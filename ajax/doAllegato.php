<?
require "../inc_config.php";

if (isset($_REQUEST['id_allegato']))
 $id_allegato = mysqli_real_escape_string($link,$_REQUEST['id_allegato']);
else
 $id_allegato = "";

if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";

if ($id_allegato and $todo=="del")
{

  $query = "
  DELETE FROM allegati
  WHERE 1
    AND id = '$id_allegato'
  ";
  doQuery($query);

  echo "OK";
}
else
  echo "KO";
?>