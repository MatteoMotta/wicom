<?
require "../inc_config.php";

if (isset($_REQUEST['id_tecnico']))
 $id_tecnico = mysqli_real_escape_string($link,$_REQUEST['id_tecnico']);
else
 $id_tecnico = "";

if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";

if ($id_tecnico and $todo=="del")
{

  $query = "
  DELETE FROM tecnici
  WHERE 1
    AND id = '$id_tecnico'
  ";
  doQuery($query);

  echo "OK";
}
else
  echo "KO";
?>