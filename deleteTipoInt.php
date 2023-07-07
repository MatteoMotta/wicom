<?php

require "inc_config.php";

if (isset($_REQUEST['id']))
 $id = mysqli_real_escape_string($link,$_REQUEST['id']);
else
 $id = "";

if (isset($_REQUEST['ticket_id_ticket']))
 $ticket_id_ticket = mysqli_real_escape_string($link,$_REQUEST['ticket_id_ticket']);
else
 $ticket_id_ticket = "";

if (isset($_REQUEST['id_report']))
 $id_report = mysqli_real_escape_string($link,$_REQUEST['id_report']);
else
 $id_report = "";



unset($_SESSION['tipoIntervento'][$id]);


    header("location:report.php?ticket_id_ticket=" .  $ticket_id_ticket . "&id_report=" . $id_report . "#tipointervento"); // redirects to all records page
    exit;
	

?>