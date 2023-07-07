<?php

require "inc_config.php";

if (isset($_REQUEST['id_tecnico']))
 $id_tecnico = mysqli_real_escape_string($link,$_REQUEST['id_tecnico']);
else
 $id_tecnico = "";



$query = "
			SELECT T.id
			FROM tecnici T
			where T.id = '$id_tecnico'

			";
			$result = doQuery($query);
			list($id_tecnico)= mysqli_fetch_array($result);
			

if ($id_tecnico)
{
 $query = "
		  UPDATE tecnici
		  SET attivo = 0
		  WHERE 1
			AND id = '$id_tecnico'
		  ";
		  doQuery($query);


    header("location:tecnici.php"); // redirects to all records page
    exit;
	
}
else
  echo "KO";
?>