<?php

require "inc_config.php";

if (isset($_REQUEST['id']))
 $id = mysqli_real_escape_string($link,$_REQUEST['id']);
else
 $id = "";

if (isset($_REQUEST['id_offerta']))
 $id_offerta = mysqli_real_escape_string($link,$_REQUEST['id_offerta']);
else
 $id_offerta = "";



  $query = "
  DELETE FROM articoli_offerta
  WHERE 1
    AND id = '$id'
  ";
  doQuery($query);



    header("location:offerta.php?id_offerta=" .  $id_offerta ); // redirects to all records page
    exit;
	

?>