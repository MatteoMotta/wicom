<?
require "../inc_config.php";

if (isset($_REQUEST['id_attivita']))
 $id_attivita = mysqli_real_escape_string($link,$_REQUEST['id_attivita']);
else
 $id_attivita = "";

if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";

if ($id_attivita and $todo=="del")
{
  $query = "
  DELETE FROM  attivita
  WHERE 1
    AND id = '$id_attivita'
  ";
  doQuery($query);

  echo "OK";
}
else
  echo "KO";
?>