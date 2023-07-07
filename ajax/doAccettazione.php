<?
require "../inc_config.php";

if (isset($_REQUEST['id_acc']))
 $id_acc = mysqli_real_escape_string($link,$_REQUEST['id_acc']);
else
 $id_acc = "";
if (isset($_REQUEST['attivita_id_attivita']))
 $attivita_id_attivita = mysqli_real_escape_string($link,$_REQUEST['attivita_id_attivita']);
else
 $attivita_id_attivita = "";

if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";

if ($id_acc and $attivita_id_attivita and $todo=="del")
{
  $query = "
  DELETE FROM accettazione
  WHERE 1
    AND id_acc = '$id_acc'
    AND id_att = '$attivita_id_attivita'
  ";
  doQuery($query);

  echo "OK";
}
else
  echo "KO";
?>