<?php

require "inc_config.php";

if (isset($_REQUEST['id_allegato']))
 $id_allegato = mysqli_real_escape_string($link,$_REQUEST['id_allegato']);
else
 $id_allegato = "";



$query = "
			SELECT A.codice_articolo
			FROM allegatiArticoli AL
			inner join articoli A on A.codice_articolo = AL.codice_articolo
			where AL.id = '$id_allegato'

			";
			$result = doQuery($query);
			list($codice_articolo_t)= mysqli_fetch_array($result);
			

if ($id_allegato)
{

  $query = "
  DELETE FROM allegatiArticoli
  WHERE 1
    AND id = '$id_allegato'
  ";
  doQuery($query);

    header("location:articolo.php?codice_articolo=".$codice_articolo_t); // redirects to all records page
    exit;
	
}
else
  echo "KO";
?>