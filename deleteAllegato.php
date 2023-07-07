<?php

require "inc_config.php";

if (isset($_REQUEST['id_allegato']))
 $id_allegato = mysqli_real_escape_string($link,$_REQUEST['id_allegato']);
else
 $id_allegato = "";



$query = "
			SELECT C.id
			FROM allegati AL
			inner join cliente C on C.id = AL.id_cliente
			where AL.id = '$id_allegato'

			";
			$result = doQuery($query);
			list($id_cliente_t)= mysqli_fetch_array($result);
			

if ($id_allegato)
{

  $query = "
  DELETE FROM allegati
  WHERE 1
    AND id = '$id_allegato'
  ";
  doQuery($query);

    header("location:cliente.php?id_cliente=".$id_cliente); // redirects to all records page
    exit;
	
}
else
  echo "KO";
?>